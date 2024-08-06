<?php

namespace Hyvor\HyvorTalkWP\Admin\Rest;

class SettingsController {

	public static function init()
	{
		$data = array('message' => 'Hello from the API!');
		return new \WP_REST_Response($data, 200);
	}

}
