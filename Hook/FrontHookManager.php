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

namespace MondialRelay\Hook;

use MondialRelay\MondialRelay;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Front-office hooks for the legacy Smarty theme (retro-compatibility).
 * On the Flexy theme these hook points are not rendered — the native pickup picker is used instead.
 */
class FrontHookManager extends BaseHook
{
    public static function getSubscribedHooks(): array
    {
        return [
            'order-delivery.extra' => [['type' => 'front', 'method' => 'onOrderDeliveryExtra']],
            'order-delivery.stylesheet' => [['type' => 'front', 'method' => 'onOrderDeliveryStylesheet']],
            'order-invoice.delivery-address' => [['type' => 'front', 'method' => 'onOrderInvoiceDeliveryAddress']],
            'account-order.delivery-address' => [['type' => 'front', 'method' => 'onAccountOrderDeliveryAddress']],
        ];
    }

    public function onOrderDeliveryExtra(HookRenderEvent $event): void
    {
        // Clear the session context
        $this->getSession()->remove(MondialRelay::SESSION_SELECTED_DELIVERY_TYPE);
        $this->getSession()->remove(MondialRelay::SESSION_SELECTED_PICKUP_RELAY_ID);

        // Get the address id from the request, as the hook doesn't give it to us.
        $addressId = $this->getRequest()?->get('address_id', 0);

        $event->add(
            $this->render(
                'mondialrelay/order-delivery-extra.html',
                [
                    'module_id' => MondialRelay::getModuleId(),
                    'address_id' => $addressId,
                ]
            )
        );
    }

    public function onOrderDeliveryStylesheet(HookRenderEvent $event): void
    {
        $event->add($this->addCSS('mondialrelay/assets/css/styles.css'));
    }

    public function onOrderInvoiceDeliveryAddress(HookRenderEvent $event): void
    {
        $event->add($this->render('mondialrelay/delivery-address.html'));
    }

    public function onAccountOrderDeliveryAddress(HookRenderEvent $event): void
    {
        $event->add(
            $this->render(
                'mondialrelay/order-delivery-address.html',
                [
                    'order_id' => $event->getArgument('order'),
                    'module_id' => $event->getArgument('module'),
                ]
            )
        );
    }
}
