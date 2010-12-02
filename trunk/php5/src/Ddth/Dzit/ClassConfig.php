<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * OO-style of in-memory {key:value} storage.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 * so we can email you a copy.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.2
 */

/**
 * OO-style of in-memory {key:value} storage.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Ddth_Dzit_Config {

    private static $config = Array();

    /**
     * Constructs a new Ddth_Dzit_Config object.
     */
    private function __construct() {
        //singleton
    }

    /**
     * Gets a configuration setting.
     *
     * @param string $name
     * @return mixed
     */
    public static function get($name) {
        if ( isset(self::$config[$name]) ) {
            return self::$config[$name];
        }
        return NULL;
    }

    /**
     * Sets a configuration setting.
     *
     * @param string $name
     * @param mixed $value
     */
    public static function set($name, $value) {
        self::$config[$name] = $value;
    }
}
?>