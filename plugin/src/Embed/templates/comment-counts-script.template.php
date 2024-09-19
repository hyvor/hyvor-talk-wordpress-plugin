<script src="<?php echo $attributes['instance'] ?>/embed/comment-counts.js" type="module"
    onload="loadHyvorTalkCommentCounts()"></script>
<script>
    function loadHyvorTalkCommentCounts() {
        hyvorTalkCommentCounts.load({
            <?php foreach ($attributes as $key => $value): ?>
                "<?php echo $key ?>": "<?php echo esc_attr($value) ?>",
            <?php endforeach; ?>
        })
    }
</script>
