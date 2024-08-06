<div id="wp-hyvor-talk-admin"></div>
<script>
    var HYVOR_TALK_REST_URL = '<?php echo rest_url('hyvor-talk/v1') ?>';
    var HYVOR_TALK_NONCE = '<?php echo wp_create_nonce('wp_rest') ?>';
</script>
<script src="<?php echo $pluginUrl ?>static/admin/admin.js?v=<?php echo $pluginVersion ?>"></script>
<link rel="stylesheet" href="<?php echo $pluginUrl ?>static/admin/admin.css?v=<?php echo $pluginVersion ?>">
