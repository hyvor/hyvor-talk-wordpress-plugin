<?php

namespace Hyvor\HyvorTalkWP\Embed;

use Hyvor\HyvorTalkWP\Context;
use Hyvor\HyvorTalkWP\Options;

class Attributes
{

    /**
     * @param array{
     *     instance?: bool,
     *     website-id?: bool,
     *     language?: bool,
     *     sso?: bool,
     * } $defaults
     */
    public static function attributes(
        Context $context,
        string $filter,
        array $defaults = [],
        array $extra = []
    )
    {

        $defaults = array_merge([
            'instance' => true,
            'website-id' => true,
            'language' => true,
        ], $defaults);

        $options = Options::withDefaults($context->options);

        $attrs = [];

        if ($defaults['instance']) {
            $attrs['instance'] = $options['instance'];
        }

        if ($defaults['website-id']) {
            $attrs['website-id'] = $options['website_id'];
        }

        if ($defaults['language']) {
            $attrs['language'] = apply_filters('hyvor_talk_language', null);
        }

        $attrs = array_merge($attrs, $extra);

        $attrs = apply_filters($filter, $attrs);

        // remove null values
        return array_filter($attrs, function ($value) {
            return $value !== null;
        });

    }

}
