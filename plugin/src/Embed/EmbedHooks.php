<?php

namespace Hyvor\HyvorTalkWP\Embed;

use Hyvor\HyvorTalkWP\Context;

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

        if (is_admin()) {
            return;
        }

        // memberships
        if ($this->context->options['memberships_enabled']) {
            add_action('wp_footer', [$this, 'addMembershipsScripts']);
            add_filter('the_content', [$this, 'gatedContent'], 99);

            add_shortcode('hyvor-talk-gated-content', [$this, 'gatedContentShortcode']);
        }
    }

    public function addMembershipsScripts()
    {
        if (!SelectedPagesValidator::isSelected($this->context->options['memberships_pages'])) {
            return;
        }

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

        echo RenderEmbed::render('memberships', $attributes);
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

        $attributes = Attributes::attributes(
            $this->context,
            'hyvor_talk_gated_content_attributes',
            [],
            [
                'secure' => GatedContent::calculateSecure(
                    $content,
                    $matchedRule['minimum_plan'],
                    $matchedRule['gate'],
                    $encryptionKey
                )
            ]
        );

        if (!$attributes) {
            return null;
        }

        return RenderEmbed::render('gated-content', $attributes);

    }

    public function gatedContentShortcode($attrs, $content)
    {

        if ($content) {

            $encryptionKey = $this->context->options['encryption_key'];

            if (!$encryptionKey) {
                return 'Encryption key not configured for gated content.';
            }

            $minimumPlan = $attrs['minimum-plan'] ?? null;
            if (!$minimumPlan) {
                return 'Minimum plan not set for gated content.';
            }

            $secure = GatedContent::calculateSecure(
                $content,
                $minimumPlan,
                $attrs['gate'] ?? null,
                $encryptionKey
            );

            $attrs['secure'] = $secure;

        }

        // directly pass attrs to the embed attributes
        $attributes = Attributes::attributes(
            $this->context,
            'hyvor_talk_gated_content_attributes',
            [],
            $attrs
        );

        if (!$attributes) {
            return null;
        }

        return RenderEmbed::render('gated-content', $attributes);
    }

}
