<?php
declare(strict_types=1);

namespace wrp;

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

require_once('includes/PluginOptions.php');
require_once('includes/PluginSettings.php');

final class ReadingProgress
{
    const PLUGIN_VERSION = '1.0.0';
    const PLUGIN_NAME = 'Post Reading Progress';
    const PLUGIN_SLUG = 'post-reading-progress';

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
            foreach (\wrp\includes\PluginOptions::getOptions() as $optionID => $option) {
                $pluginSettings->addSettingsField(
                    $optionID,
                    $option['title'],
                    $option['type'],
                    $option['page'],
                    array($pluginSettings, $option['callback']),
                    $option['options'],
                    'post-reading-progress-settings'
                );
            }
        } catch (\Exception $e) {
            wp_die($e->getMessage());
        }

        $pluginSettings->init();

        //include js files
        add_action('wp_enqueue_scripts', array($this, 'includeJS'));
        add_action('admin_enqueue_scripts', array($this, 'includeAdminJS'));

        //load plugin translations
        add_action('plugins_loaded', array($this, 'loadPluginTranslations'));

        //set marker element at end of post
        add_filter('the_content', array($this, 'setPostEndMarker'));

        //print generated by plugin options CSS
        add_action('wp_head', array($this, 'printPluginOptionsCSS'));
    }

    public function includeJS()
    {
        if (\wrp\includes\PluginOptions::getEnablePluginOption() == 1) {
            if (in_array(get_post_type(), \wrp\includes\PluginOptions::getEnabledPostTypesOption())) {
                wp_enqueue_script(__CLASS__, plugins_url('/public/js/bundle.js', __FILE__), null, self::PLUGIN_VERSION, true);
                wp_enqueue_style('CSS', plugins_url('/public/css/bundle.css', __FILE__), null, self::PLUGIN_VERSION, 'all');
            }
        }
    }

    public function includeAdminJS(string $hook)
    {
        if ($hook == 'options-reading.php') {
            wp_enqueue_script(__CLASS__ . 'admin', plugins_url('/admin/js/bundle.js', __FILE__), array('jquery', 'iris'), self::PLUGIN_VERSION, true);
            wp_enqueue_style('CSS', plugins_url('/admin/css/bundle.css', __FILE__), null, self::PLUGIN_VERSION, 'all');
        }
    }

    public function printPluginOptionsCSS()
    {
        vprintf("<style type=\"text/css\">#wordpress-reading-progress-bar{background: %s;}#wordpress-reading-progress-bar>div{background: %s;}</style>", array(
            \wrp\includes\PluginOptions::getBackgroundOption(),
            \wrp\includes\PluginOptions::getForegroundOption()
        ));
    }

    public function loadPluginTranslations()
    {
        load_plugin_textdomain(self::PLUGIN_SLUG, false, basename(dirname(__FILE__)) . '/languages');
    }

    public function setPostEndMarker(string $content): string
    {
        //check plugin is enabled
        $enabled = \wrp\includes\PluginOptions::getEnablePluginOption() == 1;

        if ($enabled === true) {
            //check current post type should have progress reading bar
            $postTypeActive = in_array(get_post_type(), \wrp\includes\PluginOptions::getEnabledPostTypesOption());

            if ((is_single() && $postTypeActive === true) or (is_page() && $postTypeActive)) {
                return $content . '<div id="wordpress-reading-progress-end"></div>';
            }

        }

        return $content;
    }
}

$readingProgress = new ReadingProgress();

?>