<?php

namespace Hyvor\HyvorTalkWP\Admin\Rest;

class AdminRest {

	public static function registerRestRoutes() {
		register_rest_route('hyvor-talk/v1', '/init', [
			'methods' => 'GET',
			'callback' => [SettingsController::class, 'init'],
			'permission_callback' => [self::class, 'adminPermissions'],
		]);
        register_rest_route('hyvor-talk/v1', '/website-config', [
            'methods' => 'GET',
            'callback' => [SettingsController::class, 'getWebsiteConfig'],
            'permission_callback' => [self::class, 'adminPermissions'],
        ]);
        register_rest_route('hyvor-talk/v1', '/website-config', [
            'methods' => 'POST',
            'callback' => [SettingsController::class, 'setWebsiteConfig'],
            'permission_callback' => [self::class, 'adminPermissions'],
        ]);
        register_rest_route('hyvor-talk/v1', '/option', [
            'methods' => 'PATCH',
            'callback' => [SettingsController::class, 'updateOption'],
            'permission_callback' => [self::class, 'adminPermissions'],
        ]);
        register_rest_route('hyvor-talk/v1', '/post-taxonomy-search', [
            'methods' => 'GET',
            'callback' => [SettingsController::class, 'searchTaxonomies'],
            'permission_callback' => [self::class, 'adminPermissions'],
        ]);
        register_rest_route('hyvor-talk/v1', '/webhook', [
            'methods' => 'POST',
            'callback' => [WebhookController::class, 'handle'],
            'permission_callback' => [self::class, 'webhookPermissions'],
        ]);
	}

    /**
     * Anyone who can manage options can also access the REST API endpoints.
     * https://wordpress.org/documentation/article/roles-and-capabilities/#manage_options
     */
	public static function adminPermissions() {
		return current_user_can('manage_options');
	}

    public static function webhookPermissions() {
        return true;
    }

}
