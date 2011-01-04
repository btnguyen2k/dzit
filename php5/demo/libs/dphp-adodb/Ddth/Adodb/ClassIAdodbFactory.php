<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create and dispose ADOdb connections.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Adodb
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassIAdodbFactory.php 248 2010-12-23 19:22:32Z btnguyen2k@gmail.com $
 * @since      	File available since v0.1
 */

/**
 * Factory to create and dispose ADOdb connections.
 *
 * This interface provides APIs to create and dispose
 * {@link http://adodb.sourceforge.net/ ADOdb} connections.
 *
 * @package    	Adodb
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Ddth_Adodb_IAdodbFactory {
    /**
     * Gets an ADOdb connection.
     *
     * @param bool indicates that if a transaction is automatically started
     * @return ADOConnection an instance of ADOConnection, NULL is returned if
     * the connection can not be created
     */
    public function getConnection($startTransaction=false);

    /**
     * Closes an ADOConnection
     *
     * @param ADOConnection
     * @param bool
     */
    public function closeConnection($conn, $hasError=false);
}
?>
