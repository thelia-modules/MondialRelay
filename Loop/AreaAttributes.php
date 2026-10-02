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

use MondialRelay\Model\MondialRelayZoneConfiguration;
use MondialRelay\Model\MondialRelayZoneConfigurationQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/**
 * Class AreaAttributes
 * @package MondialRelay\Loop
 * @method int[]|null getAreaId()
 * @method int[]|null getDeliveryType()
 */
class AreaAttributes extends BaseLoop implements PropelSearchLoopInterface
{
    /**
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions(): ArgumentCollection
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('area_id'),
            Argument::createIntListTypeArgument('delivery_type')
        );
    }


    public function buildModelCriteria(): ModelCriteria
    {
        $query = MondialRelayZoneConfigurationQuery::create();

        if (null !== $areaId = $this->getAreaId()) {
            $query->filterByAreaId($areaId, Criteria::IN);
        }

        if (null !== $delivTypes = $this->getDeliveryType()) {
            $query->filterByDeliveryType($delivTypes, Criteria::IN);
        }

        return $query;
    }

    public function parseResults(LoopResult $loopResult): LoopResult
    {
        /** @var MondialRelayZoneConfiguration $item */
        foreach ($loopResult->getResultDataCollection() as $item) {
            $loopResultRow = new LoopResultRow($item);

            $loopResultRow
                ->set('ID', $item->getId())
                ->set('DELIVERY_TYPE', $item->getDeliveryType())
                ->set('DELIVERY_TIME', $item->getDeliveryTime())
                ->set('AREA_ID', $item->getAreaId())
                ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
