<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Thrown to indicate that an error has occurred.
 *
 * LICENSE: See the included license.txt file for detail.
 * 
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Adodb
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAdodbException.php 248 2010-12-23 19:22:32Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Thrown to indicate that an error has occurred.
 *
 * @package    	Adodb
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Adodb_AdodbException extends Ddth_Commons_Exceptions_AbstractException {
    /**
     * Constructs a new Ddth_Adodb_AdodbException object.
     *
     * @param string exception message
     * @param int user defined exception code
     */
    public function __construct($message = NULL, $code = 0) {
        parent::__construct($message, $code);
    }
}
?>
