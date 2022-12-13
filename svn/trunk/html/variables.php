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

$websiteId = $GLOBALS['HYVOR_TALK_PLUGIN_WEBSITE_ID'];

$var = isset($GLOBALS['HYVOR_TALK_PLUGIN_JS_CONFIG']) ? $GLOBALS['HYVOR_TALK_PLUGIN_JS_CONFIG'] : null;

// SSO
/**
 * $ssoData = [
 * 	'userData' => [
 * 		'id' =>
 * 		'name' => 
 * 		'picture' =>
 * 		'url' =>
 * 	];
 * 	'id' => 
 * 	'privateKey' => 
 * ]
 */
$ssoData =  !empty($var) && !empty($var['sso']) ? $var['sso'] : null;

if ($ssoData) {
	$ssoEncodedUserData = base64_encode(json_encode($ssoData['userData']));
	$ssoHash = hash_hmac('sha1', $ssoEncodedUserData, $ssoData['privateKey']);
}
?>

<script type="text/javascript">
	var HYVOR_TALK_WEBSITE = <?php echo esc_html($websiteId) ?>;

	<?php if(!empty($var)) : ?>
		<?php $identifier = $var['identifier'] === false ? 'false' :  '"' . esc_html($var['identifier']) . '"' ?>
		var HYVOR_TALK_CONFIG = {
			url: "<?php echo esc_html($var['url']) ?>",
			id: <?php echo $identifier ?>,
			title: "<?php echo esc_html($var['title']) ?>",
			loadMode: "<?php echo esc_html($var['loadMode']) ?>",
			clickId: "hyvor-talk-load-button"
		};
	<?php endif; ?>

	<?php if ($ssoData) : ?>
		HYVOR_TALK_CONFIG.sso = {
			hash: "<?php echo esc_html($ssoHash) ?>",
			userData: "<?php echo esc_html($ssoEncodedUserData) ?>",
			loginURL: "<?php echo wp_login_url(get_permalink()) ?>",
			signupURL: "<?php echo wp_registration_url() ?? '' ?>"
		}
	<?php endif; ?>

</script>