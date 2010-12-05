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
 * @version     $Id: ClassSmartyPage.php 227 2010-12-05 06:57:50Z btnguyen2k@gmail.com $
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
     * Constructs a new Ddth_Template_Smarty_SmartyPage object.
     *
     * @param string
     * @param string
     * @param Ddth_Template_ITempalte
     */
    public function __construct($id, $templateFile, $template) {
        parent::__construct($id, $templateFile, $template);
    }

    /**
     * {@see Ddth_Template_IPage::render()}
     */
    public function render($model=NULL) {
        if ( $model !== NULL ) {
            $this->setDataModel($model);
        }
        $key = Ddth_Template_Smarty_SmartyTemplate::PROPERTY_BASE_DIRECTORY;
        $baseDir = new Ddth_Commons_File($this->getTemplateProperty($key));
        $key = Ddth_Template_Smarty_SmartyTemplate::PROPERTY_LOCATION;
        $location = new Ddth_Commons_File($this->getTemplateProperty($key), $baseDir);

        $smarty = new Smarty();

        //Smarty's template directory
        $smarty->template_dir = $location->getPathname();

        //Smarty's cache directory
        $key = Ddth_Template_Smarty_SmartyTemplate::PROPERTY_SMARTY_CACHE_DIR;
        $cacheDir = new Ddth_Commons_File($this->getTemplateProperty($key), $location);
        $smarty->cache_dir = $cacheDir->getPathname();

        //Smarty's compile directory
        $key = Ddth_Template_Smarty_SmartyTemplate::PROPERTY_SMARTY_COMPILE_DIR;
        $compileDir = new Ddth_Commons_File($this->getTemplateProperty($key), $location);
        $smarty->compile_dir = $compileDir->getPathname();

        //Smarty's configuration directory
        $key = Ddth_Template_Smarty_SmartyTemplate::PROPERTY_SMARTY_CONFIGS_DIR;
        $configDir = new Ddth_Commons_File($this->getTemplateProperty($key), $location);    
        $smarty->config_dir = $configDir->getPathname();

        $model = $this->getDataModel();
        //$smarty->assign($model->asPhpType());
        $smarty->assign($model);

        $smarty->display($this->getTemplateFile());
    }
}
?>