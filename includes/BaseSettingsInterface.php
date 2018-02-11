<?php

namespace wrp\includes;

if (!defined('ABSPATH')) {
    exit;
}

interface BaseSettingsInterface
{
    const PLUGIN_VERSION = '1.0.0';
    const PLUGIN_NAME = 'Post Reading Progress';
    const PLUGIN_SLUG = 'post-reading-progress';
    const PLUGIN_OPTIONS = array(
        'section-slug' => self::PLUGIN_SLUG . '-settings',
        'options' => array(
            array(
                'id' => 'enable-plugin',
                'title' => 'Enable plugin',
                'type' => 'checkbox',
                'page' => 'reading',
                'callback' => 'renderInputCheckbox',
                'defaultValue' => null
            ),
            array(
                'id' => 'enable-cpt',
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
            )
        )
    );
}

?>