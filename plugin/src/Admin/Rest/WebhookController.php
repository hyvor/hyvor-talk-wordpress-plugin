<?php

namespace Hyvor\HyvorTalkWP\Admin\Rest;

use Hyvor\HyvorTalkWP\Options;

class WebhookController
{

    /**
     * @param \WP_REST_Request $request
     */
    public static function handle()
    {

        $secretKey = Options::webhookSecretKey();

        if (!$secretKey) {
            return new \WP_REST_Response([
                'message' => 'Webhook secret key is not set',
            ], 400);
        }

        $requestBody = file_get_contents('php://input');

        $signature = hash_hmac('sha256', $requestBody, $secretKey);

        $givenSignature = $_SERVER['HTTP_X_SIGNATURE'] ?? null;

        if (!hash_equals($signature, $givenSignature)) {
            return new \WP_REST_Response([
                'message' => 'Invalid signature',
            ], 400);
        }

        $data = json_decode($requestBody, true);



    }

}