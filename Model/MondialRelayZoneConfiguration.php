<?php

namespace MondialRelay\Model;

use MondialRelay\Model\Base\MondialRelayZoneConfiguration as BaseMondialRelayZoneConfiguration;

class MondialRelayZoneConfiguration extends BaseMondialRelayZoneConfiguration
{
    const RELAY_DELIVERY_TYPE = 1;
    const HOME_DELIVERY_TYPE = 2;
    const ALL_DELIVERY_TYPE = 3;
}
