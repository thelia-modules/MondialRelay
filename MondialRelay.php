<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace MondialRelay;

use MondialRelay\Model\MondialRelayDeliveryInsurance;
use MondialRelay\Model\MondialRelayDeliveryPrice;
use MondialRelay\Model\MondialRelayDeliveryPriceQuery;
use MondialRelay\Model\MondialRelayZoneConfiguration;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\Translation\Translator;
use Thelia\Exception\TheliaProcessException;
use Thelia\Install\Database;
use Thelia\Model\Area;
use Thelia\Model\AreaDeliveryModule;
use Thelia\Model\AreaQuery;
use Thelia\Model\Country;
use Thelia\Model\CountryArea;
use Thelia\Model\CountryQuery;
use Thelia\Model\Currency;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Model\Message;
use Thelia\Model\MessageQuery;
use Thelia\Model\ModuleImageQuery;
use Thelia\Model\OrderPostage;
use Thelia\Module\AbstractDeliveryModule;
use Thelia\Module\Exception\DeliveryException;

class MondialRelay extends AbstractDeliveryModule
{
    const DOMAIN_NAME = 'mondialrelay';

    const CODE_ENSEIGNE  = 'code_enseigne';
    const PRIVATE_KEY    = 'private_key';
    const WEBSERVICE_URL = 'webservice_url';
    const GOOGLE_MAPS_API_KEY = 'google_maps_api_key';

    const ALLOW_RELAY_DELIVERY = 'allow_relay_delivery';
    const ALLOW_HOME_DELIVERY  = 'allow_home_delivery';

    const ALLOW_INSURANCE  = 'allow_insurance';

    const SESSION_SELECTED_PICKUP_RELAY_ID  = 'MondialRelayPickupAddressId';
    const SESSION_SELECTED_DELIVERY_TYPE = 'MondialRelaySelectedDeliveryType';

    const TRACKING_MESSAGE_NAME = 'mondial-relay-tracking-message';

    const MAX_WEIGHT_KG = 30;
    const MIN_WEIGHT_KG = 0.1;

    /**
     * This method is called by the Delivery  loop, to check if the current module has to be displayed to the customer.
     * Override it to implements your delivery rules/
     *
     * If you return true, the delivery method will de displayed to the customer
     * If you return false, the delivery method will not be displayed
     *
     * @param Country $country the country to deliver to.
     *
     * @return boolean
     */
    public function isValidDelivery(Country $country)
    {
        // TODO: Implement isValidDelivery() method.
    }

    /**
     * Calculate and return delivery price in the shop's default currency
     *
     * @param Country $country the country to deliver to.
     *
     * @return OrderPostage|float             the delivery price
     * @throws DeliveryException if the postage price cannot be calculated.
     */
    public function getPostage(Country $country)
    {
        // TODO: Implement getPostage() method.
    }

    /**
     * @param ConnectionInterface|null $con
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function postActivation(ConnectionInterface $con = null)
    {
        try {
            MondialRelayDeliveryPriceQuery::create()->findOne();
        } catch (\Exception $e) {
            $database = new Database($con);
            $database->insertSql(null, [ __DIR__ . '/Config/thelia.sql' ]);

            // Test Enseigne and private key
            self::setConfigValue(self::CODE_ENSEIGNE, "BDTEST13");
            self::setConfigValue(self::PRIVATE_KEY, "PrivateK");
            self::setConfigValue(self::WEBSERVICE_URL, "https://api.mondialrelay.com/Web_Services.asmx?WSDL");
            self::setConfigValue(self::GOOGLE_MAPS_API_KEY, "AIzaSyBY_RCM1zkJ0-Df1XMTq3fDzypFC95ZNFE");
            self::setConfigValue(self::ALLOW_HOME_DELIVERY, true);
            self::setConfigValue(self::ALLOW_RELAY_DELIVERY, true);
            self::setConfigValue(self::ALLOW_INSURANCE, true);

            // Create mondial relay shipping zones for relay and home delivery

            $moduleId = self::getModuleId();

            $rateFromEuro = Currency::getDefaultCurrency()->getRate();

            $moduleConfiguration = json_decode(file_get_contents(__DIR__. '/Config/config-data.json'));

            if (false === $moduleConfiguration) {
                throw new TheliaProcessException("Invalid JSON configuration for Mondial Relay module");
            }

            // Create all shipping zones, and associate Mondial relay module with them.
            foreach ($moduleConfiguration->shippingZones as $shippingZone) {
                AreaQuery::create()->filterByName($shippingZone->name)->delete();

                $area = new Area();

                $area
                    ->setName($shippingZone->name)
                    ->save();

                foreach ($shippingZone->countries as $countryIsoCode) {
                    if (null !== $country = CountryQuery::create()->findOneByIsoalpha3($countryIsoCode)) {
                        (new CountryArea())
                            ->setAreaId($area->getId())
                            ->setCountryId($country->getId())
                            ->save();
                    }
                }

                // Define zone attributes
                (new MondialRelayZoneConfiguration())
                    ->setAreaId($area->getId())
                    ->setDeliveryType($shippingZone->delivery_type)
                    ->setDeliveryTime($shippingZone->delivery_time_in_days)
                    ->save();

                // Attach this zone to our module
                (new AreaDeliveryModule())
                    ->setArea($area)
                    ->setDeliveryModuleId($moduleId)
                    ->save();

                // Create base prices
                foreach ($shippingZone->prices as $price) {
                    (new MondialRelayDeliveryPrice())
                        ->setAreaId($area->getId())
                        ->setMaxWeight($price->up_to)
                        ->setPriceWithTax($price->price_euro * $rateFromEuro)
                        ->save();
                }
            }

            // Insurances
            foreach ($moduleConfiguration->insurances as $insurance) {
                (new MondialRelayDeliveryInsurance())
                    ->setMaxValue($insurance->value)
                    ->setPriceWithTax($insurance->price_with_tax_euro)
                    ->setLevel($insurance->level)
                    ->save();
            }

            if (null === MessageQuery::create()->findOneByName(self::TRACKING_MESSAGE_NAME)) {
                $message = new Message();
                $message
                    ->setName(self::TRACKING_MESSAGE_NAME)
                    ->setHtmlLayoutFileName('')
                    ->setHtmlTemplateFileName(self::TRACKING_MESSAGE_NAME.'.html')
                    ->setTextLayoutFileName('')
                    ->setTextTemplateFileName(self::TRACKING_MESSAGE_NAME.'.txt')
                ;

                $languages = LangQuery::create()->find();

                /** @var Lang $language */
                foreach ($languages as $language) {
                    $locale = $language->getLocale();
                    $message->setLocale($locale);

                    $message->setTitle(
                        Translator::getInstance()->trans('Mondial Relay tracking information', [], self::DOMAIN_NAME, $locale)
                    );

                    $message->setSubject(
                        Translator::getInstance()->trans('Your order has been shipped', [], self::DOMAIN_NAME, $locale)
                    );
                }

                $message->save();
            }

            /* Deploy the module's image */
            $module = $this->getModuleModel();
            if (ModuleImageQuery::create()->filterByModule($module)->count() == 0) {
                $this->deployImageFolder($module, sprintf('%s/images', __DIR__), $con);
            }
        }
    }
}
