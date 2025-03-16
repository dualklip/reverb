<?php

namespace Laravel\Reverb\Protocols\Twilio\Channels;

use Laravel\Reverb\Protocols\Pusher\Channels\Concerns\InteractsWithPresenceChannels;

class PresenceCacheChannel extends CacheChannel
{
    use InteractsWithPresenceChannels;
}
