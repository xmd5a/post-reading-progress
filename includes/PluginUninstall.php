<?php

namespace wrp\includes;

class ReadingProgressUninstall
{
    public function __construct()
    {
        $pluginOptions = PluginOptions::getInstance();

        foreach ($pluginOptions->getAllOptions() as $optionID => $option) {
            delete_option($optionID);
        }
    }
}
