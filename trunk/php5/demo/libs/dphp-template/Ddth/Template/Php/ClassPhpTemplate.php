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

    const DEFAULT_PAGE_CLASS = 'Ddth_Template_Php_PhpPage';

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
