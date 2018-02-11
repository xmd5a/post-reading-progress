<?php
declare(strict_types=1);

namespace wrp;
use wrp\includes\BaseSettingsInterface as BaseSettingsInterface;

if (!defined('ABSPATH')) {
    exit;
}

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

require_once('includes/PluginSettingsInterface.php');
require_once('includes/BaseSettingsInterface.php');
require_once('includes/PluginSettings.php');

class ReadingProgress implements BaseSettingsInterface
{
    public function __construct()
    {
        //initialize plugin settings
        $pluginSettings = new includes\PluginSettings();
        $pluginSettings->addSection(
            'post-reading-progress-settings',
            'Post Reading Progress Settings',
            function () {
                printf('<p>%s</p>', __('Short pointless description', 'post-reading-progress'));
            },
            'reading'
        );
        try {
            foreach (self::PLUGIN_OPTIONS['options'] as $option) {
                $pluginSettings->addSettingsField(
                    $option['id'],
                    $option['title'],
                    $option['type'],
                    $option['page'],
                    array($pluginSettings, $option['callback']),
                    $option['options'],
                    self::PLUGIN_OPTIONS['section-slug']
                );
            }
        } catch (\Exception $e) {
            wp_die($e->getMessage());
        }

        $pluginSettings->init();

        //include js files
        add_action('wp_enqueue_scripts', array($this, 'includeJS'));

        //load plugin translations
        add_action('plugins_loaded', array($this, 'loadPluginTranslations'));

        //set marker element at end of post
        add_filter('the_content', array($this, 'setPostEndMarker'));


    }

    public function includeJS()
    {
        wp_enqueue_script(__CLASS__, plugins_url('/public/js/bundle.js', __FILE__), null, self::PLUGIN_VERSION, true);
        wp_enqueue_style('CSS', plugins_url('/public/css/bundle.css', __FILE__), null, self::PLUGIN_VERSION, 'all');
    }

    public function loadPluginTranslations()
    {
        load_plugin_textdomain(self::PLUGIN_SLUG, false, basename(dirname(__FILE__)) . '/languages');
    }

    public function setPostEndMarker(string $content): string
    {
        if (is_single())
            return $content . '<div id="wordpress-reading-progress-end"></div>';
    }
}

$readingProgress = new ReadingProgress();

?>