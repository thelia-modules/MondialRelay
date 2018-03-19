<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace MondialRelay\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class PdfHookManager extends BaseHook
{
    public function onDeliveryAddress(HookRenderEvent $event)
    {
        $event->add(
            $this->render(
                'mondialrelay/order-delivery-address.html',
                [
                    'module_id' => $event->getArgument('module'),
                    'order_id' => $event->getArgument('order'),
                ]
            )
        );
    }
    public function onAfterDeliveryModule(HookRenderEvent $event)
    {
        $event->add(
            $this->render(
                'mondialrelay/opening-hours.html',
                [
                    'module_id' => $event->getArgument('module'),
                    'order_id' => $event->getArgument('order'),
                ]
            )
        );
    }
}
