<?php
namespace HyvorTalk;
/** 
	* The main class of the HyvorTalk Plugin for wordpress.
	* @link https://talk.hyvor.com
	* @since 1.0
	* @package HyvorTalk
	* @subpackage HyvorTalk/inc
	* @author Supun Kavinda <admin@hyvor.com>
*/
class HyvorTalk {

	/**
	* @since 1.0
	* @var String 	$pluginIdentifier 	Unique identifier for Hyvor Talk Official Plugin
	*/
	private $pluginIdentifier;

	/** 
	* @since 1.0
	* @var string /\d{2}\.\d{2}/ 	$pluginVersion 	The version of this plugin
	*/
	private $pluginVersion;

	/**
	* @since 1.0
	* @var int 		$websiteId 		ID of the website of the user of this wordpress website. Should be copied to wordpress								  by the user. Admin panel has the feature to adding the website ID
	*/
	public $websiteId;

	/**
	* @since 1.0
	* @var string 	WEBSITE_ID_OPTION_NAME  	Wordpress option name for website ID
	*/
	const WEBSITE_ID_OPTION_NAME = 'hyvor_talk_website_id';

	/**
	 * @since 1.1
	 * @var string  LOADING_MODE_OPTION_NAME 	WP Option name for the loading mode
	 */
	const LOADING_MODE_OPTION_NAME = 'hyvor_talk_loading_mode';
	
	/**
	 * @since 1.2
	 * @var int SSO_ID_OPTION_NAME SSO ID
	 */
	const SSO_PRIVATE_KEY_OPTION_NAME = 'hyvor_talk_sso_private_key';


	/** 
	* Sets the identifier 
	* Sets (or Gets) the website ID
	* Loads helpers
	* 
	* @since 1.0
	*/
	public function __construct() {

		$this -> pluginIdentifier = HYVOR_TALK_IDENTIFIER;
		$this -> pluginVersion = HYVOR_TALK_VERSION;

		$this -> websiteId = self::getWebsiteId();
		$this -> loadingMode = self::getLoadingMode();

		$this -> initHelpers(); 
		$this -> initAdminHooks();
		$this -> initWebPageHooks();

	}

	/**
	* Loads helper classes 
	* @since 1.0
	*/
	private function initHelpers() {

		/*
		* To handle everything in the admin panel
		*/
		require_once HYVOR_TALK_DIR_PATH . '/inc/class-hyvor-talk-admin.php';

		/**
		* To handle everything on a web page 
		*/
		require_once HYVOR_TALK_DIR_PATH . '/inc/class-hyvor-talk-webpage.php';

	}


	/**
	* Inits admin hooks for the plugin
	* @since 1.0
	*/
	private function initAdminHooks() {

		$admin = new Admin($this -> pluginIdentifier, $this -> pluginVersion, $this -> websiteId);

		// filters
		add_filter('plugin_action_links', array ($admin, 'addActionLink'), 10, 2); 

		// actions
		add_action('admin_enqueue_scripts', array ($admin, 'addStyles'));
		add_action('admin_enqueue_scripts', array ($admin, 'addScripts'));
		add_action('admin_menu', array($admin, 'createMenu'));
		add_action('admin_bar_menu', array($admin, 'createBarMenu'), 1000);


		// ajax
		add_action('wp_ajax_save_settings', array($admin, 'a_saveSettings'));


	}

	/**
	* Inits the webpage-related hooks for the plugin
	* @since 1.0
	*/
	private function initWebPageHooks() {

		$webpage = new WebPage($this -> pluginIdentifier, $this -> pluginVersion, $this -> websiteId);

		add_filter('comments_number', array ($webpage, 'getCommentsCountTemplate'));
		add_filter('comments_template', array($webpage, 'getCommentsPluginTemplate'));

		add_shortcode('hyvor-talk-comments', array($webpage, 'shortCodeComments'));
		add_shortcode('hyvor-talk-comments-count', array($webpage, 'shortCodeCount'));

		add_action('wp_footer', array ($webpage, 'addCommentsCountScript'));

		$this -> webpage = $webpage;

	}

	/**
	* @return int website ID (Null on no option)
	*/
	public static function getWebsiteId() {	

		$websiteId = get_option(self::WEBSITE_ID_OPTION_NAME);
		return $websiteId ? (int) $websiteId : null;

	}
	/**
	 * @return string loading mode
	 */
	public static function getLoadingMode() {
		$mode = get_option( self::LOADING_MODE_OPTION_NAME );
		return $mode ? $mode : 'default';
	}


	/**
	 * @return string SSO Private Key
	 */
	public static function getSSOPrivateKey() {
		$privateKey = get_option( self::SSO_PRIVATE_KEY_OPTION_NAME );
		return $privateKey ? $privateKey : null;
	}

	// Updates the website ID
	public static function setWebsiteId($websiteId) {
		update_option( self::WEBSITE_ID_OPTION_NAME, $websiteId );
	}
	// Updates the loading mode
	public static function setLoadingMode($mode) {
		update_option( self::LOADING_MODE_OPTION_NAME, $mode );
	}
	// updates the SSO Private Key
	public static function setSSOPrivateKey($key) {
		update_option( self::SSO_PRIVATE_KEY_OPTION_NAME, $key );
	}


}