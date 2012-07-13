<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Use this DAO to pre-open a DB connection at the beginning of application's
 * execution for latter use and close it at the end of application's execution.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package Quack
 * @subpackage Bo
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version $Id: ClassBaseDao.php 213 2012-07-12 17:34:09Z btnguyen2k $
 * @since File available since v0.1
 */

/**
 * Use this DAO to pre-open a DB connection at the beginning of application's
 * execution for latter use and close it at the end of application's execution.
 *
 * @package Quack
 * @subpackage Bo
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Quack_Bo_ConnectionHolderDao extends Ddth_Dao_AbstractSqlStatementDao implements
        Ddth_Dao_Mysql_IMysqlDao, Ddth_Dao_Pgsql_IPgsqlDao, Ddth_Dao_Sqlite_ISqliteDao {
}
