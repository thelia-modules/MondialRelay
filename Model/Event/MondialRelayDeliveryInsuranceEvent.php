<?php

namespace MondialRelay\Model\Event;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Event\ActiveRecordEvent;
use MondialRelay\Model\MondialRelayDeliveryInsurance;

class MondialRelayDeliveryInsuranceEvent extends ActiveRecordEvent
{
    const PRE_SAVE = 'propel.pre.save.mondial_relay_delivery_insurance';
    const POST_SAVE = 'propel.post.save.mondial_relay_delivery_insurance';
    const PRE_INSERT = 'propel.pre.insert.mondial_relay_delivery_insurance';
    const POST_INSERT = 'propel.post.insert.mondial_relay_delivery_insurance';
    const PRE_UPDATE = 'propel.pre.update.mondial_relay_delivery_insurance';
    const POST_UPDATE = 'propel.post.update.mondial_relay_delivery_insurance';
    const PRE_DELETE = 'propel.pre.delete.mondial_relay_delivery_insurance';
    const POST_DELETE = 'propel.post.delete.mondial_relay_delivery_insurance';

    /** @var MondialRelayDeliveryInsurance */
    protected $model;

    /**
     * @param MondialRelayDeliveryInsurance|ActiveRecordInterface $mondialRelayDeliveryInsurance
     */
    public function __construct(MondialRelayDeliveryInsurance $mondialRelayDeliveryInsurance)
    {
        $this->model = $mondialRelayDeliveryInsurance;
    }

    /**
     * @return MondialRelayDeliveryInsurance|ActiveRecordInterface
     */
    public function getModel()
    {
        return $this->model;
    }
}
