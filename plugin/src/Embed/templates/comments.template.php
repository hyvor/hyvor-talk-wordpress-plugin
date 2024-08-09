<script async src="<?php echo $attributes['instance'] ?>/embed/embed.js" type="module"></script>
<hyvor-talk-comments
    <?php foreach ($attributes as $key => $value): ?>
        <?php echo $key ?>="<?php echo esc_attr($value) ?>"
    <?php endforeach; ?>
></hyvor-talk-comments>