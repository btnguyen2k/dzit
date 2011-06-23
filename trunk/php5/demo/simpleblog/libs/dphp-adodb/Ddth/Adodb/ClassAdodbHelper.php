<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * ADOdb helper class.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package		Adodb
 * @author		Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version			$Id$
 * @since      	File available since v0.1.2
 */

/**
 * ADOdb helper class.
 *
 * @package    	Adodb
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1.2
 */
class Ddth_Adodb_AdodbHelper {

    /**
     * A shortcut to to build string with n question marks separated by commas (e.g. "?,?,?,?").
     *
     * @param int
     * @return string
     */
    public static function buildArrayParams($count = 1) {
        $count += 0;
        if ( $count < 1 ) {
            return '';
        }
        $result = '?';
        for ( $i = 1; $i < $count; $i++ ) {
            $result .= ',?';
        }
        return $result;
    }

    /**
     * Prepares the SQL statement.
     *
     * @param ADOConnection an active ADOdb connection
     * @param string the SQL statement
     * @param Array list of named binding parameters (case-sensitive! and in-order!!!)
     * @return string the prepared SQL statement
     * @since function available since v0.1.5.1
     */
    public static function prepareSql($conn, $sql, $params = Array()) {
        foreach ( $params as $p ) {
            $sql = str_replace('${' . $p . '}', $conn->Param($p), $sql);
        }
        return $sql;
    }
}
?>
