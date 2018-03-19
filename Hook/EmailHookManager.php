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

class EmailHookManager extends BaseHook
{
    protected function renderAddressTemplate(HookRenderEvent $event, $htmlMode = false)
    {
        $event->add(
            $this->render(
                'mondialrelay/order-delivery-address.html',
                [
                    'module_id' => $event->getArgument('module'),
                    'order_id' => $event->getArgument('order'),
                    'html_mode' => $htmlMode ? '1' : '0'
                ]
            )
        );
    }

    public function onDeliveryAddressText(HookRenderEvent $event)
    {
        $this->renderAddressTemplate($event, false);
    }

    public function onDeliveryAddressHtml(HookRenderEvent $event)
    {
        $this->renderAddressTemplate($event, true);
    }

    public function onAfterProductsText(HookRenderEvent $event)
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

    public function onAfterProductsHtml(HookRenderEvent $event)
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
