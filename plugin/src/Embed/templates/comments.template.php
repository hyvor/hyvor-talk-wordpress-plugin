<?php
    if (!isset($attributes)) {
        $attributes = $GLOBALS['hyvor_talk_comments_attributes'] ?? null;
    }
?>


<?php if (is_array($attributes)) : ?>

<script async src="<?php echo $attributes['instance'] ?>/embed/embed.js" type="module"></script>

<?php $uniqueId = uniqid(); ?>

<?php if ($attributes['loading'] === 'manual'): ?>

    <div style="text-align:center">
        <button class="button wp-element-button" id="hyvor-talk-load-button-<?php echo $uniqueId ?>" onclick="this.style.display='none'">
            <?php echo __('Load Comments') ?>
        </button>
    </div>

    <script>
        document.getElementById("hyvor-talk-load-button-<?php echo $uniqueId ?>").addEventListener("click", function () {
            const hyvorTalkComments = document.querySelector("hyvor-talk-comments[data-unique-id='<?php echo $uniqueId ?>']");
            hyvorTalkComments.load();
        });
    </script>

<?php endif; ?>

<div class="comments-area">
    <hyvor-talk-comments
    <?php foreach ($attributes as $key => $value): ?>
        <?php echo $key ?>="<?php echo esc_attr($value) ?>"
    <?php endforeach; ?>
        data-unique-id="<?php echo $uniqueId ?>"
    ></hyvor-talk-comments>
</div>

<?php endif; ?>

