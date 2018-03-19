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

use MondialRelay\Model\MondialRelayPickupAddress;
use MondialRelay\Model\MondialRelayPickupAddressQuery;
use MondialRelay\MondialRelay;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\OrderQuery;

/**
 * @package MondialRelay\Loop
 * @method int getOrderAddressId()
 * @method int getOrderId()
 */
class SelectedPickupPoint extends BaseLoop implements PropelSearchLoopInterface
{
    /**
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('order_address_id'),
            Argument::createIntTypeArgument('order_id')
        );
    }


    /**
     * @throws \Exception
     * @return MondialRelayPickupAddressQuery|null
     */
    public function buildModelCriteria()
    {
        if (null !== $relayId = $this->getCurrentRequest()->getSession()->get(MondialRelay::SESSION_SELECTED_PICKUP_RELAY_ID)) {
            return MondialRelayPickupAddressQuery::create()->filterById($relayId);
        } elseif (null !== $orderAddressId = $this->getOrderAddressId()) {
            return MondialRelayPickupAddressQuery::create()->filterByOrderAddressId($orderAddressId);
        } elseif (null !== $orderId = $this->getOrderId()) {
            if (null !== $order = OrderQuery::create()->findPk($orderId)) {
                return MondialRelayPickupAddressQuery::create()
                    ->filterByOrderAddressId($order->getDeliveryOrderAddressId());
            }
        }

        return null;
    }

    public function parseResults(LoopResult $loopResult)
    {
        /** @var MondialRelayPickupAddress $item */
        foreach ($loopResult->getResultDataCollection() as $item) {
            $loopResultRow = new LoopResultRow($item);

            $relayData = json_decode($item->getJsonRelayData(), true);

            $loopResultRow
                ->set("ID", $relayData['id'])
                ->set("LATITUDE", $relayData['latitude'])
                ->set("LONGITUDE", $relayData['longitude'])
                ->set("ZIPCODE", $relayData['zipcode'])
                ->set("CITY", $relayData['city'])
                ->set("COUNTRY", $relayData['country'])
                ->set("NAME", $relayData['name'])
                ->set("ADDRESS", $relayData['address'])
                ->set("DISTANCE", $relayData['distance'])
                ->set("OPENINGS", $relayData['openings'])
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
