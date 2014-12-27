<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

//Запрещаем напрямую обращение к этому файлу
if (!class_exists('Plugin')) {
    die('');
}

class PluginXmas extends Plugin {

    // Активация плагина
    public function Activate() {

        return true;
    }

    // Деактивация плагина
    public function Deactivate() {

        return true;
    }

    public function Init() {

        $aParams = array(
            'dir_from' => Plugin::GetTemplateDir(__CLASS__) . 'assets/',
        );
        $this->Viewer_AppendStyle(Plugin::GetTemplateDir(__CLASS__) . 'assets/css/xmas.css', $aParams);
        $this->Viewer_AppendScript(Plugin::GetTemplateDir(__CLASS__) . 'assets/js/snowfall.jquery.js', $aParams);

        $aParams = array(
            'dir_from' => Plugin::GetTemplateDir(__CLASS__) . 'assets/',
            'prepare' => true,
            'compress' => false,
            'merge' => false,
            'name' => 'xmas.js',
        );
        $this->Viewer_AppendScript(Plugin::GetTemplateDir(__CLASS__) . 'assets/js/xmas.js', $aParams);
    }

}

// EOF