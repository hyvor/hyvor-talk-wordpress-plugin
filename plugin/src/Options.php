<?php

namespace Hyvor\HyvorTalkWP;

class Options {

	/**
	 * Website ID of Hyvor Talk
	 * Only one supported per WP installation
	 */
	const WEBSITE_ID = 'hyvor_talk_website_id';

    /**
     * Console API Key of the website
     */
    const CONSOLE_API_KEY = 'hyvor_talk_console_api_key';

    /**
     * SSO Private Key of the website
     */
    const SSO_PRIVATE_KEY = 'hyvor_talk_sso_private_key';

    /**
     * Encryption key of the website
     */
    const ENCRYPTION_KEY = 'hyvor_talk_encryption_key';

    /**
     * Instance of the Hyvor Talk
     */
    const INSTANCE = 'hyvor_talk_instance';

    /**
     * Comments enabled
     */
    const COMMENTS_ENABLED = 'hyvor_talk_comments_enabled';

    /**
     * Comment counts enabled
     */
    const COMMENT_COUNTS_ENABLED = 'hyvor_talk_comment_counts_enabled';
    /**
     * Loading mode of the comments embed
     */
    const LOADING_MODE = 'hyvor_talk_loading_mode';

    /**
     * Default post ID for the comments embed
     */
    const DEFAULT_POST_ID = 'hyvor_talk_default_post_id';


    // Memberships
    const MEMBERSHIPS_ENABLED = 'hyvor_talk_memberships_enabled';
    const MEMBERSHIPS_PAGES = 'hyvor_talk_memberships_pages';
    const MEMBERSHIPS_GATED_CONTENT_RULES = 'hyvor_talk_membership_gated_content_rules';

    public static function allKeys()
    {
        return [
            self::WEBSITE_ID,
            self::CONSOLE_API_KEY,
            self::SSO_PRIVATE_KEY,
            self::ENCRYPTION_KEY,
            self::INSTANCE,

            // comments
            self::COMMENTS_ENABLED,
            self::COMMENT_COUNTS_ENABLED,
            self::LOADING_MODE,
            self::DEFAULT_POST_ID,

            // memberships
            self::MEMBERSHIPS_ENABLED,
            self::MEMBERSHIPS_PAGES,
            self::MEMBERSHIPS_GATED_CONTENT_RULES,
        ];
    }

    public static function jsonKeys()
    {
        return [
            self::MEMBERSHIPS_PAGES,
        ];
    }

    public static function update($key, $value)
    {
        if (!in_array($key, self::allKeys())) {
            return false;
        }

        if ($value === null) {
            delete_option($key);
        } else {
            if (in_array($key, self::jsonKeys())) {
                $value = json_encode($value);
            }

            update_option($key, $value);
        }

        return true;
    }

    public static function all()
    {

        return [
            // basic
            'website_id' => self::websiteId(),
            'console_api_key' => self::consoleApiKey(),
            'sso_private_key' => self::ssoPrivateKey(),
            'encryption_key' => self::encryptionKey(),
            'instance' => self::instance(),

            // comments
            'comments_enabled' => self::commentsEnabled(),
            'comment_counts_enabled' => self::commentCountsEnabled(),
            'loading_mode' => self::loadingMode(),
            'default_post_id' => self::defaultPostId(),

            // memberships
            'memberships_enabled' => self::membershipsEnabled(),
            'memberships_pages' => self::membershipsPages(),
            'memberships_gated_content_rules' => self::membershipsGatedContentRules(),
        ];

    }

	/**
	 * @return ?int
	 */
	public static function websiteId()
	{
		$websiteId = get_option(self::WEBSITE_ID);

		if ($websiteId === false) {
			return null;
		}

		return intval($websiteId);
	}

    /**
     * @return ?string
     */
    public static function consoleApiKey()
    {
        return self::nullableString(self::CONSOLE_API_KEY);
    }

    /**
     * @return ?string
     */
    public static function ssoPrivateKey()
    {
        return self::nullableString(self::SSO_PRIVATE_KEY);
    }

    /**
     * @return ?string
     */
    public static function encryptionKey()
    {
        return self::nullableString(self::ENCRYPTION_KEY);
    }

    /**
     * @return ?string
     */
    public static function instance()
    {
        return self::nullableString(self::INSTANCE);
    }

    /**
     * @return bool
     */
    public static function commentsEnabled()
    {
        return boolval(get_option(self::COMMENTS_ENABLED));
    }

    /**
     * @return bool
     */
    public static function commentCountsEnabled()
    {
        return boolval(get_option(self::COMMENT_COUNTS_ENABLED));
    }

    /**
     * @return string
     */
    public static function loadingMode()
    {
        return get_option(self::LOADING_MODE, 'default');
    }

    /**
     * @return string
     */
    public static function defaultPostId()
    {
        return get_option(self::DEFAULT_POST_ID, 'post_id');    // confirm the default value
    }

    public static function membershipsEnabled()
    {
        return boolval(get_option(self::MEMBERSHIPS_ENABLED));
    }

    public static function membershipsPages()
    {
        return self::nullabelJsonArray(self::MEMBERSHIPS_PAGES);
    }

    public static function membershipsGatedContentRules()
    {
        return self::nullabelJsonArray(self::MEMBERSHIPS_GATED_CONTENT_RULES) ?? [];
    }

    private static function nullabelJsonArray(string $key)
    {
        $value = get_option($key);

        if ($value === false) {
            return null;
        }

        $value = json_decode($value, true);

        if (!is_array($value)) {
            return null;
        }

        return $value;
    }

    private static function nullableString(string $key)
    {
        $value = get_option($key);

        if ($value === false) {
            return null;
        }

        return strval($value);
    }


}
