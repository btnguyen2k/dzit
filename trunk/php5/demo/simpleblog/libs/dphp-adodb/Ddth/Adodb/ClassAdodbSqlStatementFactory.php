<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create {@link Ddth_Adodb_AdodbSqlStatement} objects.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Adodb
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAdodbSqlStatementFactory.php 253 2010-12-27 06:51:31Z btnguyen2k@gmail.com $
 * @since       File available since v0.1.6
 */

/**
 * Factory to create {@link Ddth_Adodb_AdodbSqlStatement} objects.
 *
 * This factory load ADOdb sql statements from a configuration file (.properties format).
 * Detailed specification of the configuration file is as the following:
 * <code>
 * # Each line is a sql statement, in .properties format
 * <name>=<number of params>,<param name 1>, <param name 2>, <param name n>, <the SQL query>
 *
 * # Examples:
 * sql.selectUserById = 1,id,SELECT * FROM tbl_user WHERE id=${id}
 * sql.deleteUserByEmail = 1,email,DELETE FROM tbl_user WHERE email=${email}
 * sql.createUser = 3,id,username,email,INSERT INTO tbl_user (id, username, email) VALUES (${id}, ${username}, ${email})
 *
 * # Note: do NOT use quotes (') or double quotes (") around the place-holders. I.e. do NOT
 * # use <i>'${email}'</i> for example, just plan <i>${email}</i>!
 * </code>
 *
 * Usage:
 * <code>
 * $configFile = 'dphp-adodb.sql.properties';
 * $factory = Ddth_Adodb_AdodbSqlStatementFactory::getInstance($configFile);
 * $adodbStm = $factory->getSqlStatement('sql.selectUserById');
 * </code>
 * See {@link Ddth_Adodb_AdodbSqlStatement} for more details on how to use {@link Ddth_Adodb_AdodbSqlStatement}.
 *
 * @package     Adodb
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1.6
 */
class Ddth_Adodb_AdodbSqlStatementFactory {

    /**
     * @var Ddth_Commons_Properties
     */
    private $configs;

    private $cache = Array();

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    private static $staticCache = Array();

    /**
     * Constructs a Ddth_Adodb_AdodbSqlStatementFactory object from a configuration file.
     *
     * See {@link Ddth_Adodb_AdodbSqlStatementFactory} for format of the configuration file.
     *
     * @param string $configFile path to the configuration file
     * @return Ddth_Adodb_AdodbSqlStatementFactory
     */
    public static function getInstance($configFile) {
        $obj = isset(self::$staticCache[$configFile]) ? self::$staticCache[$configFile] : NULL;
        if ( $obj === NULL ) {
            $fileContent = Ddth_Commons_Loader::loadFileContent($configFile);
            if ( $fileContent === NULL || $fileContent === "" ) {
                return NULL;
            }
            $props = new Ddth_Commons_Properties();
            $props->import($fileContent);
            $obj = new Ddth_Adodb_AdodbSqlStatementFactory($props);

            self::$staticCache[$configFile] = $obj;
        }
        return $obj;
    }

    /**
     * Constructs a new Ddth_Adodb_AdodbSqlStatementFactory object.
     *
     * @param Ddth_Commons_Properties
     */
    protected function __construct($props) {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        $this->setConfigs($props);
    }

    /**
     * Sets configurations.
     *
     * @param Ddth_Commons_Properties
     */
    public function setConfigs($props) {
        $this->configs = $props;
        $this->cache = Array(); //clear cache
    }

    /**
     * Gets the configuration object.
     *
     * @return Ddth_Commons_Properties
     */
    protected function getConfigs() {
        return $this->configs;
    }

    /**
     * Gets an AdodbSqlStatement.
     *
     * @param string $name identification name of the statement
     * @return Ddth_Adodb_AdodbSqlStatement the obtained statement, NULL if not found
     */
    public function getSqlStatement($name) {
        $stm = isset($this->cache[$name]) ? $this->cache[$name] : NULL;
        if ( $stm === NULL ) {
            $rawData = $this->configs->getProperty($name);
            if ( $rawData === NULl || $rawData === "" ) {
                $msg = "SQL Statement Configuration not found [$name]!";
                $this->LOGGER->warn($msg);
                return NULL;
            }
            $tokens = split("[, ]+", $rawData, 2);
            $tokens[0] += 0;
            if ( count($tokens) < 1 || $tokens[0] < 0 ) {
                $msg = "Invalid SQL Statement Configuration [$rawData]!";
                $this->LOGGER->error($msg);
                return NULL;
            }
            $sql = '';
            $params = Array();
            if ( $tokens[0] > 0 ) {
                $stmTokens = split("[, ]+", $tokens[1], $tokens[0] + 1);
                for ( $i = 0, $n = count($stmTokens) - 1; $i < $n; $i++ ) {
                    $params[] = $stmTokens[$i];
                }
                $sql = array_pop($stmTokens);
            } else {
                $sql = $tokens[1];
            }
            $stm = new Ddth_Adodb_AdodbSqlStatement();
            $stm->setParams($params);
            $stm->setSql($sql);
            $this->cache[$name] = $stm;
        }
        return $stm;
    }
}
?>