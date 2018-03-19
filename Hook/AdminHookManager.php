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
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

class AdminHookManager extends BaseHook
{
    public function onModuleConfigure(HookRenderEvent $event)
    {
        $vars = [
            'code_enseigne' => MondialRelay::getConfigValue(MondialRelay::CODE_ENSEIGNE),
            'private_key' =>  MondialRelay::getConfigValue(MondialRelay::PRIVATE_KEY),
            'allow_relay_delivery' =>  MondialRelay::getConfigValue(MondialRelay::ALLOW_RELAY_DELIVERY),
            'allow_home_delivery' =>  MondialRelay::getConfigValue(MondialRelay::ALLOW_HOME_DELIVERY),
            'allow_insurance' =>  MondialRelay::getConfigValue(MondialRelay::ALLOW_INSURANCE),

            'module_id' =>  MondialRelay::getModuleId()
        ];

        $event->add(
            $this->render('mondialrelay/module-configuration.html', $vars)
        );
    }

    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        $event->add(
            [
                'id' => 'tools_mondial_relay',
                'class' => '',
                'url' => URL::getInstance()->absoluteUrl('/admin/module/MondialRelay'),
                'title' => $this->trans('Mondial Relay', [], MondialRelay::DOMAIN_NAME)
            ]
        );
    }

    public function onModuleConfigureJs(HookRenderEvent $event)
    {
        $event
            ->add($this->render("mondialrelay/assets/js/mondialrelay.js.html"))
            ->add($this->addJS("mondialrelay/assets/js/bootstrap-notify.min.js"))
        ;
    }
}
