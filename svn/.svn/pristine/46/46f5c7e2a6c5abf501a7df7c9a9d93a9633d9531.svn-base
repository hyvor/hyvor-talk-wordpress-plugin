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
	var HYVOR_TALK_WEBSITE = <?= $websiteId ?>;

	<?php if(!empty($var)) : ?>
		<?php $identifier = $var['identifier'] === false ? 'false' :  "\"{$var['identifier']}\"" ?>
		var HYVOR_TALK_CONFIG = {
			url: "<?= $var['url'] ?>",
			id: <?= $identifier ?>,
			title: "<?= $var['title'] ?>",
			loadMode: "<?= $var['loadMode'] ?>",
			clickId: "hyvor-talk-load-button"
		};
	<?php endif; ?>

	<?php if ($ssoData) : ?>
		HYVOR_TALK_CONFIG.sso = {
			hash: "<?= $ssoHash ?>",
			userData: "<?= $ssoEncodedUserData ?>",
			loginURL: "<?= wp_login_url(get_permalink()) ?>",
			signupURL: "<?= wp_registration_url() ?? '' ?>"
		}
	<?php endif; ?>

</script>