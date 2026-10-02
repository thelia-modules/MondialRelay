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

use MondialRelay\MondialRelay;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Api\Bridge\Propel\Event\DeliveryModuleOptionEvent;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Api\Resource\DeliveryModuleOption;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\Base\ModuleQuery;
use Thelia\Model\OrderPostage;

/**
 * Exposes the Mondial Relay delivery option to the Thelia 3 API (consumed by the Flexy checkout).
 */
class ApiListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function getDeliveryModuleOptions(DeliveryModuleOptionEvent $deliveryModuleOptionEvent): void
    {
        if ($deliveryModuleOptionEvent->getModule()->getId() !== MondialRelay::getModuleId()) {
            return;
        }

        $session = $this->requestStack->getCurrentRequest()?->getSession();
        $locale = $session instanceof Session ? $session->getLang()->getLocale() : null;

        $propelModule = ModuleQuery::create()
            ->filterById(MondialRelay::getModuleId())
            ->findOne()
            ?->setLocale($locale);

        $isValid = true;
        $postage = 0.0;
        $postageTax = 0.0;

        try {
            $module = $propelModule?->getModuleInstance($this->container);
            $country = $deliveryModuleOptionEvent->getCountry();
            $state = $deliveryModuleOptionEvent->getState();

            if (!$module instanceof MondialRelay) {
                $isValid = false;
            } elseif (!$module->isValidDelivery($country, $state)) {
                $isValid = false;
            } else {
                $result = $module->getPostage($country, $state);

                if ($result instanceof OrderPostage) {
                    $postage = (float) $result->getAmount();
                    $postageTax = (float) $result->getAmountTax();
                } else {
                    $postage = (float) $result;
                }
            }
        } catch (\Exception) {
            $isValid = false;
        }

        $deliveryModuleOption = new DeliveryModuleOption();
        $deliveryModuleOption
            ->setCode(MondialRelay::getModuleCode())
            ->setValid($isValid)
            ->setTitle($propelModule?->getTitle())
            ->setImage('')
            ->setMinimumDeliveryDate('')
            ->setMaximumDeliveryDate('')
            ->setPostage($postage)
            ->setPostageTax($postageTax)
            ->setPostageUntaxed($postage - $postageTax);

        $deliveryModuleOptionEvent->appendDeliveryModuleOptions($deliveryModuleOption);
    }

    public static function getSubscribedEvents(): array
    {
        $listenedEvents = [];

        if (class_exists(DeliveryModuleOptionEvent::class)) {
            $listenedEvents[TheliaEvents::MODULE_DELIVERY_GET_OPTIONS] = ['getDeliveryModuleOptions', 129];
        }

        return $listenedEvents;
    }
}
