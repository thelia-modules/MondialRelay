<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

declare(strict_types=1);

namespace MondialRelay\EventListeners;

use MondialRelay\ApiClient;
use MondialRelay\BussinessHours\BussinessHours;
use MondialRelay\Event\FindRelayEvent;
use MondialRelay\Event\MondialRelayEvents;
use MondialRelay\Model\MondialRelayDeliveryPriceQuery;
use MondialRelay\Model\MondialRelayPickupAddress;
use MondialRelay\Model\MondialRelayPickupAddressQuery;
use MondialRelay\Model\MondialRelayZoneConfiguration;
use MondialRelay\Model\MondialRelayZoneConfigurationQuery;
use MondialRelay\MondialRelay;
use MondialRelay\Point\Point;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Delivery\DeliveryPostageEvent;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Core\Translation\Translator;
use Thelia\Exception\TheliaProcessException;
use Thelia\Model\AreaDeliveryModule;
use Thelia\Model\AreaDeliveryModuleQuery;
use Thelia\Model\CountryArea;
use Thelia\Model\CountryAreaQuery;
use Thelia\Model\CountryQuery;
use Thelia\Model\ModuleQuery;
use Thelia\Model\OrderAddress;
use Thelia\Model\OrderAddressQuery;

require __DIR__ . "/../vendor/autoload.php";

class DeliveryListener extends BaseAction implements EventSubscriberInterface
{
    /** @var RequestStack */
    protected $requestStack;

    /**
     * DeliveryPostageListener constructor.
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    protected function makeHoraire($str)
    {
        return substr($str, 0, 2) . ':' . substr($str, 2);
    }

    /**
     * @param FindRelayEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     * @throws \Exception
     */
    public function findRelays(FindRelayEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $days = [
            'monday' => Translator::getInstance()->trans("Monday"),
            'tuesday' => Translator::getInstance()->trans("Tuesday"),
            'wednesday' => Translator::getInstance()->trans("Wednesday"),
            'thursday' => Translator::getInstance()->trans("Thursday"),
            'friday' => Translator::getInstance()->trans("Friday"),
            'saturday' => Translator::getInstance()->trans("Saturday"),
            'sunday' => Translator::getInstance()->trans("Sunday")
        ];

        $points = [];

        if (null !== $country = CountryQuery::create()->findPk($event->getCountryId())) {
            $apiClient = new ApiClient(
                new \SoapClient(MondialRelay::getConfigValue(MondialRelay::WEBSERVICE_URL)),
                MondialRelay::getConfigValue(MondialRelay::CODE_ENSEIGNE),
                MondialRelay::getConfigValue(MondialRelay::PRIVATE_KEY)
            );

            $session = $this->requestStack->getCurrentRequest()?->getSession();
            $cartWeight = $session instanceof Session ? $session->getSessionCart($dispatcher)->getWeight() : 0;
            $cartWeightInGrammes = 1000 * $cartWeight;

            $requestParams = [
                'NumPointRelais' => $event->getNumPointRelais(),
                'Pays' => strtoupper($country->getIsoalpha2()),
                'Ville' => $event->getCity(),
                'CP' => $event->getZipcode(),
                //'Latitude' => "",
                //'Longitude' => "",
                //'Taille' => "",
                'Poids' => $cartWeightInGrammes,
                //'Action' => "",
                //'DelaiEnvoi' => "0",
                'RayonRecherche' => $event->getSearchRadius()
            ];

            try {
                $points = $apiClient->findDeliveryPoints($requestParams);
            } catch (\Exception $ex) {
                $points = [];

                $event->setError($ex->getMessage());
            }
        }

        $normalizedPoints = [];

        /** @var Point $point */
        foreach ($points as $point) {
            $normalizedPoint = [
                'id' => $point->id(),
                'latitude' => $point->latitude(),
                'longitude' => $point->longitude(),
                'zipcode' => $point->cp(),
                'city' => $point->city(),
                'country' => $point->country(),
                // The bundled Mondial Relay SOAP client does not expose a distance value.
                'distance' => null,
                'distance_km' => null
            ];

            $addresses = $point->address();

            $nom = $addresses[0];
            if (! empty($addresses[1])) {
                $nom .= '<br> ' . $addresses[1];
            }

            $normalizedPoint["name"] = $nom;

            $address = $addresses[2];
            if (! empty($addresses[3])) {
                $address .= '<br> ' . $addresses[3];
            }

            $normalizedPoint["address"] = $address;


            $horaires = [];

            /** @var BussinessHours $horaire */
            foreach ($point->business_hours() as $horaire) {
                if ($horaire->openingTime1() != '0000' && $horaire->openingTime2() !== '0000') {
                    $data = [ 'day' => $days[$horaire->day()]];

                    $o1 = $horaire->openingTime1();
                    $o2 = $horaire->openingTime2();

                    if (! empty($o1) && $o1 != '0000') {
                        $data['opening_time_1'] = $this->makeHoraire($horaire->openingTime1());
                        $data['closing_time_1'] = $this->makeHoraire($horaire->closingTime1());
                    }

                    if (! empty($o2) && $o2 != '0000') {
                        $data['opening_time_2'] = $this->makeHoraire($horaire->openingTime2());
                        $data['closing_time_2'] = $this->makeHoraire($horaire->closingTime2());
                    }

                    $horaires[] = $data;
                }
            }

            $normalizedPoint["openings"] = $horaires;

            $normalizedPoints[] = $normalizedPoint;
        }

        $event->setPoints($normalizedPoints);
    }

