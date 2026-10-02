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

namespace MondialRelay;

use MondialRelay\Model\MondialRelayDeliveryInsurance;
use MondialRelay\Model\MondialRelayDeliveryPrice;
use MondialRelay\Model\MondialRelayDeliveryPriceQuery;
use MondialRelay\Model\MondialRelayZoneConfiguration;
use MondialRelay\Model\MondialRelayZoneConfigurationQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Core\Install\Database;
use Thelia\Core\Translation\Translator;
use Thelia\Domain\Checkout\Enum\DeliveryMode;
use Thelia\Exception\TheliaProcessException;
use Thelia\Model\Area;
use Thelia\Model\AreaDeliveryModule;
use Thelia\Model\AreaDeliveryModuleQuery;
use Thelia\Model\AreaQuery;
use Thelia\Model\Country;
use Thelia\Model\CountryArea;
use Thelia\Model\CountryAreaQuery;
use Thelia\Model\CountryQuery;
use Thelia\Model\Currency;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Model\Message;
use Thelia\Model\MessageQuery;
use Thelia\Model\ModuleConfigQuery;
use Thelia\Model\ModuleImageQuery;
use Thelia\Model\OrderPostage;
use Thelia\Model\State;
use Thelia\Module\AbstractDeliveryModuleWithState;
use Thelia\Module\Exception\DeliveryException;

