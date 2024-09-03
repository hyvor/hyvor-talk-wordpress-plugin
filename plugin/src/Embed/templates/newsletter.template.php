<script async src="<?php echo esc_attr($attributes['instance']) ?>/embed/newsletter.js" type="module"></script>
<hyvor-talk-newsletter
    <?php foreach ($attributes as $key => $value): ?>
        <?php echo esc_attr($key) ?>="<?php echo esc_attr($value) ?>"
    <?php endforeach; ?>
></hyvor-talk-newsletter>
