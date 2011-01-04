<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create {@link Ddth_Dao_Mysql_IMysqlDao} instances.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @subpackage  Mysql
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassBaseMysqlDaoFactory.php 259 2010-12-28 10:43:52Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

/**
 * Factory to create {@link Ddth_Dao_Mysql_IMysqlDao} instances. This can be used as a base
 * implementation of MySql-based DAO factory.
 *
 * This factory uses the same configuration array as {@link Ddth_Dao_BaseDaoFactory}, with additional
 * configurations:
 * <code>
 * Array(
 *     #other configurations used by Ddth_Dao_BaseDaoFactory
 *
 *     # MySQL hostname, username, and password
 *     # See http://php.net/manual/en/function.mysql-connect.php for more information
 *     'ddth-dao.mysql.host'       => 'localhost',
 *     'ddth-dao.mysql.username'   => 'root', #supply FALSE or NULL to disable username field
 *     'ddth-dao.mysql.password'   => '',     #supply FALSE or NULL to disable password field
 *     'ddth-dao.mysql.persistent' => FALSE   #indicate if mysql_pconnect (TRUE) or mysql_connect (FALSE) is used. Default value is FALSE
 * )
 * </code>
 *
 * @package     Dao
 * @subpackage  Mysql
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Ddth_Dao_Mysql_BaseMysqlDaoFactory extends Ddth_Dao_AbstractConnDaoFactory {

    const CONF_MYSQL_HOST       = 'ddth-dao.mysql.host';
    const CONF_MYSQL_USERNAME   = 'ddth-dao.mysql.username';
    const CONF_MYSQL_PASSWORD   = 'ddth-dao.mysql.password';
    const CONF_MYSQL_PERSISTENT = 'ddth-dao.mysql.persistent';

    private $mysqlHost       = 'localhost:3306';
    private $mysqlUsername   = NULL;
    private $mysqlPassword   = NULL;
    private $mysqlPersistent = FALSE;

    /**
     * Constructs a new Ddth_Dao_Mysql_BaseMysqlDaoFactory object.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @see Ddth_Dao_IDaoFactory::init();
     */
    public function init($config) {
        parent::init($config);
        $this->mysqlHost = isset($config[self::CONF_MYSQL_HOST])?$config[self::CONF_MYSQL_HOST]:NULL;
        $this->mysqlUsername = isset($config[self::CONF_MYSQL_USERNAME])?$config[self::CONF_MYSQL_USERNAME]:NULL;
        $this->mysqlPassword = isset($config[self::CONF_MYSQL_PASSWORD])?$config[self::CONF_MYSQL_PASSWORD]:NULL;
        $this->mysqlPersistent = isset($config[self::CONF_MYSQL_PERSISTENT])?$config[self::CONF_MYSQL_PERSISTENT]:FALSE;
    }

    /**
     * Gets the MySQL host.
     *
     * @return string
     */
    protected function getMysqlHost() {
        return $this->mysqlHost;
    }

    /**
     * Sets the MySQL host.
     * @param string $host
     */
    protected function setMysqlHost($host) {
        $this->mysqlHost = $host;
    }

    /**
     * Gets the MySQL username.
     *
     * @return string
     */
    protected function getMysqlUsername() {
        return $this->mysqlUsername;
    }

    /**
     * Sets the MySQL username.
     * @param string $username
     */
    protected function setMysqlUsername($username) {
        $this->mysqlUsername = $username;
    }

    /**
     * Gets the MySQL password.
     *
     * @return string
     */
    protected function getMysqlPassword() {
        return $this->mysqlPassword;
    }

    /**
     * Sets the MySQL password.
     * @param string $password
     */
    protected function setMysqlPassword($password) {
        $this->mysqlPassword = $password;
    }

    /**
     * Gets the MySQL persistent setting.
     *
     * @return bool
     */
    protected function getMysqlPersistent() {
        return $this->mysqlPersistent;
    }

    /**
     * Sets the MySQL persistent setting.
     * @param bool $persistent
     */
    protected function setMysqlPersistent($persistent) {
        $this->mysqlPersistent = $persistent;
    }

    /**
     * Gets a DAO by name.
     *
     * @param string $name
     * @return Ddth_Dao_Mysql_AbstractMysqlDao
     * @throws Ddth_Dao_DaoException
     */
    public function getDao($name) {
        $dao = parent::getDao($name);
        if ( $dao !== NULL && !($dao instanceof Ddth_Dao_Mysql_IMysqlDao ) ) {
            $msg = 'DAO ['.$name.'] is not of type [Ddth_Dao_Mysql_IMysqlDao]!';
            throw new Ddth_Dao_DaoException($msg);
        }
        return $dao;
    }

    /**
     * This function returns an object of type {@link Ddth_Dao_Mysql_MysqlConnection}.
     *
     * @see Ddth_Dao_AbstractConnDaoFactory::createConnection()
     */
    protected function createConnection($startTransaction=FALSE) {
        if ( $this->mysqlPersistent ) {
            if ( $this->mysqlUsername !== false ) {
                if ( $this->mysqlPassword !== false ) {
                    $mysqlConn = mysql_pconnect($this->mysqlHost, $this->mysqlUsername, $this->mysqlPassword);
                } else {
                    $mysqlConn = mysql_pconnect($this->mysqlHost, $this->mysqlUsername);
                }
            } else {
                $mysqlConn = mysql_pconnect($this->mysqlHost);
            }
        } else {
            if ( $this->mysqlUsername !== false ) {
                if ( $this->mysqlPassword !== false ) {
                    $mysqlConn = mysql_connect($this->mysqlHost, $this->mysqlUsername, $this->mysqlPassword);
                } else {
                    $mysqlConn = mysql_connect($this->mysqlHost, $this->mysqlUsername);
                }
            } else {
                $mysqlConn = mysql_connect($this->mysqlHost);
            }
        }
        $result = new Ddth_Dao_Mysql_MysqlConnection($mysqlConn);
        if ( $startTransaction ) {
            $result->startTransaction();
        }
        return $result;
    }

    /**
     * This function expects the first argument is of type {@link Ddth_Dao_Mysql_MysqlConnection}.
     *
     * @see Ddth_Dao_AbstractConnDaoFactory::forceCloseConnection()
     */
    protected function forceCloseConnection($conn, $hasError=FALSE) {
        if ( $conn instanceof Ddth_Dao_Mysql_MysqlConnection ) {
            $conn->closeConn($hasError);
        } else {
            $msg = 'I expect the first parameter is of type [Ddth_Dao_Mysql_MysqlConnection]!';
            throw new Ddth_Dao_DaoException($msg);
        }
    }
}
?>
