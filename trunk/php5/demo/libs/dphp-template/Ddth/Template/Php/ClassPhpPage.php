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
 * @version     $Id: ClassPhpPage.php 227 2010-12-05 06:57:50Z btnguyen2k@gmail.com $
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
     * Constructs a new Ddth_Template_Php_PhpPage object.
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
        $key = Ddth_Template_Php_PhpTemplate::PROPERTY_BASE_DIRECTORY;
        $baseDir = new Ddth_Commons_File($this->getTemplateProperty($key));
        $key = Ddth_Template_Php_PhpTemplate::PROPERTY_LOCATION;
        $location = new Ddth_Commons_File($this->getTemplateProperty($key), $baseDir);
        $templateFile = new Ddth_Commons_File($this->getTemplateFile(), $location);

        global $MODEL;
        $MODEL = $this->getDataModel();
        //$DATAMODEL = $DATAMODEL->asPhpType();
        include $templateFile->getPathname();
    }
}
?>
