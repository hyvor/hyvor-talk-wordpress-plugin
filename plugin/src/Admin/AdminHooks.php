<?php

namespace Hyvor\HyvorTalkWP\Admin;

use Hyvor\HyvorTalkWP\Admin\Rest\AdminRest;
use Hyvor\HyvorTalkWP\Admin\Rest\WebhookController;
use Hyvor\HyvorTalkWP\Context;
use Hyvor\HyvorTalkWP\Options;

class AdminHooks
{

	/**
	 * The context of the plugin
	 * @var Context
	 */
	private $context;

	public function __construct($context)
	{
		$this->context = $context;
	}

	/**
	 * We will register the admin hooks here
	 */
	public function init()
	{

		add_filter('plugin_action_links', [$this, 'addActionList'], 10, 2);

		add_action('admin_menu', [$this, 'createMenu']);
		add_action('rest_api_init', [$this, 'registerRestRoutes']);
		add_action('hyvor_talk_webhook_receive', [WebhookController::class, 'handleWebhookAction'], 10, 2);

	}

	/**
	 * Adds action link to the Hyvor Talk section of the plugin page in WP admin
	 *
	 * @param array $links Exsisting links
	 * @param string $file The filename of the plugin which the link is owned by
	 */
	public function addActionList($links, $file)
	{

		if ($file === Context::PLUGIN_IDENTIFIER . '/' . Context::PLUGIN_IDENTIFIER . '.php') {

			$links[] =
				'<a href="' . esc_url(get_admin_url(null, 'admin.php?page=hyvor-talk')) . '">' .
				($this->context->options['website_id'] === null ?
					__('Install', 'hyvor-talk') :
					__('Configure', 'hyvor-talk')) .
				'</a>';

		}

		return $links;

	}

	/**
	 * Creates the menu on the left size
	 * @return void
	 */
	public function createMenu()
	{

		// check if the user can moderate comments
		if (!current_user_can('moderate_comments'))
			return;

		// Remove the existing native wordpress comments plugin
		// remove_menu_page( 'edit-comments.php' );

		add_menu_page(
			'Hyvor Talk',
			'Hyvor Talk',
			'moderate_comments',
			'hyvor-talk',
			[$this, 'renderAdminPage'],
			'dashicons-format-chat',
			26 // right after comments
		);
	}

	public function renderAdminPage()
	{
		$pluginUrl = $this->context->pluginUrl;
		$pluginVersion = $this->context->pluginVersion();
		require_once $this->context->pluginDir . 'src/Admin/admin.template.php';
	}

	public function registerRestRoutes()
	{
		AdminRest::registerRestRoutes();
	}

}
