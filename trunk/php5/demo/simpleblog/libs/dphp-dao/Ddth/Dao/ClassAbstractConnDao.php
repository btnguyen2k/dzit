<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Abstract connection implementation of {@link Ddth_Dao_IDao}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.2.1
 */

/**
 * Abstract connection implementation of {@link Ddth_Dao_IDao}.
 *
 * This abstract implementation of {@link Ddth_Dao_IDao} delegates calls to {@link getConnection()}
 * and {@link closeConnection()} to its factory.
 * This class is meant to be used together with {@link Ddth_Dao_AbstractConnDaoFactory}.
 *
 * @package    	Dao
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2.1
 */
abstract class Ddth_Dao_AbstractConnDao extends Ddth_Dao_AbstractDao {
    /**
     * @see Ddth_Dao_IDao::getConnection()
     */
    public function getConnection($startTransaction=FALSE) {
        return $this->getDaoFactory()->getConnection($startTransaction);
    }

    /**
     * @see Ddth_Dao_IDao::closeConnection()
     */
    public function closeConnection($hasError=FALSE, $forceClose=FALSE) {
        $this->getDaoFactory()->closeConnection($hasError, $forceClose);
    }
}
?>
