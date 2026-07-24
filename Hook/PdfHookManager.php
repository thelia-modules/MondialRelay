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
 * PDF hooks (Smarty templates, unchanged in Thelia 3 — PDF documents remain Smarty-rendered).
 */
class PdfHookManager extends BaseHook
{
    public static function getSubscribedHooks(): array
    {
        return [
            'delivery.delivery-address' => [['type' => 'pdf', 'method' => 'onDeliveryAddress']],
            'invoice.delivery-address' => [['type' => 'pdf', 'method' => 'onDeliveryAddress']],
            'delivery.after-delivery-module' => [['type' => 'pdf', 'method' => 'onAfterDeliveryModule']],
            'invoice.after-delivery-module' => [['type' => 'pdf', 'method' => 'onAfterDeliveryModule']],
        ];
    }

    public function onDeliveryAddress(HookRenderEvent $event): void
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

    public function onAfterDeliveryModule(HookRenderEvent $event): void
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
