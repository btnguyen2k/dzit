<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * "Getting started" for Ddth_Adodb package. See {@link _getting_started here} for document.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Adodb
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.1.7
 */

/**
 * Getting started for Ddth_Adodb package.
 *
 * <b>"Quick & Dirty":</b>
 * <code>
 * $DPHP_ADODB_CONFIG = Array (
 *     #see http://phplens.com/lens/adodb/docs-adodb.htm for details
 *     'adodb.url'       => 'mysql://root:pwd@localhost/mydb',
 *     'adodb.setupSqls' => Array("SET NAMES 'utf8'")
 * );
 * $adodbFactory = Ddth_Adodb_AdodbFactory::getInstance($DPHP_ADODB_CONFIG);
 * $conn = $adodbFactory->getConnection(); //get a ADOdb connection
 * //...
 * //use the ADOdb connection, see: http://phplens.com/lens/adodb/docs-adodb.htm
 * //...
 * $adodbFactory->closeConnection($conn); //close the ADOdb connection
 * </code>
 *
 * <b>1. Obtain an instance of {@link Ddth_Adodb_AdodbFactory}:</b>
 * <code>
 * $adodbFactory = Ddth_Adodb_AdodbFactory::getInstance();
 * //or:
 * $adodbFactory = Ddth_Adodb_AdodbFactory::getInstance($config);
 * </code>
 * If there is argument supplied, function {@link Ddth_Adodb_AdodbFactory::getInstance()} will
 * look for the global variable $DPHP_ADODB_CONFIG. If there is no such global variable, the
 * function will then look for the global variable $DPHP_ADODB_CONF.
 *
 * <b>2. Obtain instances of ADOConnection:</b>
 * <code>
 * $conn = $adodbFactory->getConnection();
 *
 * //get the connection & also start a transaction
 * $conn = $adodbFactory->getConnection(TRUE);
 * </code>
 *
 * <b>3. Use the ADOConnection in your way</b>
 *
 * <b>4. Close the ADOConnection when you are done with it:</b>
 * <code>
 * $adodbFactory->closeConnection($conn);
 *
 * //close the ADOConnection & also signal that there had been an error when you used it
 * $adodbFactory->closeConnection($conn, TRUE);
 * </code>
 *
 * <b>0. The configuration:</b> it's an associative array with the following structure
 * <code>
 * $conf = Array(
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
 * <ul>
 *     <li>Use either <i>adodb.url</i> or <i>adodb.dsn</i>.</li>
 *     <li>When <i>adodb.url</i> or <i>adodb.dsn</i> is used, other settings (except for <i>adodb.setupSqls</i>) are ignored.</li>
 *     <li><i>adodb.setupSqls</i> is an array of SQL queries that you want them to be automatically executed right
 *     after an ADOConnection is established.</li>
 * </ul>
 *
 * @package     Adodb
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1.7
 */
class _getting_started {
}
?>
