<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace MondialRelay\Loop;

use MondialRelay\Model\MondialRelayDeliveryInsuranceQuery;
use MondialRelay\Model\MondialRelayDeliveryPrice;
use MondialRelay\Model\MondialRelayDeliveryPriceQuery;
use MondialRelay\Model\MondialRelayZoneConfiguration;
use MondialRelay\Model\MondialRelayZoneConfigurationQuery;
use MondialRelay\MondialRelay;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Model\AreaDeliveryModuleQuery;
use Thelia\Model\Cart;
use Thelia\Model\CountryArea;
use Thelia\Model\CountryAreaQuery;
use Thelia\Model\CountryQuery;
use Thelia\Model\ModuleQuery;
use Thelia\Model\StateQuery;
use Thelia\Type\EnumType;
use Thelia\Type\TypeCollection;

/**
 * Class Prices
 * @package MondialRelay\Loop
 * @method int getCountryId()
 * @method int|null getStateId()
 * @method string getMode()
 * @method string getInsurance()
 */
class DeliveryPrice extends BaseLoop implements ArraySearchLoopInterface
{
    /**
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions(): ArgumentCollection
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('country_id', null, true),
            Argument::createIntTypeArgument('state_id'),
            Argument::createBooleanTypeArgument('insurance', null, false),
            new Argument(
                'mode',
                new TypeCollection(
                    new EnumType(['home', 'relay', 'all'])
                ),
                null,
                true
            )
        );
    }

    /**
     * @return array
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function buildArray(): array
    {
        $results = [];

        if (null !== $country = CountryQuery::create()->findPk($this->getCountryId())) {
            if (null !== $stateId = $this->getStateId()) {
                $state = StateQuery::create()->findPk($stateId);
            } else {
                $state = null;
            }

            $mode = $this->getMode();
            $deliveryType = MondialRelayZoneConfiguration::ALL_DELIVERY_TYPE;

            switch ($mode) {
                case 'home':
                    $deliveryType = MondialRelayZoneConfiguration::HOME_DELIVERY_TYPE;

                    if (! MondialRelay::getConfigValue(MondialRelay::ALLOW_HOME_DELIVERY, '1')) {
                        return [];
                    }
                    break;

                case 'relay':
                    $deliveryType = MondialRelayZoneConfiguration::RELAY_DELIVERY_TYPE;

                    if (! MondialRelay::getConfigValue(MondialRelay::ALLOW_RELAY_DELIVERY, '1')) {
                        return [];
                    }
                    break;

                case 'all':
                    $deliveryType = MondialRelayZoneConfiguration::ALL_DELIVERY_TYPE;
                    break;
            }


            // Find all areas which contains this country
            $countryInAreaList = CountryAreaQuery::findByCountryAndState($country, $state);

            $areaIdList = [];

            $module = ModuleQuery::create()->findOneByCode(MondialRelay::getModuleCode());

            /** @var CountryArea $countryInArea */
            foreach ($countryInAreaList as $countryInArea) {
                // Check if module is attached to the area
                if (AreaDeliveryModuleQuery::create()
                    ->filterByAreaId($countryInArea->getAreaId())
                    ->filterByModule($module)
                    ->count() > 0) {
                    $areaIdList[] = $countryInArea->getAreaId();
                }
            }

            // Find zones with the required delivery type
            $zones = MondialRelayZoneConfigurationQuery::create()
                    ->filterByAreaId($areaIdList, Criteria::IN)
                    ->filterByDeliveryType($deliveryType)
                    ->find();

            $session = $this->requestStack->getCurrentRequest()?->getSession();
            $cart = $session instanceof Session ? $session->getSessionCart($this->dispatcher) : null;

            if (null === $cart) {
                return $results;
            }

            $cartWeight = $cart->getWeight();
            $cartValue = $cart->getTaxedAmount($country);

            /** @var MondialRelayZoneConfiguration $zone */
            foreach ($zones as $zone) {
                $result = [];

                if (null !== $deliveryPrice = MondialRelayDeliveryPriceQuery::create()
                        ->filterByAreaId($zone->getAreaId())
                        ->filterByMaxWeight($cartWeight, Criteria::GREATER_EQUAL)
                        ->orderByMaxWeight(Criteria::ASC)
                        ->findOne()) {
                    $deliveryDate = (new \DateTime())->add(new \DateInterval("P" . $zone->getDeliveryTime() . "D"));

                    // We have a price
                    $result['PRICE'] = $deliveryPrice->getPriceWithTax();
                    $result['MAX_WEIGHT'] = $deliveryPrice->getMaxWeight();
                    $result['AREA_ID'] = $deliveryPrice->getAreaId();
                    $result['DELIVERY_DELAY'] = $zone->getDeliveryTime();
                    $result['DELIVERY_DATE'] = $deliveryDate;
                    switch ($zone->getDeliveryType()) {
                        case MondialRelayZoneConfiguration::HOME_DELIVERY_TYPE:
                            $result['ZONE_TYPE'] = 'home';
                            break;

                        case MondialRelayZoneConfiguration::RELAY_DELIVERY_TYPE:
                            $result['ZONE_TYPE'] = 'relay';
                            break;

                        default:
                            $result['ZONE_TYPE'] = '?';
                    }

                    $result['TYPE'] = $zone->getDeliveryType();

                    // Get insurance cost
                    if (null !== $insurance = MondialRelayDeliveryInsuranceQuery::create()
                        ->filterByMaxValue($cartValue, Criteria::GREATER_EQUAL)
                        ->orderByMaxValue(Criteria::ASC)
                        ->findOne()
                    ) {
                        $result['INSURANCE_AVAILABLE'] = true;
                        $result['INSURANCE_PRICE'] = $insurance->getPriceWithTax();
                        $result['INSURANCE_REF_VALUE'] = $insurance->getMaxValue();
                    } else {
                        $result['INSURANCE_AVAILABLE'] = false;
                    }

                    $results[] = $result;
                }
            }
        }

        return $results;
    }

    public function parseResults(LoopResult $loopResult): LoopResult
    {
        foreach ($loopResult->getResultDataCollection() as $resultItem) {
            $loopResultRow = new LoopResultRow($resultItem);

            foreach ($resultItem as $name => $value) {
                $loopResultRow->set($name, $value);
            }

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
