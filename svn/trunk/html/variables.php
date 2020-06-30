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
$ssoData =  !empty($var['sso']) ? $var['sso'] : null;

if ($ssoData) {
	$ssoEncodedUserData = base64_encode(json_encode($ssoData['userData']));
	$ssoHash = hash_hmac('sha1', $ssoEncodedUserData, $ssoData['privateKey']);
}
?>

<script type="text/javascript">
	var HYVOR_TALK_WEBSITE = <?= $var['websiteId'] ?>; // DO NOT CHANGE THIS
	var HYVOR_TALK_CONFIG = {
		url: "<?= $var['url'] ?>", // THE CANONICAL URL OF THE WEBPAGE
		id: "<?= $var['identifier'] ?>", // UNIQUE ID TO IDENTIFY THE PAGE
		title: "<?= $var['title'] ?>",
		loadMode: "<?= $var['loadMode'] ?>",
		clickId: "hyvor-talk-load-button"
	};

	<?php if ($ssoData) : ?>
		HYVOR_TALK_CONFIG.sso = {
			hash: "<?= $ssoHash ?>",
			userData: "<?= $ssoEncodedUserData ?>",
			loginURL: "<?= wp_login_url(get_permalink()) ?>",
			signupURL: "<?= wp_registration_url() ?? '' ?>"
		}
	<?php endif; ?>

</script>