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

        $secretKey = Options::webhookSecret();

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
        Options::update(Options::WEBHOOK_LAST_DELIVERED_AT, time());
        do_action('hyvor_talk_webhook_action', $data);
    }

    public static function handleWebhookAction($data)
    {
        if ($data['event'] === 'memberships.subscription.created' || $data['event'] === 'memberships.subscription.updated') {
            self::updateUserMetadata($data);
        }

        elseif ($data['event'] === 'memberships.subscription.deleted') {
            self::updateUserMetadata($data, true);
        }
    }

    public static function updateUserMetadata($data, bool $isDelete = false)
    {
        $userId = $data['data']['user']['sso_id'];

        if (!$userId)
            return;

        if (!$isDelete) {
            update_metadata('user', $userId, 'hyvor_talk_membership_plan', $data['data']['plan']['name']);
        } else {
            delete_metadata('user', $userId, 'hyvor_talk_membership_plan');
        }     
    }
}
