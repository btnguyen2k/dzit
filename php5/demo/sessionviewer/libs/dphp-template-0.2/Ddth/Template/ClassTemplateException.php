<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Thrown to indicate that an error has occurred.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassTemplateException.php 260 2011-01-04 04:10:06Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/** */
require_once 'Ddth/Commons/Exceptions/ClassAbstractException.php';

/**
 * Thrown to indicate that an error has occurred.
 *
 * @package    	Template
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Template_TemplateException extends Ddth_Commons_Exceptions_AbstractException {

    /**
     * Constructs a new Ddth_Tempalte_TemplateException object.
     *
     * @param string exception message
     * @param int user defined exception code
     */
    public function __construct($message = NULL, $code = 0) {
        parent::__construct($message, $code);
    }
}
?>
