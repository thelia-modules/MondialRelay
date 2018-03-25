<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

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

    protected function getWebServiceClient()
    {
        return new ApiClient(
            new \SoapClient(
                MondialRelay::getConfigValue(MondialRelay::WEBSERVICE_URL)
            ),
            MondialRelay::getConfigValue(MondialRelay::CODE_ENSEIGNE),
            MondialRelay::getConfigValue(MondialRelay::PRIVATE_KEY)
        );
    }

    /**
     * @param DeliveryPostageEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function processDeliveryPostageEvent(DeliveryPostageEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $valid = false;

        /** @var Request $session */
        $request = $this->requestStack->getCurrentRequest();

        /** @var Session $session */
        $session = $request->getSession();

        // Get and store selected delivery type, if it is defined
        switch($request->get('mondial-relay-selected-delivery-mode')) {
            case 'pickup':
                $selectedDeliveryType = MondialRelayZoneConfiguration::RELAY_DELIVERY_TYPE;
                break;
            case 'home':
                $selectedDeliveryType = MondialRelayZoneConfiguration::HOME_DELIVERY_TYPE;
                break;
            default:
                $selectedDeliveryType = $session->get(MondialRelay::SESSION_SELECTED_DELIVERY_TYPE);
        }

        if (null !== $selectedDeliveryType) {
            $session->set(MondialRelay::SESSION_SELECTED_DELIVERY_TYPE, $selectedDeliveryType);
        }

        $weight = $session->getSessionCart($dispatcher)->getWeight();

        if ($weight <= MondialRelay::MAX_WEIGHT_KG) {
            $moduleModel = ModuleQuery::create()->findOneByCode(MondialRelay::getModuleCode());

            // Find all allowed delivery types for the destination country
            $countryHasRelay = $countryHasHome = false;

            $countryInAreaList = CountryAreaQuery::findByCountryAndState($event->getCountry(), $event->getState());

            $price = PHP_INT_MAX;

            /** @var CountryArea $countryInArea */
            foreach ($countryInAreaList as $countryInArea) {
                $areas = AreaDeliveryModuleQuery::create()->filterByAreaId($countryInArea->getAreaId())
                    ->filterByModule($moduleModel)
                    ->find();

                /** @var AreaDeliveryModule $area */
                foreach ($areas as $area) {
                    if (null !== $zoneConfig = MondialRelayZoneConfigurationQuery::create()->findOneByAreaId($area->getAreaId())) {
                        $zoneDeliveryType = $zoneConfig->getDeliveryType();

                        switch ($zoneDeliveryType) {
                            case MondialRelayZoneConfiguration::ALL_DELIVERY_TYPE:
                                $countryHasRelay = $countryHasHome = true;
                                break;
                            case MondialRelayZoneConfiguration::HOME_DELIVERY_TYPE:
                                $countryHasHome = true;
                                break;
                            case MondialRelayZoneConfiguration::RELAY_DELIVERY_TYPE:
                                $countryHasRelay = true;
                                break;
                        }
                    }

                    // If the area delivery type matches the selected one, or if no zone is selected
                    if (null === $selectedDeliveryType || $zoneDeliveryType === $selectedDeliveryType) {
                        // Check if we have a price slice
                        if (null !== $deliveryPrice = MondialRelayDeliveryPriceQuery::create()
                                ->filterByAreaId($area->getAreaId())
                                ->filterByMaxWeight($weight, Criteria::GREATER_EQUAL)
                                ->orderByMaxWeight(Criteria::ASC)
                                ->findOne()) {
                            $price = min($price, $deliveryPrice->getPriceWithTax());

                            $deliveryDelay = $zoneConfig->getDeliveryTime();
                        }
                    }
                }
            }

            $relayAllowed = MondialRelay::getConfigValue(MondialRelay::ALLOW_RELAY_DELIVERY, true);
            $homeAllowed = MondialRelay::getConfigValue(MondialRelay::ALLOW_HOME_DELIVERY, true);

            if (($countryHasHome && $homeAllowed) || ($countryHasRelay && $relayAllowed) && $price !== PHP_INT_MAX) {
                // The module could be used !
                $valid = true;

                $deliveryDate = (new \DateTime())->add(new \DateInterval("P" . $deliveryDelay . "D"));

                $event
                    ->setPostage($price)
                    ->setDeliveryDate($deliveryDate);
            }
        }

        $event->setValidModule($valid);

        $event->stopPropagation();
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

            $cartWeightInGrammes = 1000 * $this->requestStack
                ->getCurrentRequest()
                ->getSession()
                ->getSessionCart($dispatcher)
                ->getWeight();

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
                'distance' => $point->distance(),
                'distance_km' => round($point->distance() / 1000, 1)
            ];

            $addresses = $point->address();

            $nom = $addresses[0];
            if (! empty($adresses[1])) {
                $nom .= '<br> ' . $addresses[1];
            }

            $normalizedPoint["name"] = $nom;

            $address = $addresses[2];
            if (! empty($adresses[3])) {
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
     * Update the order delivery address with MondialRelay point data
     *
     * @param OrderEvent $event
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function updateOrderDeliveryAddress(OrderEvent $event)
    {
        /** @var Session $session */
        $session = $this->requestStack->getCurrentRequest()->getSession();

        if (null !== $mrAddressId = $session->get(MondialRelay::SESSION_SELECTED_PICKUP_RELAY_ID)) {
            if (null !== $mrRelayPickup = MondialRelayPickupAddressQuery::create()->findPk($mrAddressId)) {
                if (false !== $relayData = json_decode($mrRelayPickup->getJsonRelayData(), true)) {
                    if (null !== $orderAddress = OrderAddressQuery::create()->findPK($event->getOrder()->getDeliveryOrderAddressId())) {
                        $orderAddress
                            ->setCompany($relayData['name'])
                            ->setFirstname(
                                Translator::getInstance()->trans(
                                    "Pickup relay #%number",
                                    [ '%number' => $relayData['id']],
                                    MondialRelay::DOMAIN_NAME
                                )
                            )
                            ->setLastname('')
                            ->setAddress1($relayData['address'])
                            ->setAddress2('')
                            ->setAddress3('')
                            ->setZipcode($relayData['zipcode'])
                            ->setCity($relayData['city'])
                            ->setCountry(CountryQuery::create()->findOneByIsoalpha2($relayData['country']))
                            ->save();

                        $mrRelayPickup
                            ->setOrderAddressId($orderAddress->getId())
                            ->save();
                    }
                }
            }
        }
    }

    /**
     * @param OrderEvent $event
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function updateCurrentDeliveryAddress(OrderEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var Session $session */
        $session = $request->getSession();

        // Reset stored pickup address, if any
        if (null !== $mrAddressId = $session->remove(MondialRelay::SESSION_SELECTED_PICKUP_RELAY_ID)) {
            // Do not delete, as the customer may have do a back, and restart another order
            // MondialRelayPickupAddressQuery::create()->filterById($mrAddressId)->delete();
        }

        if ($event->getDeliveryModule() == MondialRelay::getModuleId()) {
            // Check selected MondialRlay mode
            $mode = $request->get('mondial-relay-selected-delivery-mode');

            if ($mode == 'pickup') {
                // Get the selected pickup relay
                if (null !== $relayId = $request->get('mondialrelay_relay', null)) {
                    $countryId = $request->get('mondial_relay_country_id', 0);

                    // Load pickup data for the selected point
                    $relayDataEvent = new FindRelayEvent($countryId, '', '', 0);
                    $relayDataEvent->setNumPointRelais($relayId);

                    $dispatcher->dispatch(MondialRelayEvents::FIND_RELAYS, $relayDataEvent);

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

    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::getModuleEvent(
                TheliaEvents::MODULE_DELIVERY_GET_POSTAGE,
                MondialRelay::getModuleCode()
            ) => [ "processDeliveryPostageEvent", 128 ],
            TheliaEvents::ORDER_SET_DELIVERY_MODULE => ['updateCurrentDeliveryAddress', 64],
            TheliaEvents::ORDER_BEFORE_PAYMENT => ['updateOrderDeliveryAddress', 256],
            TheliaEvents::ORDER_CART_CLEAR => ['clearDeliveryData', 256],

            MondialRelayEvents::FIND_RELAYS => [ "findRelays" , 128]
        ];
    }
}