class MondialRelay extends AbstractDeliveryModuleWithState
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

    public function getDeliveryMode(): string
    {
        // Triggers the generic Flexy pickup-point picker at checkout.
        return DeliveryMode::PICKUP->value;
    }

    public function isValidDelivery(Country $country, ?State $state = null): bool
    {
        return null !== $this->computePostage($country, $state);
    }

    /**
     * @throws DeliveryException
     */
    public function getPostage(Country $country, ?State $state = null): OrderPostage|float
    {
        $postage = $this->computePostage($country, $state);

        if (null === $postage) {
            throw new DeliveryException(
                Translator::getInstance()->trans('Mondial Relay delivery is not available for this order.', [], self::DOMAIN_NAME)
            );
        }

        return $postage;
    }

    /**
     * Compute the (tax-included) postage for the destination, honouring the selected
     * delivery type (relay/home) when set. Returns null when the module cannot deliver.
     */
    private function computePostage(Country $country, ?State $state): ?float
    {
        $session = $this->getRequest()->getSession();

        $selectedDeliveryType = match ($this->getRequest()->get('mondial-relay-selected-delivery-mode')) {
            'pickup' => MondialRelayZoneConfiguration::RELAY_DELIVERY_TYPE,
            'home' => MondialRelayZoneConfiguration::HOME_DELIVERY_TYPE,
            default => $session->get(self::SESSION_SELECTED_DELIVERY_TYPE),
        };

        $cart = $session instanceof Session ? $session->getSessionCart($this->getDispatcher()) : null;
        $weight = max(self::MIN_WEIGHT_KG, (float) ($cart?->getWeight() ?? 0));
        if ($weight > self::MAX_WEIGHT_KG) {
            return null;
        }

        $moduleModel = $this->getModuleModel();
        $countryHasRelay = false;
        $countryHasHome = false;
        $price = null;

        /** @var CountryArea $countryInArea */
        foreach (CountryAreaQuery::findByCountryAndState($country, $state) as $countryInArea) {
            $areas = AreaDeliveryModuleQuery::create()
                ->filterByAreaId($countryInArea->getAreaId())
                ->filterByModule($moduleModel)
                ->find();

            /** @var AreaDeliveryModule $area */
            foreach ($areas as $area) {
                $zoneConfig = MondialRelayZoneConfigurationQuery::create()->findOneByAreaId($area->getAreaId());
                if (null === $zoneConfig) {
                    continue;
                }

                $zoneDeliveryType = $zoneConfig->getDeliveryType();

                if (MondialRelayZoneConfiguration::ALL_DELIVERY_TYPE === $zoneDeliveryType) {
                    $countryHasRelay = $countryHasHome = true;
                } elseif (MondialRelayZoneConfiguration::HOME_DELIVERY_TYPE === $zoneDeliveryType) {
                    $countryHasHome = true;
                } elseif (MondialRelayZoneConfiguration::RELAY_DELIVERY_TYPE === $zoneDeliveryType) {
                    $countryHasRelay = true;
                }

                if (null === $selectedDeliveryType || $zoneDeliveryType === $selectedDeliveryType) {
                    $deliveryPrice = MondialRelayDeliveryPriceQuery::create()
                        ->filterByAreaId($area->getAreaId())
                        ->filterByMaxWeight($weight, Criteria::GREATER_EQUAL)
                        ->orderByMaxWeight(Criteria::ASC)
                        ->findOne();

                    if (null !== $deliveryPrice) {
                        $candidate = (float) $deliveryPrice->getPriceWithTax();
                        $price = null === $price ? $candidate : min($price, $candidate);
                    }
                }
            }
        }

        $relayAllowed = (bool) self::getConfigValue(self::ALLOW_RELAY_DELIVERY, '1');
        $homeAllowed = (bool) self::getConfigValue(self::ALLOW_HOME_DELIVERY, '1');

        if (null !== $price && (($countryHasHome && $homeAllowed) || ($countryHasRelay && $relayAllowed))) {
            return $price;
        }

        return null;
    }

    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([
                __DIR__.'/I18n/*',
                __DIR__.'/Config/*',
                __DIR__.'/vendor/*',
                __DIR__.'/MondialRelay.php',
            ])
            ->autowire(true)
            ->autoconfigure(true);
    }

    /**
     * @param ConnectionInterface|null $con
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function postActivation(?ConnectionInterface $con = null): void
    {
        $needsSeeding = false;

        try {
            // An existing but empty table (e.g. after a partial activation) still needs seeding.
            $needsSeeding = 0 === MondialRelayDeliveryPriceQuery::create()->count();
        } catch (\Exception) {
            // Table does not exist yet: create the schema first, then seed.
            (new Database($con))->insertSql(null, [ __DIR__ . '/Config/thelia.sql' ]);
            $needsSeeding = true;
        }

        if ($needsSeeding) {
            // Test Enseigne and private key
            self::setConfigValue(self::CODE_ENSEIGNE, "BDTEST13");
            self::setConfigValue(self::PRIVATE_KEY, "PrivateK");
            self::setConfigValue(self::WEBSERVICE_URL, "https://api.mondialrelay.com/Web_Services.asmx?WSDL");
            self::setConfigValue(self::GOOGLE_MAPS_API_KEY, "get_your_own_api_key");
            self::setConfigValue(self::ALLOW_HOME_DELIVERY, '1');
            self::setConfigValue(self::ALLOW_RELAY_DELIVERY, '1');
            self::setConfigValue(self::ALLOW_INSURANCE, '1');

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
                        ->setMaxWeight((string) $price->up_to)
                        ->setPriceWithTax((string) ($price->price_euro * $rateFromEuro))
                        ->save();
                }
            }

            // Insurances
            foreach ($moduleConfiguration->insurances as $insurance) {
                (new MondialRelayDeliveryInsurance())
                    ->setMaxValue((string) $insurance->value)
                    ->setPriceWithTax((string) $insurance->price_with_tax_euro)
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

    /**
     * @param ConnectionInterface|null $con
     * @param bool $deleteModuleData
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function destroy(?ConnectionInterface $con = null, $deleteModuleData = false): void
    {
        if ($deleteModuleData) {
            // Delete message
            MessageQuery::create()->filterByName(self::TRACKING_MESSAGE_NAME)->delete($con);

            // Delete module config data
            ModuleConfigQuery::create()->filterByModuleId(self::getModuleId())->delete($con);

            // Delete module tables.
            if (null !== $con) {
                $database = new Database($con);
                $database->insertSql(null, [__DIR__ . '/Config/drop.sql']);
            }
        }

        parent::destroy($con, $deleteModuleData);
    }
}
