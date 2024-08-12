<?php

namespace Hyvor\HyvorTalkWP\Embed;

class Cloud
{

    public const CLOUD_URL = 'https://talk.hyvor.com';

    public static function isCloud(string $instance)
    {
        return $instance === self::CLOUD_URL;
    }

}
