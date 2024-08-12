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
        if (!$this->context->options['website_id'])
            return;

        if (is_admin()) {
            return;
        }

        // comments
        if ($this->context->options['comments_enabled']) {
            add_filter('pre_render_block', [$this, 'commentsEmbedForBlock'], 10, 2);
            add_filter('comments_template', [$this, 'commentsEmbed']);

            add_shortcode('hyvor-talk-comments', [$this, 'commentsShortcode']);
        }

        // comment counts
        if ($this->context->options['comments_enabled'] && $this->context->options['comment_counts_enabled']) {
            add_filter('comments_number', [$this, 'commentCounts']);
            add_action('wp_footer', [$this, 'addCommentCountsScript']);

            add_shortcode('hyvor-talk-comments-count', [$this, 'commentsCountShortcode']);
        }

        // newsletters
        // TODO


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

    public function commentsEmbed()
    {
        if (!$this->isEmbedLoadable() && !$this->isCommentsEmbedLoadable())
            return;

        $attributes = Attributes::attributes(
            $this->context,
            'hyvor_talk_comments_attributes',
            [
                'sso' => true,
            ],
            [
                'loading' => $this->getLoadingMode(),
                'page-id' => $this->getPageId(),
                'page-title' => $this->getTitle(),
                'page-url' => $this->getUrl(),
            ]
        );

        if ($attributes === null)
            return;

        return RenderEmbed::render('comments', $attributes);
    }

    public function commentsEmbedForBlock($preRender, $parsedBlock)
    {
        if ($parsedBlock['blockName'] === 'core/comments')
            return $this->commentsEmbed();
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
                'loading' => isset($attrs['loading']) ? $attrs['loading'] : $this->getLoadingMode(),
                'page-id' => $this->getPageIdForShortcode($attrs),
                'page-title' => isset($attrs['page-title']) ? $attrs['page-title'] : $this->getTitle(),
                'page-url' => isset($attrs['page-url']) ? $attrs['page-url'] : $this->getUrl(),
            ]
        );
        
        if ($attributes === null)
            return;
    
        return RenderEmbed::render('comments', $attributes);
    }

    /************************************************************************************************************
     * COMMENT COUNTS
     */
    public function commentCounts()
    {
        if (!$this->isEmbedLoadable())
            return;

        $attributes = Attributes::attributes(
            $this->context,
            'hyvor_talk_comment_counts_attributes',
            [],
            [
                'page-id' => $this->getPageId(),
            ]
        );

        if ($attributes === null)
            return;
            
        return RenderEmbed::render('comment-counts', $attributes);
    }

    public function addCommentCountsScript()
    {
        if (!$this->isEmbedLoadable())
            return;

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
            'hyvor_talk_comment_counts_attributes',
            [],
            [
                'page-id' => $this->getPageIdForShortcode($attrs),
                'mode' => isset($attrs['mode']) ? $attrs['mode'] : null,
            ]
        );

        if ($attributes === null)
            return;

        return RenderEmbed::render('comment-counts', $attributes);
    }
    
    /************************************************************************************************************
     * NEWSLETTERS
     */
    // TODO

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

    /************************************************************************************************************
     * HELPERS
     */

    private function isEmbedLoadable()
    {
        return is_feed() ? false : true;
    }

    private function isCommentsEmbedLoadable()
    {
        global $post;

        // if not a post
        if (!isset($post))
            return false;

        // if not open for comments
        if ($post->comment_status !== 'open')
            return false;

        // if not open for comments
        if (!comments_open())
            return false;

        // if post is in any of the given statuses
        if (in_array($post->post_status, [
            'future',       // scheduled to be published in the future
            'draft',        // drafts
            'auto-draft',   // drafts
            'pending',      // awaiting to be published by a user
            'trash',        // trashed posts
        ]))
            return false;

        // if not a single post
        if (!is_singular())
            return false;

        return true;
    }

    private static function getLoadingMode()
    {
        $loadingMode = Options::loadingMode();

        switch ($loadingMode) {
            case 'default':
                return 'default';
            case 'scroll':
                return 'lazy';
            case 'click':
                return 'manual';
            default:
                return null;
        }
    }

    private function getPageId()
    {
        global $post;

        if (get_post_type() !== 'post')
				return false;

        // new logic
        if ($this->context->options['website_id'] > 4500) {
            // TODO: Review this logic @supun-io
            switch ($this->context->options['default_page_id']) {
                case 'post_id':
                    return $post->ID;
                case 'url':
                    return $this->getUrl();
                case 'slug':
                    return $post->post_name;
                // Default value for options['default_page_id'] is 'post_id'
                // Hence the default case is omitted
            }
        }

        // old logic
		$type = defined('HYVOR_TALK_ID_TYPE') ? HYVOR_TALK_ID_TYPE : 'default';

		switch ($type) {
			case 'url':
				return $this->getUrl();
			case 'id':
				return $post->ID;
			default:
				return $post->ID . ':' . $post->guid;
		}
    }

    private function getTitle()
    {
        global $post;
        return trim(strip_tags(get_the_title($post)));
    }

    private function getUrl()
    {
        global $post;
        return get_permalink($post);
    }

    private function getPageIdForShortcode($attrs)
    {
        if (isset($attrs['id'])) {
            return $attrs['id'];
        } elseif (isset($attrs['page-id'])) {
            return $attrs['page-id'];
        } else {
            return $this->getPageId();
        }
    }
}
