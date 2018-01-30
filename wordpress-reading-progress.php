<?php
declare(strict_types=1);

/**
 * Plugin Name: Post Reading Progress
 * Plugin URI: http:/piotrszarmach.com
 * Description: Add reading progress bar on top or bottom of page and post reading time info on listing pages.
 * Author: Piotr Szarmach
 * Text Domain: post-reading-progress
 * Domain Path: /languages
 * Version: 1.0.0
 * Author URI: http://piotrszarmach.com
 * License: GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

require_once('src/PluginSettingsInterface.php');
require_once('src/PluginSettings.php');

class ReadingProgress
{
    public function __construct(PluginSettings $pluginSettings)
    {
        //initialize plugin settings
        $pluginSettings->init();
    }
}


$pluginSettings = new PluginSettings();
$pluginSettings->addSection(
    'post-reading-progress-settings',
    'Post Reading Progress Settings',
    function() {
        printf('<p>%s</p>', __('Short pointless description', 'post-reading-progress')) ;
    },
    'reading'
);
try {
    $pluginSettings->addSettingsField(
        'enable-plugin',
        __('Enable plugin', 'post-reading-progress'),
        'checkbox',
        'reading',
        array($pluginSettings, 'renderInputCheckbox'),
        'post-reading-progress-settings'
    );
} catch (Exception $e) {
    wp_die($e->getMessage());
}
$readingProgress = new ReadingProgress($pluginSettings);

?>