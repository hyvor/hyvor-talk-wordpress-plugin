<?php

namespace Hyvor\HyvorTalkWP\Admin\Rest;

class AdminRest {

	public static function registerRestRoutes() {
		register_rest_route('hyvor-talk/v1', '/init', [
			'methods' => 'GET',
			'callback' => [SettingsController::class, 'init'],
			'permission_callback' => [self::class, 'permissions'],
		]);
        register_rest_route('hyvor-talk/v1', '/option', [
            'methods' => 'PATCH',
            'callback' => [SettingsController::class, 'updateOption'],
            'permission_callback' => [self::class, 'permissions'],
        ]);
        register_rest_route('hyvor-talk/v1', '/post-taxonomy-search', [
            'methods' => 'GET',
            'callback' => [SettingsController::class, 'searchTaxonomies'],
            'permission_callback' => [self::class, 'permissions'],
        ]);
	}

    /**
     * Anyone who can manage options can also access the REST API endpoints.
     * https://wordpress.org/documentation/article/roles-and-capabilities/#manage_options
     */
	public static function permissions() {
		return current_user_can('manage_options');
	}

}
