<?php
/**
 * 
 *
 * @link       https://talk.hyvor.com
 * @since      1.0
 *
 * @package    HyvorTalk
 * @subpackage HyvorTalk/html
 */

$var = $GLOBALS['HYVOR_TALK_PLUGIN_JS_CONFIG'];
?>

<?php if ($var['loadMode'] === 'click'): ?>

    <?php
    $uniqueId = uniqid(); // Generate a random unique string

    ?>

    <div style="text-align:center">
        <button id="hyvor-talk-load-button-<?php echo $uniqueId ?>" onclick="this.style.display='none'">
            <?php echo __('Load Comments') ?>
        </button>
    </div>

    <script>
        document.getElementById("hyvor-talk-load-button-<?php echo $uniqueId ?>").addEventListener("click", function() {
            const hyvorTalkComments = document.querySelector("hyvor-talk-comments[data-unique-id='<?php echo $uniqueId ?>']");
            hyvorTalkComments.load();
        });
    </script>

<?php endif; ?>

<div class="comments-area">
    <?php include 'v3-component.php' ?>
</div>

<script async src="https://talk.hyvor.com/embed/embed.js" type="module"></script>