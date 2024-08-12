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
        ?string $filter = null,
        array $defaults = [],
        array $extra = []
    )
    {

        $defaults = array_merge([
            'instance' => true,
            'website-id' => true,
            'language' => true,
            'sso' => false,
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

        if ($defaults['sso']) {

            $user = self::getSsoUserData();
            $ssoPrivateKey = $options['sso_private_key'];

            if ($user && $ssoPrivateKey) {
                $user = apply_filters('hyvor_talk_sso_user', $user);

                $userData = base64_encode(json_encode($user));

                $attrs['sso-user'] = $userData;
                $attrs['sso-hash'] = hash_hmac('sha256', $userData, $ssoPrivateKey);
            }
        }

        $attrs = array_merge($attrs, $extra);

        if ($filter) {
            $attrs = apply_filters($filter, $attrs);
        }

        // remove null values
        return array_filter($attrs, function ($value) {
            return $value !== null;
        });

    }

    private static function getSsoUserData()
    {
        $user = wp_get_current_user();

        if ($user->ID === 0) {
            return null;
        }

        return [
            'timestamp' => time(),
            'id' => $user->ID,
            'name' => $user->display_name,
            'email' => $user->user_email,
            'picture_url' => get_avatar_url($user->ID),
            'website_url' => get_author_posts_url($user->ID),
            'bio' => strip_tags(get_the_author_meta('description', $user->ID)),
        ];
    }
}
