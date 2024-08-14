<?php

namespace Hyvor\HyvorTalkWP\Admin\Rest;

use Hyvor\HyvorTalkWP\Admin\Helpers\PostTypeObject;
use Hyvor\HyvorTalkWP\ConsoleApi;
use Hyvor\HyvorTalkWP\Options;

class SettingsController {

	public static function init()
	{
        $options = Options::all();

		return new \WP_REST_Response([
            'options' => $options,
        ], 200);
	}

    /**
     * Website config fetched via the ConsoleAPI
     */
    public static function websiteConfig()
    {

        $consoleApi = new ConsoleApi();

        if (!$consoleApi->canCall()) {
            return new \WP_REST_Response([
                'message' => 'Website ID or Console API Key is missing',
            ], 400);
        }

        $website = $consoleApi->call('GET', '/website');

    }

    /**
     * @param \WP_REST_Request $request
     */
    public static function updateOption($request)
    {
        $options = $request->get_json_params();
        $allKeys = Options::allKeys();

        foreach ($options as $key => $value) {
            $key = 'hyvor_talk_' . $key;
            if (!in_array($key, $allKeys)) {
                return new \WP_REST_Response([
                    'message' => 'Invalid option key: ' . $key,
                ], 400);
            }
            Options::update($key, $value);
        }

        return new \WP_REST_Response(Options::all(), 200);
    }

    /**
     * @param \WP_REST_Request $request
     */
    public static function searchTaxonomies($request)
    {
        $search = $request->get_param('search');

        $objects = PostTypeObject::search($search);

        return new \WP_REST_Response($objects, 200);
    }

}
