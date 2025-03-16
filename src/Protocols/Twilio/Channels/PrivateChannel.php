<?php

namespace Laravel\Reverb\Protocols\Twilio\Channels;

use Laravel\Reverb\Protocols\Twilio\Channels\Concerns\InteractsWithPrivateChannels;

class PrivateChannel extends Channel
{
    use InteractsWithPrivateChannels;
}
