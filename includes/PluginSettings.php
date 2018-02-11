<?php

namespace wrp\includes;

if (!defined('ABSPATH')) {
    exit;
}

class PluginSettings implements BaseSettingsInterface, PluginSettingsInterface
{
    private $settingsFields = array();
    private $settingsSections = array();
    private $fieldTypes = array('text', 'checkbox', 'radio');

    public function addSection(
        string $id,
        string $title,
        callable $callback,
        string $page
    ): bool
    {
        $this->settingsSections[] = array(
            'id' => $id,
            'title' => $title,
            'callback' => $callback,
            'page' => $page
        );

        return true;
    }

    public function addSettingsField(
        string $id,
        string $title,
        string $type,
        string $page,
        callable $callback,
        $options = array(),
        string $section
    ): bool
    {
        //check input type
        if (in_array($type, $this->fieldTypes)) {
            $this->settingsFields[] = array(
                'id' => $id,
                'title' => $title,
                'type' => $type,
                'callback' => $callback,
                'page' => $page,
                'section' => $section,
                'args' => array(
                    'label_for' => $id,
                    'name' => $id,
                    'type' => $type,
                    'options' => $options
                )
            );

            return true;
        }

        throw new \Exception(__('Invalid input type.', self::PLUGIN_SLUG));
    }

    public function init()
    {
        add_action('admin_init', function () {
            foreach ($this->settingsSections as $section) {
                add_settings_section(
                    $section['id'],
                    $section['title'],
                    $section['callback'],
                    $section['page']
                );
            }

            foreach ($this->settingsFields as $field) {
                register_setting(
                    $field['page'],
                    $field['id']
                );

                add_settings_field(
                    $field['id'],
                    $field['title'],
                    $field['callback'],
                    $field['page'],
                    $field['section'],
                    $field['args']
                );
            }
        });
    }

    public function renderInputText(array $args) : string
    {
        return vprintf("<input type=\"%s\" id=\"%s\" name=\"%s\" value=\"%s\" />", array(
            $args['type'],
            $args[name],
            $args[name],
            get_option($args['name'], false)
        ));
    }

    public function renderInputCheckbox(array $args) : string
    {
        return vprintf("<input type=\"checkbox\" id=\"%s\" name=\"%s\" value=\"1\" %s />", array(
            $args['name'],
            $args['name'],
            checked(get_option($args['name'], false), 1, false)
        ));
    }

    public function renderInputRadio(array $args) : string
    {
        if(is_array($args['options']) && count($args['options']) > 1){
            $return = null;

            foreach ($args['options'] as $option) {
                $return .= vprintf("<label><input type=\"radio\" name=\"%s\" value=\"%s\" %s />%s</label><br>", array(
                    $args['name'],
                    $option['value'],
                    checked(get_option($args['name'], false), $option['value'], false),
                    $option['label']
                ));
            }

            return $return;
        }

        throw new \Exception(__('Not enough options', self::PLUGIN_SLUG));
    }
}

?>