<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Php template page.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @subpackage  Php
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassPhpPage.php 260 2011-01-04 04:10:06Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Php template page.
 *
 * @package    	Template
 * @subpackage  Php
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Template_Php_PhpPage extends Ddth_Template_AbstractPage {
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
        $templateFile = new Ddth_Commons_File($this->getTemplateFile(), $templateDir);
        global $MODEL;
        $MODEL = $this->getModel();
        include $templateFile->getPathname();
    }
}
?>
