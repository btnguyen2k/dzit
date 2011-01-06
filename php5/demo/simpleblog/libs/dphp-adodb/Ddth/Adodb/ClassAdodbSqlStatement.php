<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * ADOdb SQL query wrapper.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Adodb
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAdodbSqlStatement.php 253 2010-12-27 06:51:31Z btnguyen2k@gmail.com $
 * @since       File available since v0.1.6
 */

/**
 * ADOdb SQL query wrapper.
 *
 * This class encapsulates an ADOdb statement, which consists of:
 * <ul>
 *     <li>The SQL query (e.g. <i>SELECT * FROM tbl_user WHERE id=${id}</i>)</li>
 *     <li>Parameter list as an index array (e.g. <i>['id']</i>)</li>
 * </ul>
 * Note: do NOT use quotes (') or double quotes (") around the place-holders. I.e. do NOT
 * use <i>'${email}'</i> for example, just plan <i>${email}</i>!
 *
 * Usage:
 * <code>
 * //construct a Ddth_Adodb_AdodbSqlStatement object
 * $sql = 'SELECT * FROM tbl_user WHERE id=${id}';
 * $paramNames = Array('id');
 * $ddthAdodbStm = new Ddth_Adodb_AdodbSqlStatement($sql, $paramNames);
 *
 * //obtain an ADOConnection
 * $adoConn = ...;
 *
 * //prepare and execute the query
 * $values = Array('root');
 * $adodbStm = $adoConn->Prepare($ddthAdodbStm->prepare($adoConn));
 * $resultSet = $adoConn->Execute($adodbStm, $values);
 *
 * //another way to prepare and execute the query
 * $values = Array('root');
 * $resultSet = $ddthAdodbStm->prepareAndExecute($adoConn, $value);
 * </code>
 *
 * Another example using {@link Ddth_Adodb_AdodbSqlStatementFactory}:
 * <code>
 * $configFile = 'dphp-adodb.sql.properties';
 * $adodbStmFactory = Ddth_Adodb_AdodbSqlStatementFactory::getInstance($configFile);
 *
 * $ddthAdodbStm = $adodbStmFactory->getSqlStatement('selectUserById');
 * $values = Array('root');
 * $resultSet = $ddthAdodbStm->prepareAndExecute($adoConn, $value);
 * </code>
 *
 * @package    	Adodb
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1.6
 */
class Ddth_Adodb_AdodbSqlStatement {

    private $sql = '';

    private $params = Array();

    /**
     * Constructs a new Ddth_Adodb_AdodbSqlStatement object.
     *
     * @param string $sql
     * @param Array $params
     */
    public function __construct($sql='', $params=Array()) {
        $this->setSql($sql);
        $this->setParams($params);
    }

    /**
     * Gets the sql command.
     * @return string
     */
    public function getSql() {
        return $this->sql;
    }

    /**
     * Sets the sql command.
     * @param string
     */
    public function setSql($sql) {
        $this->sql = $sql;
    }

    /**
     * Gets binding parameter list.
     * @return Array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * Sets binding parameter list.
     * @param Array
     */
    public function setParams($params) {
        $this->params = is_array($params) ? $params : Array();
    }

    /**
     * Prepares the statement.
     *
     * @param ADOConnection $conn an active ADOdb connection
     * @return string the prepared SQL statement
     */
    public function prepare($conn) {
        return Ddth_Adodb_AdodbHelper::prepareSql($conn, $this->getSql(), $this->getParams());
    }

    /**
     * Prepares and execute the statement.
     *
     * @param ADOConnection $conn an active ADOdb connection
     * @param Array $values parameters to be bind to the query (an index array)
     * @return mixed the returned value from ADOConnection::Execute()
     * @since function available since v0.1.7
     */
    public function prepareAndExecute($conn, $values=Array()) {
        $adodbStm = $conn->Prepare($this->prepare($conn));
        return $conn->Execute($adodbStm, $values);
    }
}
?>
