<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Smarty template page.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @subpackage  Smarty
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassSmartyPage.php 261 2011-01-04 04:27:36Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Smarty template page.
 *
 * @package    	Template
 * @subpackage  Smarty
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Template_Smarty_SmartyPage extends Ddth_Template_AbstractPage {
    /**
     * {@see Ddth_Template_IPage::render()}
     */
    public function render($model = NULL) {
        if ($model !== NULL) {
            $this->setModel($model);
        }
        $key = Ddth_Template_BaseTemplateFactory::CONF_BASE_DIRECTORY;
        $templateDir = new Ddth_Commons_File($this->getTemplateConfigSetting($key));
        $templateDir = new Ddth_Commons_File($this->getTemplate()->getDir(), $templateDir);

        $smarty = new Smarty();

        //Smarty's template directory
        $smarty->template_dir = $templateDir->getPathname();
        var_dump($smarty->template_dir);

        //Smarty's cache directory
        $key = Ddth_Template_Smarty_SmartyTemplate::CONF_SMARTY_CACHE_DIR;
        $cacheDir = new Ddth_Commons_File($this->getTemplateConfigSetting($key), $templateDir);
        $smarty->cache_dir = $cacheDir->getPathname();
        var_dump($smarty->cache_dir);

        //Smarty's compile directory
        $key = Ddth_Template_Smarty_SmartyTemplate::CONF_SMARTY_COMPILE_DIR;
        $compileDir = new Ddth_Commons_File($this->getTemplateConfigSetting($key), $templateDir);
        $smarty->compile_dir = $compileDir->getPathname();
        var_dump($smarty->compile_dir);

        //Smarty's configuration directory
        $key = Ddth_Template_Smarty_SmartyTemplate::CONF_SMARTY_CONFIGS_DIR;
        $configDir = new Ddth_Commons_File($this->getTemplateConfigSetting($key), $templateDir);
        $smarty->config_dir = $configDir->getPathname();
        var_dump($smarty->config_dir);

        $model = $this->getModel();
        $smarty->assign($model);
        $smarty->display($this->getTemplateFile());
    }
}
?>