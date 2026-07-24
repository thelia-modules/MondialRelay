<?php

namespace MondialRelay\Model\Event;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Event\ActiveRecordEvent;
use MondialRelay\Model\MondialRelayZoneConfiguration;

class MondialRelayZoneConfigurationEvent extends ActiveRecordEvent
{
    const PRE_SAVE = 'propel.pre.save.mondial_relay_zone_configuration';
    const POST_SAVE = 'propel.post.save.mondial_relay_zone_configuration';
    const PRE_INSERT = 'propel.pre.insert.mondial_relay_zone_configuration';
    const POST_INSERT = 'propel.post.insert.mondial_relay_zone_configuration';
    const PRE_UPDATE = 'propel.pre.update.mondial_relay_zone_configuration';
    const POST_UPDATE = 'propel.post.update.mondial_relay_zone_configuration';
    const PRE_DELETE = 'propel.pre.delete.mondial_relay_zone_configuration';
    const POST_DELETE = 'propel.post.delete.mondial_relay_zone_configuration';

    /** @var MondialRelayZoneConfiguration */
    protected $model;

    /**
     * @param MondialRelayZoneConfiguration|ActiveRecordInterface $mondialRelayZoneConfiguration
     */
    public function __construct(MondialRelayZoneConfiguration $mondialRelayZoneConfiguration)
    {
        $this->model = $mondialRelayZoneConfiguration;
    }

    /**
     * @return MondialRelayZoneConfiguration|ActiveRecordInterface
     */
    public function getModel()
    {
        return $this->model;
    }
}
