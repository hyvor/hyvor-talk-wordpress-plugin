<?php

/** 
	* Webpage functionality handler
	* @link https://talk.hyvor.com
	* @since 1.0
	* @package HyvorTalk
	* @subpackage HyvorTalk/inc
	* @author Supun Kavinda <admin@hyvor.com>
*/
namespace HyvorTalk;

class WebPage {

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
	* Embed variables are set here
	* @since 1.0
	*/
	public $embedVariables; 


	public function __construct($pluginIdentifier, $pluginVersion, $websiteId) {
		global $post; 

		$this -> pluginIdentifier = $pluginIdentifier;
		$this -> pluginVersion = $pluginVersion;
		$this -> websiteId = $websiteId;
		$this -> wpPost = $post;

	}

	/**
	* adds the Hyvor Talk plugin into the webpage if it is loadable
	* @since 1.0
	*/
	public function getCommentsPluginTemplate() {

		if ($this -> isPluginLoadable()) 
			return HYVOR_TALK_DIR_PATH . '/html/embed.php';

	}

	/**
	* Sets embed variables to use in JS
	*/
	public function setEmbedVariables() {
		global $post;


		$this -> embedVariables = array(
			'websiteId' => $this -> getWebsiteId(),
			'identifier' => $this -> getIdentifier(),
			'title' => $this -> getTitle(),
			'url' => $this -> getURL()
		);

	}

	public function isPluginLoadable() {
		global $post;

		// if the website id is not set
		if (!$this -> websiteId)
			return false;

		if (is_feed())
			return false;

		// if it is a post
		if (!isset($post))
			return false;

		// only for post which are opened for comments
		if ($post -> comment_status !== 'open')
			return false;

		// the same
		if (!comments_open())
			return false;

		// do not load Hyvor Talk in some statuses of pages
		if (
			in_array(
				$post -> post_status,
				array(
					'future', 		// scheduled to be published in the future
					'draft',  		// drafts : Not actual posts
					'auto-draft',	// drafts : Not actual posts
					'pending', 		// Awaiting to be published by a user capable of it
					'trash',		// Trashed posts
				)
			)
		)
			return false;

		if (!is_singular())
			return false;

		return true;
	}

	/**
	* Get the website id
	* @return int 	website ID 	Unique website ID in Hyvor Talk. (Can be found in the console)
	*/
	public function getWebsiteId() {
		return $this -> websiteId;
	}

	/**
	* Get the identifier for each page
	* @return int 	identifier  Very unique identifier for the current webpage
	*/
	public function getIdentifier() {
		// a trick to make it really unique
		return $this -> wpPost -> ID . ':' . $this -> wpPost -> guid; 
	}

	/**
	* Get the title of the page
	* @return string 	title
	*/
	public function getTitle() {
		$title = get_the_title($this -> wpPost);
		$title = strip_tags($title);
		$title = trim($title);
		return $title;
	}

	/**
	* Get the webpage URL
	* @return string Canontical URL of the page
	*/
	public function getURL() {
		return get_permalink($this -> wpPost);
	}


}