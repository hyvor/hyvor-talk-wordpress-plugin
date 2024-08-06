<?php

namespace Hyvor\HyvorTalkWP;

use Hyvor\HyvorTalkWP\Admin\AdminContext;

class Context
{

	const PLUGIN_IDENTIFIER = 'hyvor-talk';
	const PLUGIN_VERSION = '1.3.0';

    /**
     * The absolute path of the plugin directory (/var/www/.../wp-content/plugins/hyvor-talk/)
     * @var string
     */
    public $pluginDir;

	/**
	 * The URL of the plugin directory (http://example.com/wp-content/plugins/hyvor-talk/)
	 * @param string $pluginPath
	 */
	public $pluginUrl;


	/**
	 * The Hyvor Talk Website ID, if configured
	 * @var ?int
	 */
	public $websiteId;

    public function __construct(string $pluginPath)
    {

        $this->pluginDir = plugin_dir_path($pluginPath);
		$this->pluginUrl = plugin_dir_url($pluginPath);
		$this->websiteId = Options::websiteId();

    }

	public function init()
	{

		(new AdminContext($this))->init();

	}

}
