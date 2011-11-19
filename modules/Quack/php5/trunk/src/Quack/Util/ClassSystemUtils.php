<?php
class Quack_Util_SystemUtils {
    /**
     * Checks that if the current request is HTTPS
     *
     * @return boolean
     */
    public static function isHttps() {
        /* http://php.net/manual/en/reserved.variables.server.php */
        isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off';
    }
}
