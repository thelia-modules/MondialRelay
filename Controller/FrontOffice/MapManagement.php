<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

/**
 * Created by Franck Allimant, CQFDev <franck@cqfdev.fr>
 * Date: 12/03/2018 10:41
 */

namespace MondialRelay\Controller\FrontOffice;

use MondialRelay\Event\FindRelayEvent;
use MondialRelay\Event\MondialRelayEvents;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\HttpFoundation\JsonResponse;

require __DIR__ . "/../../vendor/autoload.php";

class MapManagement extends BaseFrontController
{
    public function getRelayMapAction()
    {
        $event = new FindRelayEvent(
            intval($this->getRequest()->get('country_id', 0)),
            $this->getRequest()->get('city', ''),
            $this->getRequest()->get('zipcode', ''),
            floatval($this->getRequest()->get('radius', 10))
        );

        $this->getDispatcher()->dispatch(MondialRelayEvents::FIND_RELAYS, $event);

        return new JsonResponse($event->getPoints());
    }
}
