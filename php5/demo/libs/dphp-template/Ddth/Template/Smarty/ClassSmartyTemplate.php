<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Smarty template pack.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @subpackage  Smarty
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassSmartyTemplate.php 227 2010-12-05 06:57:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

require_once('Smarty.class.php');

/**
 * Smarty template pack.
 *
 * @package    	Template
 * @subpackage  Smarty
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version    	0.1
 * @since      	Class available since v0.1
 */
class Ddth_Template_Smarty_SmartyTemplate extends Ddth_Template_AbstractTemplate {
    
    const PROPERTY_SMARTY_COMPILE_DIR = 'smarty.compile';

    const PROPERTY_SMARTY_CACHE_DIR = 'smarty.cache';
    
    const PROPERTY_SMARTY_CONFIGS_DIR = 'smarty.configs';
    
    /**
     * Constructs a new Ddth_Template_Smarty_SmartyTemplate object.
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
            //return new Ddth_Template_Smarty_SmartyPage($id, $f->getPathname(), $this);
            return new Ddth_Template_Smarty_SmartyPage($id, $templateFile, $this);
        } else {
            return NULL;
        }
    }
}
?>
