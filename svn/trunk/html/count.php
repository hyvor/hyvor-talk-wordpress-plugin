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
        "website-id": HYVOR_TALK_WEBSITE,
        
        // WPML: Add language parameter
        <?php if ( class_exists('Sitepress') && ! is_null( apply_filters( 'wpml_current_language', NULL ) ) ) { ?> 
            "language": "<?php echo esc_attr(apply_filters( 'wpml_current_language', NULL )); ?>"	
        <?php } ?>

        })
    });
</script>