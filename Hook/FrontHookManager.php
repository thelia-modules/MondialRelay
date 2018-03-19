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

use MondialRelay\MondialRelay;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class FrontHookManager extends BaseHook
{
    public function onOrderDeliveryExtra(HookRenderEvent $event)
    {
        // Clear the session context
        $this->getSession()->remove(MondialRelay::SESSION_SELECTED_DELIVERY_TYPE);
        $this->getSession()->remove(MondialRelay::SESSION_SELECTED_PICKUP_RELAY_ID);

        // Get the address id from the request, as the hook don(t give it to us.
        $addressId = $this->getRequest()->get('address_id', 0);

        $event->add(
            $this->render(
                'mondialrelay/order-delivery-extra.html',
                [
                    'module_id' => MondialRelay::getModuleId(),
                    'address_id' => $addressId
                ]
            )
        );
    }

    public function onAccountOrderDeliveryAddress(HookRenderEvent $event)
    {
        $event->add(
            $this->render(
                'mondialrelay/order-delivery-address.html',
                [
                    'order_id' => $event->getArgument('order'),
                    'module_id' => $event->getArgument('module')
                ]
            )
        );
    }
}


