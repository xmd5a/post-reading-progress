<?php

namespace wrp\includes;

final class PluginOptions
{
    private static $instance;
    private $options = array();

    private function __construct()
    {
        $this->setInitOptions();
    }

    private function setInitOptions()
    {
        $this->setOption('wordpress-reading-bar-enable-plugin', array(
            'title' => 'Enable plugin',
            'type' => 'checkbox',
            'page' => 'reading',
            'callback' => 'renderInputCheckbox',
            'defaultValue' => '1'
        ));

        $this->setOption('wordpress-reading-bar-position', array(
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
                ),
                array(
                    'value' => 'left',
                    'label' => 'Left side of the page'
                ),
                array(
                    'value' => 'right',
                    'label' => 'Right side of the page'
                )
            )
        ));

        $this->setOption('wordpress-reading-bar-autohide', array(
            'title' => 'Hide progress bar after reading complete',
            'type' => 'slider',
            'page' => 'reading',
            'callback' => 'renderInputCheckbox',
        ));

        $this->setOption('wordpress-reading-bar-autohide-effect', array(
            'title' => 'Progress bar position',
            'type' => 'radio',
            'page' => 'reading',
            'callback' => 'renderInputRadio',
            'defaultValue' => 'slide',
            'options' => array(
                array(
                    'value' => 'slide',
                    'label' => 'Slide'
                ),
                array(
                    'value' => 'fadeOut',
                    'label' => 'Fade out'
                )
            )
        ));

        $this->setOption('wordpress-reading-bar-height', array(
            'title' => 'Progress bar height',
            'type' => 'slider',
            'page' => 'reading',
            'callback' => 'renderSlider',
            'defaultValue' => '6px',
        ));

        $this->setOption('wordpress-reading-bar-enabled-post-types', array(
            'title' => 'Post types',
            'type' => 'checkbox',
            'page' => 'reading',
            'callback' => 'renderInputCheckbox',
            'defaultValue' => array('post'),
            'options' => $this->getPostTypes()
        ));

        $this->setOption('wordpress-reading-bar-background', array(
            'title' => 'Reading progress bar background',
            'type' => 'colorpicker',
            'page' => 'reading',
            'callback' => 'renderColorpicker',
            'defaultValue' => '#3C8E88',
        ));

        $this->setOption('wordpress-reading-bar-foreground', array(
            'title' => 'Reading progress bar foreground',
            'type' => 'colorpicker',
            'page' => 'reading',
            'callback' => 'renderColorpicker',
            'defaultValue' => '#FFFFFF',
        ));
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

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new PluginOptions();
        }

        return self::$instance;
    }

    public function setOption(string $key, array $options)
    {
        $this->options[$key] = $options;
    }

    public function getOption(string $key)
    {
        if ($this->options[$key]) {
            return get_option($key, false);
        }
    }

    public function getAllOptions()
    {
        return $this->options;
    }
}
