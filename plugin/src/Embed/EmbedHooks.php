<?php

namespace Hyvor\HyvorTalkWP\Embed;

use Hyvor\HyvorTalkWP\ConsoleApi;
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
        if (!$this->context->options['website_id'])
            return;

        if (is_admin()) {
            return;
        }

        // comments
        if ($this->context->options['comments_enabled']) {
            add_filter('pre_render_block', [$this, 'commentsEmbedForBlock'], 10, 2);
            add_filter('comments_template', [$this, 'commentsEmbedTemplate'], 99);
        }
        add_shortcode('hyvor-talk-comments', [$this, 'commentsShortcode']);

        // comment counts
        if ($this->context->options['comments_enabled'] && $this->context->options['comment_counts_enabled']) {
            add_filter('comments_number', [$this, 'commentCounts']);
            add_action('wp_footer', [$this, 'addCommentCountsScript']);
        }
        add_shortcode('hyvor-talk-comments-count', [$this, 'commentsCountShortcode']);

        // newsletters
        if ($this->context->options['newsletters_auto_subscribe_on_signup']) {
            add_action('user_register', [$this, 'newslettersAutoSubscribeOnSignup']);
        }
        add_shortcode('hyvor-talk-newsletter', [$this, 'newslettersShortcode']);

        // memberships
        if ($this->context->options['memberships_enabled']) {
            add_action('wp_footer', [$this, 'addMembershipsScripts']);
            add_filter('the_content', [$this, 'gatedContent'], 99);

            add_shortcode('hyvor-talk-gated-content', [$this, 'gatedContentShortcode']);
        }
    }

    /************************************************************************************************************
     * COMMENTS
     */

    public function commentsEmbedTemplate()
    {
        $templateAndAttrs = $this->commentsEmbedTemplateAndAttrs();

        if (!$templateAndAttrs) {
            return null;
        }

        // set global to be used in the template
        // when included outside of this function
        $GLOBALS['hyvor_talk_comments_attributes'] = $templateAndAttrs['attributes'];

        return $templateAndAttrs['template'];
    }

    private function commentsEmbedTemplateAndAttrs()
    {
        if (!Comments::isCommentsEmbedLoadable($this->context)) {
            return null;
        }

        $attributes = Attributes::attributes(
            $this->context,
            'hyvor_talk_comments_attributes',
            [
                'sso' => true,
            ],
            [
                'loading' => Comments::getLoadingMode($this->context),
                'page-id' => Comments::getPageId($this->context),
                'page-title' => Comments::getTitle(),
                'page-url' => Comments::getUrl(),
            ]
        );

        if ($attributes === null) {
            return null;
        }

        return [
            'template' => __DIR__ . '/templates/comments.template.php',
            'attributes' => $attributes,
        ];
    }

    public function commentsEmbedForBlock($preRender, $parsedBlock)
    {
        if ($parsedBlock['blockName'] === 'core/comments') {
            $data = $this->commentsEmbedTemplateAndAttrs();
            if (!$data) {
                return null;
            }
            return RenderEmbed::render('comments', $data['attributes']);
        }

        return null;
    }

    public function commentsShortcode($attrs)
    {
        $attributes = Attributes::attributes(
            $this->context,
            'hyvor_talk_comments_attributes',
            [
                'sso' => true,
            ],
            [
                'loading' => isset($attrs['loading']) ? $attrs['loading'] : Comments::getLoadingMode($this->context),
                'page-id' => Comments::getPageIdForShortcode($this->context, $attrs),
                'page-title' => isset($attrs['page-title']) ? $attrs['page-title'] : Comments::getTitle(),
                'page-url' => isset($attrs['page-url']) ? $attrs['page-url'] : Comments::getUrl(),
            ]
        );

        if ($attributes === null)
            return null;

        return RenderEmbed::render('comments', $attributes);
    }

    /************************************************************************************************************
     * COMMENT COUNTS
     */
    public function commentCounts()
    {
        $attributes = Attributes::attributes(
            $this->context,
            'hyvor_talk_comment_count_attributes',
            [],
            [
                'page-id' => Comments::getPageId($this->context),
            ]
        );

        if ($attributes === null)
            return null;

        return RenderEmbed::render('comment-counts', $attributes);
    }

    public function addCommentCountsScript()
    {
        $attributes = Attributes::attributes(
            $this->context
        );

        if ($attributes === null)
            return;

        echo RenderEmbed::render('comment-counts-script', $attributes);
    }

    public function commentsCountShortcode($attrs)
    {
        $attributes = Attributes::attributes(
            $this->context,
            'hyvor_talk_comment_count_attributes',
            [],
            [
                'page-id' => Comments::getPageIdForShortcode($this->context, $attrs),
                'mode' => isset($attrs['mode']) ? $attrs['mode'] : null,
            ]
        );

        if ($attributes === null)
            return null;

        return RenderEmbed::render('comment-counts', $attributes);
    }

    /************************************************************************************************************
     * NEWSLETTERS
     */

    public function newslettersAutoSubscribeOnSignup($userId)
    {
        $user = get_user_by('id', $userId);

        if (!$user) {
            return;
        }

        $email = $user->user_email;

        if (!$email) {
            return;
        }

        $consoleApi = new ConsoleApi($this->context);
        if (!$consoleApi->canCall()) {
            return;
        }

        $consoleApi->call(
            'POST',
            '/newsletter/subscribers',
            [
                'emails' => [$email],
            ]
        );

    }

    public function newslettersShortcode($attrs)
    {

        $attributes = Attributes::attributes(
            $this->context,
            'hyvor_talk_newsletter_attributes',
            [
                'sso' => true,
            ],
            $attrs
        );

        if ($attributes === null)
            return null;

        return RenderEmbed::render('newsletter', $attributes);

    }

    /************************************************************************************************************
     * MEMBERSHIPS
     */
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
