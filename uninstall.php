<?php
declare(strict_types=1);

namespace wrp;

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

require_once('vendor/autoload.php');

$uninstall = new includes\ReadingProgressUninstall;
