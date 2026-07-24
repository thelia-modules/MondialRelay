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

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Email hooks (Smarty templates, unchanged in Thelia 3 — emails remain Smarty-rendered).
 */
class EmailHookManager extends BaseHook
{
    public static function getSubscribedHooks(): array
    {
        return [
            'email-html.order-confirmation.delivery-address' => [['type' => 'email', 'method' => 'onDeliveryAddressHtml']],
            'email-txt.order-confirmation.delivery-address' => [['type' => 'email', 'method' => 'onDeliveryAddressText']],
            'email-html.order-notification.delivery-address' => [['type' => 'email', 'method' => 'onDeliveryAddressHtml']],
            'email-txt.order-notification.delivery-address' => [['type' => 'email', 'method' => 'onDeliveryAddressText']],
            'email-html.order-confirmation.after-products' => [['type' => 'email', 'method' => 'onAfterProductsHtml']],
            'email-txt.order-confirmation.after-products' => [['type' => 'email', 'method' => 'onAfterProductsText']],
            'email-html.order-notification.after-products' => [['type' => 'email', 'method' => 'onAfterProductsHtml']],
            'email-txt.order-notification.after-products' => [['type' => 'email', 'method' => 'onAfterProductsText']],
        ];
    }

    protected function renderAddressTemplate(HookRenderEvent $event, bool $htmlMode = false): void
    {
        $event->add(
            $this->render(
                'mondialrelay/order-delivery-address.html',
                [
                    'module_id' => $event->getArgument('module'),
                    'order_id' => $event->getArgument('order'),
                    'html_mode' => $htmlMode ? '1' : '0',
                ]
            )
        );
    }

    public function onDeliveryAddressText(HookRenderEvent $event): void
    {
        $this->renderAddressTemplate($event, false);
    }

    public function onDeliveryAddressHtml(HookRenderEvent $event): void
    {
        $this->renderAddressTemplate($event, true);
    }

    public function onAfterProductsText(HookRenderEvent $event): void
    {
        $event->add(
            $this->render(
                'mondialrelay/opening-hours-text.html',
                [
                    'order_id' => $event->getArgument('order'),
                ]
            )
        );
    }

    public function onAfterProductsHtml(HookRenderEvent $event): void
    {
        $event->add(
            $this->render(
                'mondialrelay/opening-hours-html.html',
                [
                    'order_id' => $event->getArgument('order'),
                ]
            )
        );
    }
}
