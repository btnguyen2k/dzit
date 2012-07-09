<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * PgSQL-based implementation of {@link Quack_Bo_SessionS_ISessionDao}.
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
 * PgSQL-based implementation of {@link Quack_Bo_SessionS_ISessionDao}.
 *
 * @package     Quack
 * @subpackage	Bo
 * @subpackage	SessionS
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Quack_Bo_SessionS_PgsqlSessionDao extends Quack_Bo_SessionS_BaseSessionDao implements
        Ddth_Dao_Pgsql_IPgsqlDao {

    protected function fetchResultAssoc($rs) {
        return pg_fetch_array($rs, NULL, PGSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return pg_fetch_array($rs, NULL, PGSQL_NUM);
    }
}
