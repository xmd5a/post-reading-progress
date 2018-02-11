<?php

namespace wrp\includes;

if (!defined('ABSPATH')) {
    exit;
}

class PluginSettings implements PluginSettingsInterface
{
    private $settingsFields = array();
    private $settingsSections = array();
    private $fieldTypes = array('text', 'checkbox');

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
                    'type' => $type
                )
            );

            return true;
        }

        throw new Exception(__('Invalid input type.', 'post-reading-progress'));
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
}

?>