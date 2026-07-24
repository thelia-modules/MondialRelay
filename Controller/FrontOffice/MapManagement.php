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

namespace MondialRelay\Controller\FrontOffice;

use MondialRelay\Event\FindRelayEvent;
use MondialRelay\Event\MondialRelayEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\HttpFoundation\JsonResponse;

require_once __DIR__ . "/../../vendor/autoload.php";

/**
 * Legacy relay-point search endpoint, kept for the Smarty front (retro-compatibility).
 * The Flexy front uses the native pickup-location API instead
 * (see MondialRelay\EventListeners\PickupLocationListener).
 */
class MapManagement extends BaseFrontController
{
    public function getRelayMapAction(EventDispatcherInterface $dispatcher): JsonResponse
    {
        $event = new FindRelayEvent(
            (int) $this->getRequest()->get('country_id', 0),
            (string) $this->getRequest()->get('city', ''),
            (string) $this->getRequest()->get('zipcode', ''),
            (float) $this->getRequest()->get('radius', 10)
        );

        $dispatcher->dispatch($event, MondialRelayEvents::FIND_RELAYS);

        return new JsonResponse([
            'points' => $event->getPoints(),
            'error' => $event->getError(),
        ]);
    }
}
