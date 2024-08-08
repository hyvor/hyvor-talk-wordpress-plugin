<?php

namespace Hyvor\HyvorTalkWP\Embed;

use Hyvor\HyvorTalkWP\Context;
use Hyvor\HyvorTalkWP\Options;

class EmbedHooks
{

    /**
     * @var Context
     */
    private $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

    public function init()
    {
        // memberships
        if ($this->context->options['memberships_enabled']) {
            add_action('wp_footer', [$this, 'addMembershipsScripts']);
            add_filter('the_content', [$this, 'gatedContent'], 99);
        }
    }

    public function addMembershipsScripts()
    {
        $options = Options::withDefaults($this->context->options);
        ob_start();
        include($this->context->pluginDir . 'src/Embed/templates/memberships.template.php');
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    public function gatedContent($content)
    {

        $rules = $this->context->options['memberships_gated_content_rules'] ?? [];

        ob_start();

        $options = Options::withDefaults($this->context->options);
        $secure = $this->calculateSecure($content);
        include($this->context->pluginDir . 'src/Embed/templates/gated-content.template.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;

    }

    private function calculateSecure($content)
    {
        // source: https://github.com/hyvor/hyvor-talk-examples/blob/main/encryption/encryption.php

        $key = "Rc9hqOvVaXrpYgl9xtU4meBx2VXDlkkBYTENrevatJc=";

        $data = [
            'timestamp' => time(),
            'page-id' => 'my-page-id',
            'content' => $content,
            'minimum-plan' => 'MIT',
        ];

        $data = json_encode($data);
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', base64_decode($key), OPENSSL_RAW_DATA, $iv);

        return base64_encode($encrypted) . ':' . base64_encode($iv);

    }

}
