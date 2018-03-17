<?php
declare(strict_types=1);

namespace wrp;

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

require_once('vendor/autoload.php');

foreach (includes\PluginOptions::getInstance()->getAllOptions() as $optionID => $option) {
    delete_option($optionID);
}
