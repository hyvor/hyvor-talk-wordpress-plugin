<script async src="<?php echo $attributes['instance'] ?>/embed/memberships.js" type="module"></script>
<hyvor-talk-memberships
    <?php foreach ($attributes as $key => $value): ?>
        <?php echo $key ?>="<?php echo esc_attr($value) ?>"
    <?php endforeach; ?>
></hyvor-talk-memberships>
