<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * MySQL-based implementation of {@link Quack_Bo_SessionS_ISessionDao}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Quack
 * @subpackage	Bo
 * @subpackage 	SessionS
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassMysqlSessionDao.php 211 2012-07-12 13:52:48Z btnguyen2k $
 * @since       File available since v0.1
 */

/**
 * MySQL-based implementation of {@link Quack_Bo_SessionS_ISessionDao}.
 *
 * @package     Quack
 * @subpackage	Bo
 * @subpackage	SessionS
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Quack_Bo_SessionS_MysqlSessionDao extends Quack_Bo_SessionS_BaseSessionDao implements
        Ddth_Dao_Mysql_IMysqlDao {

    protected function fetchResultAssoc($rs) {
        return mysql_fetch_array($rs, MYSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return mysql_fetch_array($rs, MYSQL_NUM);
    }
}
