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

use MondialRelay\Form\DeleteForm;
use MondialRelay\Form\InsuranceCreateForm;
use MondialRelay\Form\InsurancesUpdateForm;
use MondialRelay\Form\PriceAttributesUpdateForm;
use MondialRelay\Form\PriceCreateForm;
use MondialRelay\Form\PricesUpdateForm;
use MondialRelay\Form\SettingsForm;
use MondialRelay\Model\MondialRelayDeliveryInsuranceQuery;
use MondialRelay\Model\MondialRelayDeliveryPriceQuery;
use MondialRelay\Model\MondialRelayZoneConfigurationQuery;
use MondialRelay\MondialRelay;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Form\TheliaFormFactory;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Template\Parser\ParserResolver;
use Thelia\Model\AreaQuery;
use Thelia\Model\CurrencyQuery;
use Thelia\Tools\URL;

class AdminHookManager extends BaseHook
{
    public function __construct(
        private readonly TheliaFormFactory $formFactory,
        private readonly RequestStack $requestStack,
        ?EventDispatcherInterface $dispatcher = null,
        ?ParserResolver $parserResolver = null,
    ) {
        parent::__construct($dispatcher, $parserResolver);
    }

    public static function getSubscribedHooks(): array
    {
        return [
            'module.configuration' => [
                ['type' => 'back', 'method' => 'onModuleConfigure'],
            ],
            'module.config-js' => [
                ['type' => 'back', 'method' => 'onModuleConfigureJs'],
            ],
            'main.top-menu-tools' => [
                ['type' => 'back', 'method' => 'onMainTopMenuTools'],
            ],
        ];
    }

    public function onModuleConfigure(HookRenderEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $moduleId = MondialRelay::getModuleId();

        $defaultCurrency = CurrencyQuery::create()->filterByByDefault(1)->findOne();
        $currencySymbol = null !== $defaultCurrency ? $defaultCurrency->getSymbol() : '';

        // Build the shipping zones (areas) attached to this module, with their prices and attributes.
        $areas = [];
        $areaCollection = AreaQuery::create()
            ->useAreaDeliveryModuleQuery()
                ->filterByDeliveryModuleId($moduleId)
            ->endUse()
            ->orderById()
            ->find();

        foreach ($areaCollection as $area) {
            $prices = [];
            $priceCollection = MondialRelayDeliveryPriceQuery::create()
                ->filterByAreaId($area->getId())
                ->orderByMaxWeight(Criteria::ASC)
                ->find();

            foreach ($priceCollection as $price) {
                $prices[] = [
                    'id' => $price->getId(),
                    'maxWeight' => $price->getMaxWeight(),
                    'priceWithTax' => $price->getPriceWithTax(),
                ];
            }

            $zoneConfig = MondialRelayZoneConfigurationQuery::create()->findOneByAreaId($area->getId());

            $areas[] = [
                'id' => $area->getId(),
                'name' => $area->getName(),
                'prices' => $prices,
                'deliveryTime' => null !== $zoneConfig ? $zoneConfig->getDeliveryTime() : '',
                'deliveryType' => null !== $zoneConfig ? $zoneConfig->getDeliveryType() : null,
            ];
        }

        $insurances = [];
        $insuranceCollection = MondialRelayDeliveryInsuranceQuery::create()
            ->orderByMaxValue(Criteria::ASC)
            ->find();

        foreach ($insuranceCollection as $insurance) {
            $insurances[] = [
                'id' => $insurance->getId(),
                'maxValue' => $insurance->getMaxValue(),
                'priceWithTax' => $insurance->getPriceWithTax(),
            ];
        }

        $settingsForm = $this->formFactory->createForm(
            SettingsForm::getName(),
            FormType::class,
            [
                MondialRelay::CODE_ENSEIGNE => MondialRelay::getConfigValue(MondialRelay::CODE_ENSEIGNE),
                MondialRelay::PRIVATE_KEY => MondialRelay::getConfigValue(MondialRelay::PRIVATE_KEY),
                MondialRelay::WEBSERVICE_URL => MondialRelay::getConfigValue(MondialRelay::WEBSERVICE_URL),
                MondialRelay::GOOGLE_MAPS_API_KEY => MondialRelay::getConfigValue(MondialRelay::GOOGLE_MAPS_API_KEY),
                MondialRelay::ALLOW_HOME_DELIVERY => (bool) MondialRelay::getConfigValue(MondialRelay::ALLOW_HOME_DELIVERY),
                MondialRelay::ALLOW_RELAY_DELIVERY => (bool) MondialRelay::getConfigValue(MondialRelay::ALLOW_RELAY_DELIVERY),
                MondialRelay::ALLOW_INSURANCE => (bool) MondialRelay::getConfigValue(MondialRelay::ALLOW_INSURANCE),
            ]
        );

        $event->add(
            $this->render(
                'MondialRelay/module-configuration.html.twig',
                [
                    'settingsForm' => $settingsForm->createView()->getView(),
                    'pricesUpdateForm' => $this->formFactory->createForm(PricesUpdateForm::getName())->createView()->getView(),
                    'priceCreateForm' => $this->formFactory->createForm(PriceCreateForm::getName())->createView()->getView(),
                    'areaAttributesForm' => $this->formFactory->createForm(PriceAttributesUpdateForm::getName())->createView()->getView(),
                    'insurancesUpdateForm' => $this->formFactory->createForm(InsurancesUpdateForm::getName())->createView()->getView(),
                    'insuranceCreateForm' => $this->formFactory->createForm(InsuranceCreateForm::getName())->createView()->getView(),
                    'deleteForm' => $this->formFactory->createForm(DeleteForm::getName())->createView()->getView(),
                    'module_id' => $moduleId,
                    'active_tab' => null !== $request ? (string) $request->get('tab', 'general') : 'general',
                    'allow_insurance' => (bool) MondialRelay::getConfigValue(MondialRelay::ALLOW_INSURANCE),
                    'areas' => $areas,
                    'insurances' => $insurances,
                    'currency_symbol' => $currencySymbol,
                ]
            )
        );
    }

    public function onMainTopMenuTools(HookRenderBlockEvent $event): void
    {
        $event->add(
            [
                'id' => 'tools_mondial_relay',
                'class' => '',
                'url' => URL::getInstance()->absoluteUrl('/admin/module/MondialRelay'),
                'title' => $this->trans('Mondial Relay', [], MondialRelay::DOMAIN_NAME),
            ]
        );
    }

    public function onModuleConfigureJs(HookRenderEvent $event): void
    {
        $event->add(
            $this->render('MondialRelay/module-config-js.html.twig')
        );
    }
}
