<?php

namespace Hyvor\HyvorTalkWP;

class ConsoleApi
{

    private $options;

    public function __construct(Context  $context = null)
    {
        $this->options = $context ? $context->options : Options::all();
    }

    public function canCall()
    {
        return $this->options['website_id'] &&
            $this->options['console_api_key'];
    }

    /**
     * @param 'GET'|'POST'|'PATCH' $method
     * @param string $endpoint ex: /website
     * @param array $data
     * @return null|array
     */
    public function call(
        string $method,
        string $endpoint,
        array $data = []
    )
    {

        $endpoint = ltrim($endpoint, '/');

        $url = $this->options['instance'] . '/api/console/v1/' . $this->options['website_id'] . '/' . $endpoint;

        $isGet = $method === 'GET';
        if ($isGet) {
            $url .= '?' . http_build_query($data);
        }

        $headers = [
            'Content-Type' => 'application/json',
            'X-Api-Key' => $this->options['console_api_key'],
        ];

        $response = wp_remote_request(
            $url,
            [
                'method' => $method,
                'headers' => $headers,
                'body' => $isGet ? null : json_encode($data),
                'sslverify' => false,
            ]
        );

        if (is_wp_error($response)) {
            return null;
        }

        $body = wp_remote_retrieve_body($response);

        return json_decode($body, true);
    }

}
