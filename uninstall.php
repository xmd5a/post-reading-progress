<?php
declare(strict_types=1);

namespace wrp;

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

require_once('includes/PluginOptions.php');

class ReadingProgressUninstall
{
    public function __construct()
    {
        foreach (includes\PluginOptions::getOptions() as $optionID => $option) {
            delete_option($optionID);
        }
    }
}

$uninstall = new ReadingProgressUninstall;