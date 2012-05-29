<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Parses the HTTP request into tokens (module, action, parameters).
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package Dzit
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version $Id$
 * @since File available since v0.2
 */

/**
 * Parses the HTTP request into tokens (module, action, parameters).
 *
 * @package Dzit
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.2
 */
class Dzit_RequestParser {

    private static $instance = NULL;

    private $pathInfo = Array();

    /**
     * Constructs a new Dzit_RequestParser object.
     */
    private function __construct() {
        // singleton

        /* parses the path info parameters */
        $this->pathInfo = $this->parsePathInfo();
    }

    /**
     * Gets the current request parser instance.
     *
     * @return Ddth_Dzit_RequestParser
     */
    public static function getInstance() {
        if (self::$instance === NULL) {
            self::$instance = new Dzit_RequestParser();
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
        $pathInfo = '';
        if (isset($_SERVER['PATH_INFO'])) {
            $pathInfo = $_SERVER['PATH_INFO'];
        } else if (isset($_SERVER['SCRIPT_URL']) && isset($_SERVER['SCRIPT_NAME'])) {
            // fall back to SCRIPT_URL to extract path info
            $pathInfo = substr($_SERVER['SCRIPT_URL'], strlen($_SERVER['SCRIPT_NAME']));
        } else {
            // fallback method
            $uri = isset($_SERVER['DOCUMENT_URI']) ? $_SERVER['DOCUMENT_URI'] : $_SERVER['REQUEST_URI'];
            $pathInfo = substr($_SERVER['DOCUMENT_URI'], strlen($_SERVER['SCRIPT_NAME']));
        }
        $tokens = explode('/', $pathInfo);
        foreach ($tokens as $token) {
            if ($token !== '') {
                $this->pathInfo[] = $token;
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
    public function getPathInfoParam($index = 0) {
        if ($index < 0 || $index >= count($this->pathInfo)) {
            return NULL;
        }
        return $this->pathInfo[$index];
    }

    /**
     * Gets the "module" parameter.
     *
     * @return string
     */
    public function getModule() {
        $module = $this->getPathInfoParam(0);
        if ($module == NULL && isset($_GET[Dzit_Constants::URL_PARAM_MODULE])) {
            $module = $_GET[Dzit_Constants::URL_PARAM_MODULE];
        }
        return $module;
    }

    /**
     * Gets the "action" parameter.
     *
     * @return string
     */
    public function getAction() {
        $module = $this->getModule();
        if ($module == NULL) {
            return NULL;
        }
        $action = $this->getPathInfoParam(1);
        if ($action == NULL && isset($_GET[Dzit_Constants::URL_PARAM_ACTION])) {
            $action = $_GET[Dzit_Constants::URL_PARAM_ACTION];
        }
        return $action;
    }
}
?>
