<?php

namespace MondialRelay\Model\Event;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Event\ActiveRecordEvent;
use MondialRelay\Model\MondialRelayDeliveryPrice;

class MondialRelayDeliveryPriceEvent extends ActiveRecordEvent
{
    const PRE_SAVE = 'propel.pre.save.mondial_relay_delivery_price';
    const POST_SAVE = 'propel.post.save.mondial_relay_delivery_price';
    const PRE_INSERT = 'propel.pre.insert.mondial_relay_delivery_price';
    const POST_INSERT = 'propel.post.insert.mondial_relay_delivery_price';
    const PRE_UPDATE = 'propel.pre.update.mondial_relay_delivery_price';
    const POST_UPDATE = 'propel.post.update.mondial_relay_delivery_price';
    const PRE_DELETE = 'propel.pre.delete.mondial_relay_delivery_price';
    const POST_DELETE = 'propel.post.delete.mondial_relay_delivery_price';

    /** @var MondialRelayDeliveryPrice */
    protected $model;

    /**
     * @param MondialRelayDeliveryPrice|ActiveRecordInterface $mondialRelayDeliveryPrice
     */
    public function __construct(MondialRelayDeliveryPrice $mondialRelayDeliveryPrice)
    {
        $this->model = $mondialRelayDeliveryPrice;
    }

    /**
     * @return MondialRelayDeliveryPrice|ActiveRecordInterface
     */
    public function getModel()
    {
        return $this->model;
    }
}
