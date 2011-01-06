<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * This class provides static APIs to store variables in a global-accessible location.
 *
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 */
final class Dzit_Demo_GlobalCache {

    const CACHE_URL_CREATOR = 'urlCreator';

    private static $cache = Array();

    /**
     * Gets a cache entry by name.
     *
     * @param string $name
     * @return mixed
     */
    public static function getEntry($name) {
        return isset(self::$cache[$name]) ? self::$cache[$name] : NULL;
    }

    /**
     * Stores a cache entry.
     *
     * @param string $name
     * @param mixed $value
     */
    public static function setEntry($name, $value) {
        self::$cache[$name] = $value;
    }
}
