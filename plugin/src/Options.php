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

    // Webhook secret key
    const WEBHOOK_SECRET_KEY = 'hyvor_talk_webhook_secret_key';

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
    const DEFAULT_PAGE_ID = 'hyvor_talk_default_page_id';

    // Newsletters
    const NEWSLETTERS_AUTO_SUBSCRIBE_ON_SIGNUP = 'hyvor_talk_newsletters_auto_subscribe_on_signup';


    // Memberships
    const MEMBERSHIPS_ENABLED = 'hyvor_talk_memberships_enabled';
    const MEMBERSHIPS_PAGES = 'hyvor_talk_memberships_pages';
    const MEMBERSHIPS_GATED_CONTENT_RULES = 'hyvor_talk_memberships_gated_content_rules';


    public static function allKeys()
    {
        return [
            self::WEBSITE_ID,
            self::CONSOLE_API_KEY,
            self::SSO_PRIVATE_KEY,
            self::ENCRYPTION_KEY,
            self::WEBHOOK_SECRET_KEY,
            self::INSTANCE,

            // comments
            self::COMMENTS_ENABLED,
            self::COMMENT_COUNTS_ENABLED,
            self::LOADING_MODE,
            self::DEFAULT_PAGE_ID,

            // newsletters
            self::NEWSLETTERS_AUTO_SUBSCRIBE_ON_SIGNUP,

            // memberships
            self::MEMBERSHIPS_ENABLED,
            self::MEMBERSHIPS_PAGES,
            self::MEMBERSHIPS_GATED_CONTENT_RULES,
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
            'default_page_id' => self::defaultPageId(),

            // newsletters
            'newsletters_auto_subscribe_on_signup' => self::newslettersAutoSubscribeOnSignup(),

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
    public static function webhookSecretKey()
    {
        return self::nullableString(self::WEBHOOK_SECRET_KEY);
    }

    /**
     * @return ?string
     */
    public static function instance()
    {
        return self::nullableString(self::INSTANCE) ?? 'https://talk.hyvor.com';
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
    public static function defaultPageId()
    {
        return get_option(self::DEFAULT_PAGE_ID, 'post_id');    // confirm the default value
    }

    public static function newslettersAutoSubscribeOnSignup()
    {
        return boolval(get_option(self::NEWSLETTERS_AUTO_SUBSCRIBE_ON_SIGNUP));
    }

    public static function membershipsEnabled()
    {
        return boolval(get_option(self::MEMBERSHIPS_ENABLED));
    }

    public static function membershipsPages()
    {
        return self::nullableArray(self::MEMBERSHIPS_PAGES);
    }

    public static function membershipsGatedContentRules()
    {
        return self::nullableArray(self::MEMBERSHIPS_GATED_CONTENT_RULES) ?? [];
    }

    /**
     * @param array<string, mixed> $options
     */
    public static function withDefaults($options)
    {
        $defaults = [
            'instance' => 'https://talk.hyvor.com',
        ];
        foreach ($defaults as $key => $value) {
            if (!isset($options[$key])) {
                $options[$key] = $value;
            }
        }
        return $options;
    }

    private static function nullableArray(string $key)
    {
        $value = get_option($key);

        if ($value === false) {
            return null;
        }

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
