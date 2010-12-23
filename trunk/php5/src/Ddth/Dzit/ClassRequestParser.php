<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Parses the HTTP request into tokens (module, action, parameters).
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
 * Parses the HTTP request into tokens (module, action, parameters).
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Ddth_Dzit_RequestParser {

    private static $instance = NULL;

    private $pathInfo = Array();

    /**
     * Constructs a new Ddth_Dzit_RequestParser object.
     */
    private function __construct() {
        //singleton

        /* parses the path info parameters */
        $this->pathInfo = $this->parsePathInfo();
    }

    /**
     * Gets the current request parser instance.
     *
     * @return Ddth_Dzit_RequestParser
     */
    public static function getInstance() {
        if ( self::$instance === NULL ) {
            self::$instance = new Ddth_Dzit_RequestParser();
        }
        return self::$instance;
    }

    /**
     * Parses the $_SERVER['PATH_INFO'].
     *
     * @return Array()
     */
    protected function parsePathInfo() {
        $this->pathInfo = Array();
        if ( isset($_SERVER['PATH_INFO']) ) {
            $tokens = explode('/', $_SERVER['PATH_INFO']);
            foreach ( $tokens as $token ) {
                if ( $token !== '' ) {
                    $this->pathInfo[] = $token;
                }
            }
        }
        return $this->pathInfo;
    }

    /**
     * Gets a path info parameter by index.
     * 
     * @param $index int
     * @return string
     */
    public function getPathInfoParam($index=0) {
        if ( $index < 0 || $index >= count($this->pathInfo) ) {
            return NULL;
        }
        return $this->pathInfo[$index];
    }
}
?>
