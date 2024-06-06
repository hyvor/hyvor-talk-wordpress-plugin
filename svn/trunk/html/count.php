<?php
/**
 * 
 *
 * @link       https://talk.hyvor.com
 * @since      1.0
 *
 * @package    HyvorTalk
 * @subpackage HyvorTalk/html
 * 
 * Adds Hyvor Talk comment count script to WordPress
 */

include 'variables.php';
?>

<script src="https://talk.hyvor.com/embed/comment-counts.js"></script>
<script>
    window.addEventListener('load', function() {
        hyvorTalkCommentCounts.load({
        "website-id": $HYVOR_TALK_WEBSITE
        })
    });
</script>