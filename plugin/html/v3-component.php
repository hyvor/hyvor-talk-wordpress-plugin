<?php

$websiteId = $GLOBALS['HYVOR_TALK_PLUGIN_WEBSITE_ID'];
$var = isset($GLOBALS['HYVOR_TALK_PLUGIN_JS_CONFIG']) ? $GLOBALS['HYVOR_TALK_PLUGIN_JS_CONFIG'] : null;

$ssoData =  !empty($var) && !empty($var['sso']) ? $var['sso'] : null;

$userData = "";
$userHash = "";

if ($ssoData) {

    $user = wp_get_current_user();

    if ($user -> ID !== 0) {

        $userData = base64_encode(json_encode([
            'timestamp' => time(),
            'id' => $user -> ID,
            'name' => $user -> display_name,
            'email' => $user -> user_email,
            'picture_url' => get_avatar_url($user -> ID),
            'website_url' => get_author_posts_url( $user -> ID ),
            'bio' => strip_tags(get_the_author_meta('description', $user -> ID)),
        ]));
        $userHash = hash_hmac('sha256', $userData, $ssoData['privateKey']);

    }

}

?>

<hyvor-talk-comments
    website-id="<?php echo esc_attr($websiteId) ?>"
    page-id="<?php echo $var['identifier'] === false ? '' : esc_attr($var['identifier']) ?>"
    sso-user="<?php echo esc_attr($userData) ?>"
    sso-hash="<?php echo esc_attr($userHash) ?>"
    data-unique-id="<?php echo $uniqueId ?>"
    <?php if ($var['loadMode'] === 'default'): ?>
        loading="default"
    <?php elseif ($var['loadMode'] === 'scroll'): ?>
        loading="lazy"
    <?php elseif ($var['loadMode'] === 'click'): ?>
        loading="manual"
    <?php endif; ?>
></hyvor-talk-comments>

