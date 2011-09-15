<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Interface that provides APIs for custom session handler.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Quack
 * @subpackage	Bo
 * @subpackage 	SessionS
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassICache.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Interface that provides APIs for custom session handler.
 *
 * @package     Quack
 * @subpackage	Bo
 * @subpackage	SessionS
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Quack_Bo_SessionS_ISessionDao extends Ddth_Dao_IDao {

    /**
     * Deletes expired sessions.
     * @param int $maxlifetime
     */
    public function deleteExpiredSessions($maxlifetime);

    /**
     * Deletes a session by id.
     * @param string $id
     */
    public function deleteSession($id);

    /**
     * Gets a session data by id.
     * @param string $id
     * @param string session data, or NULL if not exists
     */
    public function readSession($id);

    /**
     * Writes session data.
     * @param string $id
     * @param string $data
     */
    public function writeSession($id, $data);
}