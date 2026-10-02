<?php

namespace MondialRelay\Model\Event;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Event\ActiveRecordEvent;
use MondialRelay\Model\MondialRelayPickupAddress;

class MondialRelayPickupAddressEvent extends ActiveRecordEvent
{
    const PRE_SAVE = 'propel.pre.save.mondial_relay_pickup_address';
    const POST_SAVE = 'propel.post.save.mondial_relay_pickup_address';
    const PRE_INSERT = 'propel.pre.insert.mondial_relay_pickup_address';
    const POST_INSERT = 'propel.post.insert.mondial_relay_pickup_address';
    const PRE_UPDATE = 'propel.pre.update.mondial_relay_pickup_address';
    const POST_UPDATE = 'propel.post.update.mondial_relay_pickup_address';
    const PRE_DELETE = 'propel.pre.delete.mondial_relay_pickup_address';
    const POST_DELETE = 'propel.post.delete.mondial_relay_pickup_address';

    /** @var MondialRelayPickupAddress */
    protected $model;

    /**
     * @param MondialRelayPickupAddress|ActiveRecordInterface $mondialRelayPickupAddress
     */
    public function __construct(MondialRelayPickupAddress $mondialRelayPickupAddress)
    {
        $this->model = $mondialRelayPickupAddress;
    }

    /**
     * @return MondialRelayPickupAddress|ActiveRecordInterface
     */
    public function getModel()
    {
        return $this->model;
    }
}
