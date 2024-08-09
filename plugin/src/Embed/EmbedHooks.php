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
        if (!SelectedPagesValidator::isSelected($this->context->options['memberships_pages'])) {
            return;
        }

        ob_start();

        $attributes = Attributes::attributes(
            $this->context,
            'hyvor_talk_memberships_attributes',
            [
                'sso' => true,
            ]
        );

        if ($attributes === null) {
            return;
        }

        include($this->context->pluginDir . 'src/Embed/templates/memberships.template.php');
        $content = ob_get_contents();
        ob_end_clean();

        echo $content;
    }

    public function gatedContent($content)
    {

        // no gated content if memberships are not available
        if (!SelectedPagesValidator::isSelected($this->context->options['memberships_pages'])) {
            return $content;
        }

        // check if the current page matches a gated content rule
        $rules = $this->context->options['memberships_gated_content_rules'] ?? [];
        $matchedRule = GatedContent::getMatchedRule($rules);
        if (!$matchedRule) {
            return $content;
        }

        $encryptionKey = $this->context->options['encryption_key'];
        if (!$encryptionKey) {
            return $content;
        }

        ob_start();

        $options = Options::withDefaults($this->context->options);
        $secure = GatedContent::calculateSecure($content, $matchedRule, $encryptionKey);

        include($this->context->pluginDir . 'src/Embed/templates/gated-content.template.php');
        $content = ob_get_contents();

        ob_end_clean();

        return $content;

    }

}
