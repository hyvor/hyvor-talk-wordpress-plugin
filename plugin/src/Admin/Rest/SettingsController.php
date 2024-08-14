<?php

namespace Hyvor\HyvorTalkWP\Admin\Rest;

use Hyvor\HyvorTalkWP\Admin\Helpers\PostTypeObject;
use Hyvor\HyvorTalkWP\ConsoleApi;
use Hyvor\HyvorTalkWP\Options;

class SettingsController
{

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
    public static function getWebsiteConfig()
    {

        $consoleApi = new ConsoleApi();

        if (!$consoleApi->canCall()) {
            return new \WP_REST_Response([
                'message' => 'Website ID or Console API Key is missing',
            ], 400);
        }

        $website = $consoleApi->call('GET', '/website');

        if ($website === null) {
            return new \WP_REST_Response([
                'message' => 'Failed to fetch website config',
            ], 500);
        }

        return new \WP_REST_Response($website, 200);
    }

    public static function setWebsiteConfig($request)
    {
        $params = $request->get_json_params();

        $action = $params['action'] ?? null;

        $consoleApi = new ConsoleApi();

        if (!$consoleApi->canCall()) {
            return new \WP_REST_Response([
                'message' => 'Website ID or Console API Key is missing',
            ], 400);
        }

        if ($action === 'sso_enable') {
            $loginUrl = wp_login_url();
            $loginUrl = add_query_arg('redirect_to', '$URL_ENCODED', $loginUrl);

            $response = $consoleApi->call(
                'PATCH',
                '/website',
                [
                    'auth_type' => 'sso',
                    'auth_sso_type' => 'stateless',
                    'sso_stateless_private_key' => true,
                    'sso_stateless_login_url' => $loginUrl
                ]
            );

            Options::update(Options::SSO_PRIVATE_KEY, $response['sso_stateless_private_key']);
        }

        elseif ($action === 'webhooks_enable') {
            $response = $consoleApi->call(
                'POST',
                '/webhook',
                [
                    'webhooks_enabled' => true,
                    'webhooks_url' => rest_url('hyvor-talk/v1/webhook'),
                ]
            );
        }

        $options = Options::all();

        return new \WP_REST_Response([
            'options' => $options,
        ], 200);


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
