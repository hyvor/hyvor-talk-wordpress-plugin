<?php

namespace Hyvor\HyvorTalkWP\Embed;

use Hyvor\HyvorTalkWP\Context;

class Comments
{
    public static function isCommentsEmbedLoadable(Context $context)
    {
        if (!SelectedPagesValidator::isSelected($context->options['comments_pages'])) {
            return;
        }

        $post = get_post();

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
        if (
            in_array($post->post_status, [
                'future',       // scheduled to be published in the future
                'draft',        // drafts
                'auto-draft',   // drafts
                'pending',      // awaiting to be published by a user
                'trash',        // trashed posts
            ])
        )
            return false;

        // if not a single post
        if (!is_singular())
            return false;

        return true;
    }

    public static function getLoadingMode(Context $context)
    {
        $loadingMode = $context->options['loading_mode'];

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

    public static function getPageId(Context $context)
    {
        $post = get_post();

        $websiteId = $context->options['website_id'];
        $instance = $context->options['instance'];
        $defaultPageId = $context->options['default_page_id'];

        /**
         * This is for backward compatibility
         */
        if (Cloud::isCloud($instance) && $websiteId <= 4500) {
            $type = defined('HYVOR_TALK_ID_TYPE') ? HYVOR_TALK_ID_TYPE : 'default';

            switch ($type) {
                case 'url':
                    return self::getUrl();
                case 'id':
                    return $post->ID;
                default:
                    return $post->ID . ':' . $post->guid;
            }
        }

        switch ($defaultPageId) {
            case 'post_id':
                return $post->ID;
            case 'url':
                return self::getUrl();
            case 'slug':
                return $post->post_name;
        }
    }

    public static function getTitle()
    {
        $post = get_post();
        return trim(strip_tags(get_the_title($post)));
    }

    public static function getUrl()
    {
        $post = get_post();
        return get_permalink($post);
    }


    public static function getPageIdForShortcode(Context $context, $attrs)
    {
        if (isset($attrs['id'])) {
            return $attrs['id'];
        } elseif (isset($attrs['page-id'])) {
            return $attrs['page-id'];
        } else {
            return self::getPageId($context);
        }
    }

}
