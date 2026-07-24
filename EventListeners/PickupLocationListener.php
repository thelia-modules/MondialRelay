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
use MondialRelay\MondialRelay;
use MondialRelay\Point\Point;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Api\Resource\DeliveryPickupLocation;
use Thelia\Api\Resource\PickupLocationAddress;
use Thelia\Core\Event\Delivery\PickupLocationEvent;
use Thelia\Core\Event\TheliaEvents;

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Feeds the native Thelia 3 pickup-location API (consumed by the Flexy PickupPointSearch
 * component) with Mondial Relay relay points fetched from the SOAP web service.
 * Replaces the legacy FindRelayEvent / MapManagement controller for the Flexy front.
 */
class PickupLocationListener implements EventSubscriberInterface
{
    /** @var array<int, string> ISO day index (0 = monday) to Mondial Relay business-hours key. */
    private const DAY_KEYS = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public function getPickupLocations(PickupLocationEvent $event): void
    {
        $moduleIds = $event->getModuleIds();
        if (!empty($moduleIds) && !\in_array(MondialRelay::getModuleId(), $moduleIds, true)) {
            return;
        }

        $country = $event->getCountry();
        if (null === $country) {
            return;
        }

        try {
            $apiClient = new ApiClient(
                new \SoapClient(MondialRelay::getConfigValue(MondialRelay::WEBSERVICE_URL)),
                MondialRelay::getConfigValue(MondialRelay::CODE_ENSEIGNE),
                MondialRelay::getConfigValue(MondialRelay::PRIVATE_KEY)
            );

            $points = $apiClient->findDeliveryPoints([
                'NumPointRelais' => '',
                'Pays' => strtoupper((string) $country->getIsoalpha2()),
                'Ville' => (string) $event->getCity(),
                'CP' => (string) $event->getZipCode(),
                'Poids' => max(1, (int) $event->getOrderWeight()),
                'RayonRecherche' => $event->getRadius() ?? 30,
            ]);
        } catch (\Throwable) {
            return;
        }

        /** @var Point $point */
        foreach ($points as $point) {
            $addresses = $point->address();

            $address = new PickupLocationAddress();
            $address
                ->setId((string) $point->id())
                ->setTitle((string) ($addresses[0] ?? ''))
                ->setAddress1((string) ($addresses[2] ?? $addresses[0] ?? ''))
                ->setAddress2((string) ($addresses[3] ?? ''))
                ->setAddress3('')
                ->setZipCode((string) $point->cp())
                ->setCity((string) $point->city())
                ->setCountryCode((string) $point->country());

            $location = new DeliveryPickupLocation();
            $location
                ->setId((string) $point->id())
                ->setLatitude((float) $point->latitude())
                ->setLongitude((float) $point->longitude())
                ->setTitle((string) ($addresses[0] ?? $point->id()))
                ->setModuleId(MondialRelay::getModuleId())
                ->setModuleOptionCode(MondialRelay::getModuleCode())
                ->setAddress($address);

            $this->appendOpeningHours($location, $point);

            $event->appendLocation($location);
        }
    }

    private function appendOpeningHours(DeliveryPickupLocation $location, Point $point): void
    {
        foreach ($point->business_hours() as $businessHours) {
            if (!$businessHours instanceof BussinessHours) {
                continue;
            }

            $day = array_search($businessHours->day(), self::DAY_KEYS, true);
            if (false === $day) {
                continue;
            }

            $slots = [];
            if (!empty($businessHours->openingTime1()) && '0000' !== $businessHours->openingTime1()) {
                $slots[] = $this->formatHour($businessHours->openingTime1()).'-'.$this->formatHour($businessHours->closingTime1());
            }
            if (!empty($businessHours->openingTime2()) && '0000' !== $businessHours->openingTime2()) {
                $slots[] = $this->formatHour($businessHours->openingTime2()).'-'.$this->formatHour($businessHours->closingTime2());
            }

            $location->setOpeningHours($day, implode(', ', $slots));
        }
    }

    private function formatHour(string $value): string
    {
        return substr($value, 0, 2).':'.substr($value, 2);
    }

    public static function getSubscribedEvents(): array
    {
        $listenedEvents = [];

        if (class_exists(PickupLocationEvent::class)) {
            $listenedEvents[TheliaEvents::MODULE_DELIVERY_GET_PICKUP_LOCATIONS] = ['getPickupLocations', 128];
        }

        return $listenedEvents;
    }
}