    /**
     * Update the order delivery address with the selected Mondial Relay point.
     * The selection comes either from the Flexy front ('pickup' session key, a serialized
     * DeliveryPickupLocation) or from the legacy Smarty front (MondialRelayPickupAddress record).
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function updateOrderDeliveryAddress(OrderEvent $event): void
    {
        if ($event->getOrder()->getDeliveryModuleId() !== MondialRelay::getModuleId()) {
            return;
        }

        $session = $this->requestStack->getCurrentRequest()?->getSession();
        if (!$session instanceof Session) {
            return;
        }

        if (null === $orderAddress = OrderAddressQuery::create()->findPk($event->getOrder()->getDeliveryOrderAddressId())) {
            return;
        }

        // Flexy front: the selected DeliveryPickupLocation is stored in the 'pickup' session key.
        $pickup = $session->get('pickup');
        if (\is_array($pickup) && isset($pickup['address']) && \is_array($pickup['address'])) {
            $address = $pickup['address'];
            $this->applyRelayToAddress($orderAddress, [
                'name' => (string) ($address['title'] ?? $address['company'] ?? ($pickup['title'] ?? '')),
                'id' => (string) ($pickup['id'] ?? ''),
                'address' => (string) ($address['address1'] ?? ''),
                'zipcode' => (string) ($address['zipCode'] ?? ''),
                'city' => (string) ($address['city'] ?? ''),
                'country' => (string) ($address['countryCode'] ?? ''),
            ]);

            return;
        }

        // Legacy Smarty front: relay data stored in a MondialRelayPickupAddress record.
        if (null !== $mrAddressId = $session->get(MondialRelay::SESSION_SELECTED_PICKUP_RELAY_ID)) {
            if (null !== $mrRelayPickup = MondialRelayPickupAddressQuery::create()->findPk($mrAddressId)) {
                $relayData = json_decode((string) $mrRelayPickup->getJsonRelayData(), true);
                if (\is_array($relayData)) {
                    $this->applyRelayToAddress($orderAddress, [
                        'name' => (string) ($relayData['name'] ?? ''),
                        'id' => (string) ($relayData['id'] ?? ''),
                        'address' => (string) ($relayData['address'] ?? ''),
                        'zipcode' => (string) ($relayData['zipcode'] ?? ''),
                        'city' => (string) ($relayData['city'] ?? ''),
                        'country' => (string) ($relayData['country'] ?? ''),
                    ]);

                    $mrRelayPickup->setOrderAddressId($orderAddress->getId())->save();
                }
            }
        }
    }

    /**
     * @param array{name: string, id: string, address: string, zipcode: string, city: string, country: string} $relay
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    private function applyRelayToAddress(OrderAddress $orderAddress, array $relay): void
    {
        // Guard: an unknown/empty country code would set a null country and break the NOT NULL FK on save.
        $country = CountryQuery::create()->findOneByIsoalpha2($relay['country']);
        if (null === $country) {
            return;
        }

        $orderAddress
            ->setCompany($relay['name'])
            ->setFirstname(
                Translator::getInstance()->trans(
                    'Pickup relay #%number',
                    ['%number' => $relay['id']],
                    MondialRelay::DOMAIN_NAME
                )
            )
            ->setLastname('')
            ->setAddress1($relay['address'])
            ->setAddress2('')
            ->setAddress3('')
            ->setZipcode($relay['zipcode'])
            ->setCity($relay['city'])
            ->setCountry($country)
            ->save();
    }

    /**
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function updateCurrentDeliveryAddress(OrderEvent $event, $eventName, EventDispatcherInterface $dispatcher): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            return;
        }

        $session = $request->getSession();

        // Reset stored legacy pickup address, if any (kept, so a customer restarting an order is clean).
        $session->remove(MondialRelay::SESSION_SELECTED_PICKUP_RELAY_ID);

        if ($event->getDeliveryModule() == MondialRelay::getModuleId()) {
            // Flexy front: the selection is already stored in the 'pickup' session by the LiveComponent.
            if ($session->get('pickup')) {
                return;
            }

            // Check selected MondialRelay mode (legacy Smarty front)
            $mode = $request->get('mondial-relay-selected-delivery-mode');

            if ($mode == 'pickup') {
                // Get the selected pickup relay
                if (null !== $relayId = $request->get('mondialrelay_relay', null)) {
                    $countryId = $request->get('mondial_relay_country_id', 0);

                    // Load pickup data for the selected point
                    $relayDataEvent = new FindRelayEvent($countryId, '', '', 0);
                    $relayDataEvent->setNumPointRelais($relayId);

                    $dispatcher->dispatch($relayDataEvent, MondialRelayEvents::FIND_RELAYS);

                    // We're supposed to get only one point
                    $points = $relayDataEvent->getPoints();

                    if (isset($points[0])) {
                        // Create a new record to store the pickup data
                        $pickupAddress = new MondialRelayPickupAddress();
                        $pickupAddress
                            ->setJsonRelayData(json_encode($points[0]))
                            ->save();

                        $session->set(MondialRelay::SESSION_SELECTED_PICKUP_RELAY_ID, $pickupAddress->getId());
                    }
                } else {
                    throw new TheliaProcessException("No Mondial Relay pickeup relay selected.");
                }
            } elseif ($mode !== 'home') {
                throw new TheliaProcessException("Mondial Relay delivery mode was not selected.");
            }
        }
    }

    /**
     * Clear stored information once the order has been processed.
     *
     * @param OrderEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function clearDeliveryData(OrderEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();

        // Clear the session context
        $session->remove(MondialRelay::SESSION_SELECTED_DELIVERY_TYPE);
        $session->remove(MondialRelay::SESSION_SELECTED_PICKUP_RELAY_ID);
    }

    public static function getSubscribedEvents(): array
    {
        // Postage/validity are now computed by MondialRelay::getPostage()/isValidDelivery() (T3).
        return [
            TheliaEvents::ORDER_SET_DELIVERY_MODULE => ['updateCurrentDeliveryAddress', 64],
            TheliaEvents::ORDER_BEFORE_PAYMENT => ['updateOrderDeliveryAddress', 256],
            TheliaEvents::ORDER_CART_CLEAR => ['clearDeliveryData', 256],

            MondialRelayEvents::FIND_RELAYS => [ "findRelays" , 128]
        ];
    }
}
