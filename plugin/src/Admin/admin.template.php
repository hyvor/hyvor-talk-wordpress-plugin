<div id="wp-hyvor-talk-admin"></div>
<script>
    var HYVOR_TALK_REST_URL = '<?php echo rest_url('hyvor-talk/v1') ?>';
    var HYVOR_TALK_NONCE = '<?php echo wp_create_nonce('wp_rest') ?>';
</script>
<link rel="stylesheet" href="<?php echo $pluginUrl ?>static/admin/admin.css?v=<?php echo $pluginVersion ?>">
<link rel="preload" href="https://fonts.bunny.net/css?family=readex-pro:400,600" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
<script type="module" src="<?php echo $pluginUrl ?>static/admin/admin.js?v=<?php echo $pluginVersion ?>"></script>