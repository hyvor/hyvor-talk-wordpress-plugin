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


    public static function allKeys()
    {
        return [
            self::WEBSITE_ID,
            self::CONSOLE_API_KEY,
            self::SSO_PRIVATE_KEY,
            self::ENCRYPTION_KEY,
            self::INSTANCE,
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
            'website_id' => self::websiteId(),
            'console_api_key' => self::consoleApiKey(),
            'sso_private_key' => self::ssoPrivateKey(),
            'encryption_key' => self::encryptionKey(),
            'instance' => self::instance(),
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

    private static function nullableString(string $key)
    {
        $value = get_option($key);

        if ($value === false) {
            return null;
        }

        return strval($value);
    }


}
