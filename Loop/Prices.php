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

use MondialRelay\Model\MondialRelayDeliveryPrice;
use MondialRelay\Model\MondialRelayDeliveryPriceQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/**
 * Class Prices
 * @package MondialRelay\Loop
 * @method int getAreaId()
 */
class Prices extends BaseLoop implements PropelSearchLoopInterface
{
    /**
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('area_id')
        );
    }


    public function buildModelCriteria()
    {
        $query = MondialRelayDeliveryPriceQuery::create();

        if (null !== $areaId = $this->getAreaId()) {
            $query->filterByAreaId($areaId, Criteria::IN);
        }

        $query->orderByMaxWeight();

        return $query;
    }

    public function parseResults(LoopResult $loopResult)
    {
        /** @var MondialRelayDeliveryPrice $item */
        foreach ($loopResult->getResultDataCollection() as $item) {
            $loopResultRow = new LoopResultRow($item);

            $loopResultRow
                ->set('ID', $item->getId())
                ->set('MAX_WEIGHT', $item->getMaxWeight())
                ->set('PRICE', $item->getPriceWithTax())
                ->set('AREA_ID', $item->getAreaId())
                ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
