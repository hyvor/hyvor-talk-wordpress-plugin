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
        if (!$this->isEmbedsLoadable())
            return;

        // comments
        if ($this->context->options['comments_enabled']) {
            add_filter('pre_render_block', [$this, 'commentsEmbedForBlock'], 10, 2);
            add_filter('comments_template', [$this, 'commentsEmbed']);
        }

        // comment counts
        if ($this->context->options['comments_enabled'] && $this->context->options['comment_counts_enabled']) {
            add_filter('comments_number', [$this, 'commentCounts']);
            add_action('wp_footer', [$this, 'addCommentCountsScript']);
        }

        // newsletters
        // TODO

        // memberships
        if ($this->context->options['memberships_enabled']) {
            add_action('wp_footer', [$this, 'addMembershipsScripts']);
            add_filter('the_content', [$this, 'gatedContent'], 99);
        }
    }

    private function isEmbedsLoadable()
    {
        if (!$this->context->websiteId)
            return false;

        if (is_feed())
            return false;

        return true;
    }

    /************************************************************************************************************
     * COMMENTS
     */

    public function commentsEmbed()
    {
        if (!$this->isCommentsEmbedLoadable())
            return;
        
        $options = Options::withDefaults($this->context->options);
        $configVarJs = $this->setEmbedVariables(true);
        ob_start();
        include($this->context->pluginDir . 'src/Embed/templates/comments.template.php');
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function commentsEmbedForBlock($preRender, $parsedBlock)
    {
        if ($parsedBlock['blockName'] === 'core/comments')
            return $this->commentsEmbed();
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

    private function setEmbedVariables($isForCommentsEmbed, $identifier = null)
    {
        if (!$this->context->websiteId)
            $this->context->websiteId = Options::websiteId();


        if ($isForCommentsEmbed) {
            $configVarJs = [
                'identifier' => $identifier !== null ? $identifier : $this->getIdentifier(),
                'title' => $this->getTitle(),
                'url' => $this->getUrl(),
                'loadingMode' => Options::loadingMode(),
            ];

            // SSO
            $ssoPrivateKey = Options::ssoPrivateKey();
			if (!empty($ssoPrivateKey)) {
                $configVarJs['sso'] = [
                    'userData' => $this->getSsoUserData(),
                    'privateKey' => $ssoPrivateKey,
                ];
            }
            return $configVarJs;
        }
    }

    private function getIdentifier()
    {
        global $post;

        if (get_post_type() !== 'post')
				return false;

        // new logic
        // if ($this->context->websiteId > 4500) {
            // TODO: New logic HERE!
        // }

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

    private function getSsoUserData()
    {
        $user = wp_get_current_user();

        if ($user->ID === 0)
            return [];

        return [
            'id' => $user->ID,
            'name' => $user->display_name,
            'email' => $user->user_email,
            'picture' => get_avatar_url($user->ID),
            'url' => get_author_posts_url($user->ID)
        ];
    }

        

    /************************************************************************************************************
     * COMMENT COUNTS
     */
    public function commentCounts()
    {
        $options = Options::withDefaults($this->context->options);
        ob_start();
        include($this->context->pluginDir . 'src/Embed/templates/comment-counts.template.php');
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function addCommentCountsScript()
    {
        $options = Options::withDefaults($this->context->options);
        $configVarJs = $this->setEmbedVariables(false);
        ob_start();
        include($this->context->pluginDir . 'src/Embed/templates/comment-counts-script.template.php');
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
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
