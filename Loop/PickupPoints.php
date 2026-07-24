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

use MondialRelay\Event\FindRelayEvent;
use MondialRelay\Event\MondialRelayEvents;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

require __DIR__ . "/../vendor/autoload.php";

/**
 * Class Prices
 * @package MondialRelay\Loop
 * @method int getCountryId()
 * @method string getCity()
 * @method string getZipcode()
 * @method float getSearchRadius()
 */
class PickupPoints extends BaseLoop implements ArraySearchLoopInterface
{
    /**
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions(): ArgumentCollection
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('country_id', null, true),
            Argument::createAnyTypeArgument('city', null, true),
            Argument::createAnyTypeArgument('zipcode', null, true),
            Argument::createFloatTypeArgument('search_radius', 10)
        );
    }


    /**
     * @return array
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function buildArray(): array
    {
        $event = new FindRelayEvent(
            $this->getCountryId(),
            $this->getCity(),
            $this->getZipcode(),
            $this->getSearchRadius()
        );

        $this->dispatcher->dispatch($event, MondialRelayEvents::FIND_RELAYS);

        return $event->getPoints();
    }

    public function parseResults(LoopResult $loopResult): LoopResult
    {
        foreach ($loopResult->getResultDataCollection() as $item) {
            $loopResultRow = new LoopResultRow($item);

            $loopResultRow
                ->set("ID", $item['id'])
                ->set("LATITUDE", $item['latitude'])
                ->set("LONGITUDE", $item['longitude'])
                ->set("ZIPCODE", $item['zipcode'])
                ->set("CITY", $item['city'])
                ->set("COUNTRY", $item['country'])
                ->set("NAME", $item['name'])
                ->set("ADDRESS", $item['address'])
                ->set("DISTANCE", $item['distance'])
                ->set("OPENINGS", $item['openings'])
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
