<?php

/**
 * On uninstalling Hyvor Talk plugin
 * 
 * @since 1.1.1
 * 
 * @package HyvorTalk
 */

// exit if uninstall constant is not defined
if (!defined('WP_UNINSTALL_PLUGIN')) exit;


// delete the options
delete_option('hyvor_talk_website_id');
delete_option('hyvor_talk_loading_mode');