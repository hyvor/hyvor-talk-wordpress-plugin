<?php

namespace Hyvor\HyvorTalkWP;

use Hyvor\HyvorTalkWP\Admin\AdminHooks;
use Hyvor\HyvorTalkWP\Embed\EmbedHooks;

class Context
{

    const PLUGIN_IDENTIFIER = 'hyvor-talk';

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
     * @var array<string, mixed>
     */
    public $options;

    public function __construct(string $pluginPath)
    {

        $this->pluginDir = plugin_dir_path($pluginPath);
        $this->pluginUrl = plugin_dir_url($pluginPath);

        //$this->websiteId = Options::websiteId();
        $this->options = Options::all();

    }

    public function pluginVersion()
    {
        $version = '0.0.0';
        if (function_exists('get_plugin_data')) {
            $version = get_plugin_data(
                $this->pluginDir . 'hyvor-talk.php'
            )['Version'] ?? $version;
        }
        return $version;
    }

    public function init()
    {

        (new AdminHooks($this))->init();
        (new EmbedHooks($this))->init();

    }

}
