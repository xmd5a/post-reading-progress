<?php
declare(strict_types=1);

namespace wrp;

use wrp\includes\BaseSettingsInterface;

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

class ReadingProgressUninstall implements BaseSettingsInterface {

}