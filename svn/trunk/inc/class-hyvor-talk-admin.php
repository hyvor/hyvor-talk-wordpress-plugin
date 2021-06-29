<?php

/** 
	* Admin functionality handler
	* @link https://talk.hyvor.com
	* @since 1.0
	* @package HyvorTalk
	* @subpackage HyvorTalk/inc
	* @author Supun Kavinda <admin@hyvor.com>
*/
namespace HyvorTalk;

class Admin {

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
	private $websiteId;

	/**
	* @since 1.0
	* @var string 	$consoleURL 	URL to the Hyvor Talk Console
	*/
	private $consoleURL;

	/**
	* @since 1.0
	* @var 	string 	$nonce 		The id for wp_create_nonce
	* Used to validate AJAX requests
	*/
	private $nonce = 'hyvor-talk';

	public function __construct($pluginIdentifier, $pluginVersion, $websiteId) {

		$this -> pluginIdentifier = $pluginIdentifier;
		$this -> pluginVersion = $pluginVersion;
		$this -> websiteId = $websiteId;

		$this -> consoleURL = 'https://talk.hyvor.com/console/';
        $this -> iconSpan = '<i class="ab-icon dashicons-admin-comments"></i>';
	}


	/**
	* Adds action link to the Hyvor Talk section of the plugin page in WP admin
	*
	* @since 1.0
	* @param 	array 	$links 	Exsisting links for Hyvor Talk
	* @param	string 	$file  	The filename of the plugin which the link is owned by
	*/
	public function addActionLink($links, $file) {

		if ($file === $this -> pluginIdentifier . '/' . $this -> pluginIdentifier . '.php') {

			$links[] = 
				'<a href="' . esc_url(get_admin_url( null, 'admin.php?page=hyvor-talk' ) ) . '">' .
					($this -> websiteId === null ? 
						__('Install', 'hyvor-talk') : 
						__('Configure', 'hyvor-talk') ) .
	            '</a>';
			 
		}

		return $links;

	}


	/**
	* Adds CSS styles for the admin panel
	* 
	* @since 1.0 
	*/
	public function addStyles() {

        wp_enqueue_style(
        	$this -> pluginIdentifier . '-admin',				// identifier
        	HYVOR_TALK_DIR_URL . 'static/admin.css',		// URL
        	array(),								// Dependencies
        	$this -> pluginVersion,					// Version
        	'all'									// Media written for (ex: 640px)
        );

	}

	/**
	* Adds Javascript for the admin panel
	* 
	* @since 1.0 
	*/
	public function addScripts() {
		
        # admin js
        wp_enqueue_script(
        	$this -> pluginIdentifier . '-admin',				// identifier
        	HYVOR_TALK_DIR_URL . 'static/admin.js',		// URL
        	array('jquery'),								// Dependencies
        	$this -> pluginVersion,					// Version
        	'all'									// Media written for (ex: 640px)
        );

        $adminOptions = array(
			'ajaxURL' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( $this -> nonce ),
	    );
	    wp_localize_script('hyvor-talk-admin', 'talkAdminOptions', $adminOptions);

	}


	/**
	* Creates the side menu
	*
	* @since 1.0
	*/

	public function createMenu() {

		// check if the user can moderate comments
		if (!current_user_can( 'moderate_comments'))
			return;

        // Remove the existing native wordpress comments plugin
        remove_menu_page( 'edit-comments.php' );

        add_menu_page(
            'Hyvor Talk Comments',
            'Hyvor Talk',
            'moderate_comments',
            'hyvor-talk',
            array( $this, 'createView'),
            'dashicons-admin-comments',
            24
        );
	}

	/**
	* Creates the global view of the admin panel
	*
	* @since 1.0
	*/
	public function createView() {
		require_once HYVOR_TALK_DIR_PATH . 'html/admin.php';
	}

	/**
	* Creates the bar menu shown in the bar of the wordpress
	* 
	* @since 1.0
	* @param 	WP_Admin_Bar $wpAdminBar    Instance of WP_Admin_Bar
	*/
	public function createBarMenu($wpAdminBar) {

		$wpAdminBar -> remove_node('comments');

		/* // parent
		$wpAdminBar -> add_node(array (
			'id' => 'hyvor-talk',
			'title' => 'Hyvor Talk',
			'href' => admin_url( 'admin.php?page=hyvor-talk' )
		));*/

		

	}	 

	/*********
	* AJAX FUNCTIONS START (a_ functions)
	*/

	public function a_saveSettings() {


		$this -> a_validateRequest();


		if (isset($_POST['websiteId']))
			HyvorTalk::setWebsiteId( (int) $_POST['websiteId'] );

		if ( isset($_POST['loadingMode']) )
			HyvorTalk::setLoadingMode( $_POST['loadingMode'] );

		if ( isset($_POST['ssoPrivateKey']) )
			HyvorTalk::setSSOPrivateKey( $_POST['ssoPrivateKey'] );

		$this -> a_finish();

	}

	public function a_validateRequest() {

		if (wp_verify_nonce($_POST['security'], $this -> nonce) === false)
			$this -> a_finish(false, array ('message' => 'Invalid Request'));

	}

	public function a_finish($status = true, $data = []) {

		header('Content-type: application/json');

		$return = array(
			'status' => $status
		);
		$data = (array) $data;
		$return = array_merge($return, $data);
		echo json_encode($return);
		die;

	}

}