<?php
declare(strict_types=1);

namespace wrp;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Plugin Name: Post Reading Progress
 * Plugin URI: http:/piotrszarmach.com
 * Description: Add reading progress bar on top or bottom of single post.
 * Author: Piotr Szarmach
 * Text Domain: post-reading-progress
 * Domain Path: /languages
 * Version: 1.1.2
 * Author URI: http://piotrszarmach.com
 * License: GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

require_once('vendor/autoload.php');

$readingProgress = new includes\ReadingProgress();
