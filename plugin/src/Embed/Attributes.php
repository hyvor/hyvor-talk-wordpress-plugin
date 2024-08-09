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
     * } $which
     */
    public static function attributes(
        Context $context,
        string $filter,
        array $which
    )
    {

        $which = array_merge([
            'instance' => true,
            'website-id' => true,
            'language' => true,
        ], $which);

        $options = Options::withDefaults($context->options);

        $attrs = [];

        if ($which['instance']) {
            $attrs['instance'] = $options['instance'];
        }

        if ($which['website-id']) {
            $attrs['website-id'] = $options['website_id'];
        }

        if ($which['language']) {
            $attrs['language'] = apply_filters('hyvor_talk_language', null);
        }

        return apply_filters($filter, $attrs);

    }

}
