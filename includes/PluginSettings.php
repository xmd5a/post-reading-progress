<?php

namespace wrp\includes;

class PluginSettings
{
    private $textDomain;
    private $settingsFields = array();
    private $settingsSections = array();
    private $fieldTypes = array('text', 'checkbox', 'radio', 'colorpicker', 'slider');

    public function __construct(string $textDomain)
    {
        $this->textDomain = $textDomain;
    }

    public function addSection(
        string $id,
        string $title,
        callable $callback,
        string $page
    ): bool {
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
        string $section,
        $options = array()
    ): bool {
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
    }

    public function init()
    {
        add_action('admin_init', function () {
            foreach ($this->settingsSections as $section) {
                add_settings_section(
                    $section['id'],
                    __($section['title'], $this->textDomain),
                    $section['callback'],
                    $section['page']
                );
            }

            foreach ($this->settingsFields as $field) {
                add_settings_field(
                    $field['id'],
                    __($field['title'], $this->textDomain),
                    $field['callback'],
                    $field['page'],
                    $field['section'],
                    $field['args']
                );

                register_setting(
                    $field['page'],
                    $field['id']
                );
            }
        });
    }

    public function renderInputText(array $args): bool
    {
        vprintf("<input type=\"%s\" id=\"%s\" name=\"%s\" value=\"%s\" />", array(
            $args['type'],
            $args['name'],
            $args['name'],
            get_option($args['name'], false)
        ));

        return true;
    }

    public function renderInputCheckbox(array $args): bool
    {
        $options = get_option($args['name'], false) != '' ? get_option($args['name'], false) : array();

        if (is_array($args['options']) && count($args['options']) > 1) {
            $return = null;

            foreach ($args['options'] as $option) {
                $return .= vsprintf(
                    "<label><input type=\"checkbox\" name=\"%s[]\" value=\"%s\" %s />%s</label><br>",
                    array(
                        $args['name'],
                        $option['value'],
                        checked(!in_array($option['value'], $options), null, false),
                        $option['label']
                    )
                );
            }

            echo "<fieldset><p>" . $return . "</p></fieldset>";

            return true;
        } else {
            vprintf("<input type=\"checkbox\" id=\"%s\" name=\"%s\" value=\"1\" %s />", array(
                $args['name'],
                $args['name'],
                checked(get_option($args['name'], false), 1, false)
            ));

            return true;
        }
    }

    public function renderInputRadio(array $args): bool
    {
        if (is_array($args['options']) && count($args['options']) > 1) {
            $return = null;

            foreach ($args['options'] as $option) {
                $return .= vsprintf("<label><input type=\"radio\" name=\"%s\" value=\"%s\" %s />%s</label><br>", array(
                    $args['name'],
                    $option['value'],
                    checked(get_option($args['name'], false), $option['value'], false),
                    __($option['label'], $this->textDomain)
                ));
            }

            echo "<fieldset><p>$return</p></fieldset>";
            return true;
        }
    }

    public function renderColorpicker(array $args): bool
    {
        vprintf("<input type=\"text\" class=\"color-picker\" name=\"%s\" value=\"%s\"/>", array(
            $args['name'],
            get_option($args['name'], false)
        ));

        return true;
    }

    public function renderSlider(array $args): bool
    {
        vprintf(
            "<div class=\"slide\"><div class=\"ui-slider-handle\"><span class=\"slide__handle\">80px</span></div></div>
			<input type=\"hidden\" name=\"%s\" value=\"%s\" />",
            array(
                $args['name'],
                get_option($args['name'], false)
            )
        );

        return true;
    }
}
