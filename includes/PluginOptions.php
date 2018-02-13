<?php

namespace wrp\includes;

if (!defined('ABSPATH')) {
    exit;
}

abstract class PluginOptions
{
    private static $options = array(
        'wordpress-reading-bar-enable-plugin' => array(
            'title' => 'Enable plugin',
            'type' => 'checkbox',
            'page' => 'reading',
            'callback' => 'renderInputCheckbox',
            'defaultValue' => null
        ),
        'wordpress-reading-bar-position' => array(
            'title' => 'Progress bar position',
            'type' => 'radio',
            'page' => 'reading',
            'callback' => 'renderInputRadio',
            'defaultValue' => 'top',
            'options' => array(
                array(
                    'value' => 'top',
                    'label' => 'Top of the page'
                ),
                array(
                    'value' => 'bottom',
                    'label' => 'Bottom of the page'
                )
            )
        ),
        'wordpress-reading-bar-enabled-post-types' => array(
            'title' => 'Post types',
            'type' => 'checkbox',
            'page' => 'reading',
            'callback' => 'renderInputCheckbox',
            'defaultValue' => null,
            'options' => null
        ),
        'wordpress-reading-bar-background' => array(
            'title' => 'Reading progress bar background',
            'type' => 'colorpicker',
            'page' => 'reading',
            'callback' => 'renderColorpicker',
            'defaultValue' => null,
            'options' => null
        ),
        'wordpress-reading-bar-foreground' => array(
            'title' => 'Reading progress bar foreground',
            'type' => 'colorpicker',
            'page' => 'reading',
            'callback' => 'renderColorpicker',
            'defaultValue' => null,
            'options' => null
        )
    );

    public static function getOptions(): array
    {
        self::$options['wordpress-reading-bar-enabled-post-types']['options'] = self::getPostTypes();
        return self::$options;
    }

    private static function getPostTypes(): array
    {
        $options = array();
        foreach (get_post_types(array('public' => true)) as $label => $value) {
            $options[] = array(
                'value' => $value,
                'label' => $label
            );
        }
        return $options;
    }
}

?>