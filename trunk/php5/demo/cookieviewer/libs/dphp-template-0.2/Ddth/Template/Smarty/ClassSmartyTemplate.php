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
 * @version     $Id: ClassSmartyTemplate.php 261 2011-01-04 04:27:36Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

require_once ('Smarty.class.php');

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

    const DEFAULT_PAGE_CLASS = 'Ddth_Template_Smarty_SmartyPage';

    const CONF_SMARTY_CACHE_DIR = 'smarty.cache';
    const CONF_SMARTY_COMPILE_DIR = 'smarty.compile';
    const CONF_SMARTY_CONFIGS_DIR = 'smarty.configs';

    /**
     * If no page class defined, this function returns {@link DEFAULT_PAGE_CLASS}.
     *
     * @see Ddth_Template_AbstractTemplate::getPageClass()
     */
    protected function getPageClass() {
        $result = parent::getPageClass();
        return $result !== NULL ? $result : self::DEFAULT_PAGE_CLASS;
    }
}
?>
