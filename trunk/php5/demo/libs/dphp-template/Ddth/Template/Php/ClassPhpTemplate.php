<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * PHP template pack.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @subpackage  Php
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassPhpTemplate.php 227 2010-12-05 06:57:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * PHP template pack.
 *
 * @package    	Template
 * @subpackage  Php
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Template_Php_PhpTemplate extends Ddth_Template_AbstractTemplate {
    /**
     * Constructs a new Ddth_Template_Php_PhpTemplate object.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * {@see Ddth_Template_ITemplate::init()}
     */
    public function getPage($id) {
        $templateFile = $this->getPageTemplateFile($id);
        if ( $templateFile !== NULL ) {
            //$f = new Ddth_Commons_File($templateFile, $this->getLocation());
            //return new Ddth_Template_Php_PhpPage($id, $f->getPathname(), $this);
            return new Ddth_Template_Php_PhpPage($id, $templateFile, $this);
        } else {
            return NULL;
        }
    }
}
?>
