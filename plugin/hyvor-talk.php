<?php
/**
 * @package HyvorTalk
 */
/*
Plugin Name: Hyvor Talk - Comments, Newsletters, & Memberships
Plugin URI: https://talk.hyvor.com
Description: Hyvor Talk is a privacy-first, fully-featured platform for comments, newsletters, memberships.
Version: 1.3.3
Author: HYVOR
Author URI: https://hyvor.com
License: GPLv2 or later
Text Domain: hyvor-talk
Domain Path: /languages
*/

/*
Copyright (C) 2024  HYVOR

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

use Hyvor\HyvorTalkWP\Context;

if (!defined('ABSPATH'))
	die;

// composer autoload
include_once __DIR__ . '/vendor/autoload.php';

$context = new Context(__FILE__);
$context->init();
