<?php
declare(strict_types=1);

namespace wrp;

use wrp\includes\PluginOptions;

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

require_once('includes/PluginOptions.php');

class ReadingProgressUninstall
{
    public function __construct()
    {
        $pluginOptions = PluginOptions::getInstance();

        foreach ($pluginOptions->getAllOptions() as $optionID => $option) {
            delete_option($optionID);
        }
    }
}

$uninstall = new ReadingProgressUninstall;