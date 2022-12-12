<?php
/** 
* @package HyvorTalk
*/
/*
Plugin Name: Comments by Hyvor Talk
Plugin URI: https://talk.hyvor.com
Description: The official WordPress plugin for Hyvor Talk, The Best Commenting Platform For Your Website
Version: 1.1.1
Author: Hyvor
Author URI: https://hyvor.com
License: GPLv2 or later
Text Domain: hyvor-talk
Domain Path: /languages
*/

/*
Copyright (C) 2019  Hyvor

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if (!defined( 'ABSPATH' ))
	die;

// DEFINE USEFUL CONSTS 


if (!defined('HYVOR_TALK_DIR_PATH'))
	define('HYVOR_TALK_DIR_PATH', plugin_dir_path(__FILE__));

if (!defined('HYVOR_TALK_DIR_URL'))
	define('HYVOR_TALK_DIR_URL', plugin_dir_url(__FILE__));


// the unique WP identifier of the plugin
define('HYVOR_TALK_IDENTIFIER', 'hyvor-talk');
// the version of the plugin
define('HYVOR_TALK_VERSION', '1.1.2');

require HYVOR_TALK_DIR_PATH . '/inc/class-hyvor-talk.php'; 

$hyvorTalk = new HyvorTalk\HyvorTalk();

/*
	Set the website ID to use in future
*/
define('HYVOR_TALK_WEBSITE_ID', $hyvorTalk -> websiteId);

/**
 * Where the configurations are saved
 * Can be accessed via all the included files
 */
$GLOBALS['HYVOR_TALK_PLUGIN_JS_CONFIG'] = [
	'websiteId' => null,
	'identifier' => null,
	'title' => '',
	'url' => '',
	'loadMode' => ''
];


/**
 * Used Options
 * 	
 * 		hyvor_talk_website_id  - the Website ID
 * 		hyvor_talk_loading_mode - loading mode
 * 
 */