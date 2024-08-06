<?php

namespace Hyvor\HyvorTalkWP\Admin\Rest;

use Hyvor\HyvorTalkWP\Context;

class AdminRest {

	public static function registerRestRoutes() {
		register_rest_route('hyvor-talk/v1', '/init', [
			'methods' => 'GET',
			'callback' => [SettingsController::class, 'init'],
			'permission_callback' => [self::class, 'permissions'],
		]);
		/*register_rest_route('hyvor-talk/v1', '/website', [
			'methods' => 'POST',
			'callback' => [self::class, 'setWebsite'],
			'permission_callback' => [self::class, 'setWebsitePermission'],
		]);*/
	}

	public static function permissions() {
		return true;
	}

}
