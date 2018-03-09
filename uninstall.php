<?php
declare(strict_types=1);

namespace wrp;

use wrp\includes\PluginOptions;

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

require_once('vendor/autoload.php');

$uninstall = new ReadingProgressUninstall;
