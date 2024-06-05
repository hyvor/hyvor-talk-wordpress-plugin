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


	public function __construct($pluginIdentifier, $pluginVersion, $websiteId) {
		global $post; 

		$this -> pluginIdentifier = $pluginIdentifier;
		$this -> pluginVersion = $pluginVersion;
		$this -> websiteId = $websiteId;

	}

	/**
	* adds the Hyvor Talk plugin into the webpage if it is loadable
	* @since 1.0
	*/
	public function getCommentsPluginTemplate()
    {
        if ($this->isPluginLoadable()) {
            $this->setEmbedVariables(true);
            return HYVOR_TALK_DIR_PATH . '/html/embed.php';
        }

    }

    public function getCommentsPluginTemplateForBlock($preRender, $parsedBlock) {

        if ($parsedBlock['blockName'] === 'core/comments' && $this -> isPluginLoadable()) {
            $this -> setEmbedVariables(true);

            ob_start();
            include(HYVOR_TALK_DIR_PATH . '/html/embed.php');
            $content = ob_get_contents();
            ob_end_clean();

            return $content;
        }

    }


	/**
	 * updates comments counts 
	 * @since 1.1
	 */
	public function getCommentsCountTemplate($text) {
		global $post;

		if ($this -> isCommentCountsLoadable())
			return "<span data-talk-id=\"{$this -> getIdentifier($post)}\"></span>";
		else
			return $text;

	}

	public function addCommentsCountScript() {

		if ($this -> isCommentCountsLoadable()) {
			$this -> setEmbedVariables(false);
			include_once HYVOR_TALK_DIR_PATH . '/html/count.php';
		}

	}

	/**
	* Sets embed variables to use in JS
	*/
	public function setEmbedVariables($isForEmbed, $identifier = null) {
		if (!isset($GLOBALS['HYVOR_TALK_PLUGIN_WEBSITE_ID'])) {
			$GLOBALS['HYVOR_TALK_PLUGIN_WEBSITE_ID'] = $this->getWebsiteId();
		}

		if ($isForEmbed && !isset($GLOBALS['HYVOR_TALK_PLUGIN_JS_CONFIG'])) {
			$configVarsJS = array(
				'identifier' => $identifier !== null ? $identifier : $this -> getIdentifier(),
				'title' => $this -> getTitle(),
				'url' => $this -> getURL(),
				'loadMode' => HyvorTalk::getLoadingMode()
			);
	
			// SSO Start
			$ssoPrivateKey = HyvorTalk::getSSOPrivateKey();
			if ( !empty($ssoPrivateKey) ) {
				$userData = $this -> getSSOUserData();
				$configVarsJS['sso'] = [
					'userData' => $userData,
					'privateKey' => $ssoPrivateKey
				];
			}
			$GLOBALS['HYVOR_TALK_PLUGIN_JS_CONFIG'] = $configVarsJS;
		}
	}

	public function shortCodeComments($attr) {
		$this->setEmbedVariables(true, isset($attr['id']) ? $attr['id'] : null);
        ob_start();
		include HYVOR_TALK_DIR_PATH . '/html/embed.php';
        return ob_get_clean();
	}

	public function shortCodeCount($attr) {
		$this->setEmbedVariables(false);
		ob_start();
		include_once HYVOR_TALK_DIR_PATH . '/html/count.php';
		$content = ob_get_clean();

		$pageId = isset($attr['id']) ? $attr['id'] : '';
		$mode = isset($attr['mode']) && $attr['mode'] === 'number' ? "mode=\"number\"" : '';

		$content .= "<hyvor-talk-comment-count page-id={$pageId} {$mode}></hyvor-talk-comment-count>";
		return $content;
	}

	private function getSSOUserData() {
		$user = wp_get_current_user();

		if ($user -> ID == 0)
			return [];
		else 
			return [
				'id' => $user -> ID,
				'name' => $user -> display_name,
				'email' => $user -> user_email,
				'picture' => get_avatar_url($user -> ID),
				'url' => get_author_posts_url( $user -> ID )
			];
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

		// not for multi post pages
		if (!is_singular())
			return false;

		return true;
	}

	public function isCommentCountsLoadable() {

		// if the website id is not set
		if (!$this -> websiteId)
			return false;

		// reject feeds
		if (is_feed())
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
	* If post is not set gets the current page
	* @return int 	identifier  Very unique identifier for the current webpage
	*/
	public function getIdentifier() {
		global $post;

		if ($this->getWebsiteId() > 4500) {
			if (get_post_type() !== 'post')
				return false;
			return $post->ID;
		}

		$type = defined('HYVOR_TALK_ID_TYPE') ? HYVOR_TALK_ID_TYPE : 'default';		

		/**
		 * After importing from other third party, 
		 * HYVOR_TALK_ID_TYPE should be set to URL
		 * Then, the permalink is used
		 */
		switch ($type) {
			case 'url':
				$id = get_permalink($post);
				break;
			case 'id':
				$id = $post -> ID;
				break;
			default:
				// a trick to make it really unique
				$id = $post -> ID . ':' . $post -> guid;
				break;
		}


		return $id;
	}



	/**
	* Get the title of the page
	* @return string 	title
	*/
	public function getTitle() {
		global $post;

		$title = get_the_title($post);
		$title = strip_tags($title);
		$title = trim($title);
		return $title;
	}

	/**
	* Get the webpage URL
	* @return string Canontical URL of the page
	*/
	public function getURL() {
		global $post;

		return get_permalink($post);
	}


}