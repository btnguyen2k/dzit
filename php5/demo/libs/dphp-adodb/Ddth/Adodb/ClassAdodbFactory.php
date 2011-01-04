<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * An out-of-the-box implementation of {@link Ddth_Adodb_IAdodbFactory}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Adodb
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAdodbFactory.php 255 2010-12-27 09:55:32Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/** */
require_once 'adodb-exceptions.inc.php';
require_once 'adodb.inc.php';

/**
 * An out-of-the-box implementation of {@link Ddth_Adodb_IAdodbFactory}.
 *
 * Usage:
 * <code>
 * $adodbFactory = Ddth_Adodb_AdodbFactory::getInstance();
 * $conn = $adodbFactory->getConnection();
 * //...
 * //use the ADOdb connection, see: http://phplens.com/lens/adodb/docs-adodb.htm
 * //...
 * $adodbFactory->closeConnection($conn);
 * </code>
 * See {@link Ddth_Adodb_AdodbFactory::getInstance()} for configuration details.
 *
 * @package    	Adodb
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Adodb_AdodbFactory implements Ddth_Adodb_IAdodbFactory {

    const CONF_URL          = "adodb.url";
    const CONF_DSN          = "adodb.dsn";
    const CONF_DRIVER       = "adodb.driver";
    const CONF_DATABASE     = "adodb.database";
    const CONF_DB           = "adodb.db";
    const CONF_USER         = "adodb.user";
    const CONF_USR          = "adodb.usr";
    const CONF_USERNAME     = "adodb.username";
    const CONF_PASSWORD     = "adodb.password";
    const CONF_PWD          = "adodb.pwd";
    const CONF_HOST         = "adodb.host";
    const CONF_SETUP_SQLS   = "adodb.setupSqls";

    private static $cacheInstances = Array();

    /**
     * @var Ddth_Commons_ILog
     */
    private $LOGGER;

    /**
     * Holds an instance of Ddth_Adodb_AdodbConfig.
     *
     * @var Ddth_Adodb_AdodbConfig
     */
    private $config = NULL;

    /**
     * Static function to get instances of {@link Ddth_Adodb_AdodbFactory}.
     *
     * This function accepts an associative array as parameter. If the argument is NULL,
     * the global variable $DPHP_ADODB_CONFIG is used instead (if there is no global variable
     * $DPHP_ADODB_CONFIG, the function falls back to use the global variable $DPHP_ADODB_CONF).
     *
     * Detailed specs of the configuration array:
     * <code>
     * Array(
     *     #see http://phplens.com/lens/adodb/docs-adodb.htm for details
     *     'adodb.url'        => 'ADOdb DSN-style connection url',
     *     'adodb.dsn'        => 'alias of adodb.url',
     *     'adodb.driver'     => 'ADOdb driver',
     *     'adodb.database'   => 'name of the database to use',
     *     'adodb.db'         => 'alias of adodb.db',
     *     'adodb.user'       => 'user name to connect to the database',
     *     'adodb.usr'        => 'alias of adodb.user',
     *     'adodb.username'   => 'alias of adodb.user',
     *     'adodb.password'   => 'password to connect to the database',
     *     'adodb.pwd'        => 'alias of adodb.password',
     *     'adodb.host'       => 'the database host to connect to',
     *     'adodb.setupSqls'  => Array(
     *                               <optional,
     *                               list of sql to execute right after a connection is made>
     *                           )
     * );
     * </code>
     *
     * @param Array $config the configuration array
     * @return Ddth_Adodb_IAdodbFactory
     * @throws {@link Ddth_Adodb_AdodbException}
     */
    public static function getInstance($config=NULL) {
        if ( $config === NULL ) {
            global $DPHP_ADODB_CONFIG;
            $config = isset($DPHP_ADODB_CONFIG)?$DPHP_ADODB_CONFIG:NULL;
        }
        if ( $config === NULL ) {
            global $DPHP_ADODB_CONF;
            $config = isset($DPHP_ADODB_CONF)?$DPHP_ADODB_CONF:NULL;
        }
        if ( $config === NULL ) {
            global $DPHP_ADODB_CFG;
            $config = isset($DPHP_ADODB_CFG)?$DPHP_ADODB_CFG:NULL;
        }
        if ( $config === NULL ) {
            return NULL;
        }
        $hash = md5(serialize($config));
        if ( !isset(self::$cacheInstances[$hash]) ) {
            $instance = new Ddth_Adodb_AdodbFactory($config);
            self::$cacheInstances[$hash] = $instance;
        }
        return self::$cacheInstances[$hash];
    }

    /**
     * Constructs a new Ddth_Adodb_AdodbFactory object.
     *
     * @param Array $config see {@link Ddth_Adodb_AdodbFactory::getInstance()} for more information
     */
    protected function __construct($config) {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        $this->config = $config;
    }

    /**
     * Gets configuration array.
     *
     * @return Array see {@link Ddth_Adodb_AdodbFactory::getInstance()} for more information
     */
    protected function getConfig() {
        return $this->config;
    }

    /**
     * Gets an ADOdb connection.
     *
     * @param bool $startTransaction indicates that if a transaction is automatically
     * started when the connection is made
     * @return ADOConnection an instance of ADOConnection, NULL is returned if
     * the connection can not be created
     */
    public function getConnection($startTransaction=false) {
        $config = $this->config;
        //check the URL first
        $dsn = isset($config[self::CONF_URL])?$config[self::CONF_URL]:NULL;
        if ( $dsn === NULL || $dsn === '' ) {
            //fallback to DSN
            $dsn = isset($config[self::CONF_DSN])?$config[self::CONF_DSN]:NULL;
        }
        $conn = NULL;
        if ( $dsn !== NULL && $dsn !== '' ) {
            $conn = NewADOConnection($dsn);
        }
        if ( $conn === NULL || $conn === FALSE ) {
            //can not create ADOConnection object from URL/DSN, constuct it from other params
            $driver = isset($config[self::CONF_DRIVER])?$config[self::CONF_DRIVER]:NULL;
            $host = isset($config[self::CONF_HOST])?$config[self::CONF_HOST]:NULL;
            $user = isset($config[self::CONF_USER])?$config[self::CONF_USER]:NULL;
            if ( $user === NULL ) {
                $user = isset($config[self::CONF_USR])?$config[self::CONF_USR]:NULL;
            }
            if ( $user === NULL ) {
                $user = isset($config[self::CONF_USERNAME])?$config[self::CONF_USERNAME]:NULL;
            }
            $password = isset($config[self::CONF_PASSWORD])?$config[self::CONF_PASSWORD]:NULL;
            if ( $password === NULL ) {
                $password = isset($config[self::CONF_PWD])?$config[self::CONF_PWD]:NULL;
            }
            $database = isset($config[self::CONF_DATABASE])?$config[self::CONF_DATABASE]:NULL;
            if ( $database === NULL ) {
                $database = isset($config[self::CONF_DB])?$config[self::CONF_DB]:NULL;
            }
            $conn = NewADOConnection($driver);
            if ( $conn !== NULL && $conn !== FALSE ) {
                $conn->connect($host, $user, $password, $database);
            }
        }

        if ( $conn === NULL || $conn === FALSE ) {
            return NULL;
        }

        $setupSqls = isset($config[self::CONF_SETUP_SQLS])?$config[self::CONF_SETUP_SQLS]:NULL;
        if ( $setupSqls === NULL || !is_array($setupSqls) ) {
            $setupSqls = Array();
        }
        foreach ( $setupSqls as $sql ) {
            //run setup sqls
            $conn->Execute($sql);
        }

        if ( $startTransaction ) {
            $conn->StartTrans();
        }
        return $conn;
    }

    /**
     * Closes an ADOConnection
     *
     * @param ADOConnection $conn
     * @param bool $hasError
     */
    public function closeConnection($conn, $hasError=false) {
        if ( $conn !== NULL ) {
            $exception = NULL;
            try {
                if ( $conn->hasTransactions ) {
                    if ( $hasError ) {
                        $conn->FailTrans();
                    }
                    $conn->CompleteTrans();
                }
            } catch ( Exception $e ) {
                $exception = $e;
            }
            $conn->close();
            if ( $exception !== NULL ) {
                throw $exception;
            }
        }
    }
}
?>
