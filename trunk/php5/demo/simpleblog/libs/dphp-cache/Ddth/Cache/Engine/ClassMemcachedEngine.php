<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Memcache (using php-memcacheD APIs) cache engine.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Cache
 * @subpackage  Engine
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.2
 */

/**
 * Memcache (using php-memcacheD APIs) cache engine.
 *
 * This cache engine utilizes php-memcacheD APIs to store entries.
 *
 * @package     Cache
 * @subpackage  Engine
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Ddth_Cache_Engine_MemcachedEngine implements Ddth_Cache_ICacheEngine {

    const CONF_SERVERS = 'memcached.servers';
    const CONF_SERVER_HOST   = 'host';
    const CONF_SERVER_PORT   = 'port';
    const CONF_SERVER_WEIGHT = 'weight';

    const DEFAULT_SERVER_HOST   = 'localhost';
    const DEFAULT_SERVER_PORT   = 11211;
    const DEFAULT_SERVER_WEIGHT = 1;

    private $memcached;

    /**
     * Gets the Memcached instance (PHP's Memcached class).
     *
     * @return Memcached
     */
    protected function getMemcachedObj() {
        return $this->memcached;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::clear()
     */
    public function clear() {
        return $this->memcached->flush();
    }

    /**
     * @see Ddth_Cache_ICacheEngine::destroy()
     */
    public function destroy() {
        //EMPTY
    }

    /**
     * This function accepts an associative array as its parameter. Detailed specs of
     * the array:
     * <code>
     * Array(
     *     'memcached.servers'   => Array(
     *         #list of MemcacheD servers
     *         Array(
     *             #see http://www.php.net/manual/en/memcached.addserver.php for more information
     *             'host'       => '192.168.0.1',
     *             'port'       => '(optional) 11211',
     *             'weight'     => '(optional) 1'
     *         ),
     *         Array(
     *             'host'       => '192.168.0.2',
     *             'port'       => '(optional) 11211',
     *             'weight'     => '(optional) 1'
     *         )
     *     )
     * )
     * </code>
     *
     * @see Ddth_Cache_ICacheEngine::init()
     */
    public function init($config) {
        if ( !class_exists('Memcached', FALSE) ) {
            $msg = 'PHP-Memcached is not available!';
            throw new Ddth_Cache_CacheException($msg);
        }
        $servers = isset($config[self::CONF_SERVERS])?$config[self::CONF_SERVERS]:NULL;
        if ( $servers === NULL || !is_array($servers) || count($servers) < 1 ) {
            $msg = 'No Memcache servers defined!';
            throw new Ddth_Cache_CacheException($msg);
        }
        $memcached = new Memcached();
        foreach ( $servers as $server ) {
            $host = isset($server[self::CONF_SERVER_HOST])?$server[self::CONF_SERVER_HOST]:self::DEFAULT_SERVER_HOST;
            $port = isset($server[self::CONF_SERVER_PORT])?$server[self::CONF_SERVER_PORT]:self::DEFAULT_SERVER_PORT;
            $weight = isset($server[self::CONF_SERVER_WEIGHT])?$server[self::CONF_SERVER_WEIGHT]:self::DEFAULT_SERVER_WEIGHT;
            $memcached->addServer($host, $port, $weight);
        }
        $this->memcached = $memcached;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::exists()
     */
    public function exists($key) {
        return $this->get($key) !== NULL;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::get()
     */
    public function get($key) {
        $result = $this->memcached->get($key);
        if ( $this->memcached->getResultCode() !== Memcached::RES_NOTFOUND ) {
            return $result;
        } else {
            return NULL;
        }
    }

    /**
     * @see Ddth_Cache_ICacheEngine::put()
     */
    public function put($key, $value) {
        $result = $this->get($key);
        $this->memcached->set($key, $value);
        return $result;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::put()
     */
    public function remove($key) {
        $result = $this->get($key);
        if ( $result !== NULL ) {
            $this->memcached->delete($key);
        }
        return $result;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::getNumHits()
     */
    public function getNumHits() {
        $stats = $this->memcached->getStats();
        $numHits = 0;
        foreach ( $stats as $serverName=>$serverStats ) {
            $numHits += $serverStats['get_hits'];
        }
        return $numHits;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::getNumMisses()
     */
    public function getNumMisses() {
        $stats = $this->memcached->getStats();
        $numMisses = 0;
        foreach ( $stats as $serverName=>$serverStats ) {
            $numMisses += $serverStats['get_misses'];
        }
        return $numMisses;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::getSize()
     */
    public function getSize() {
        $stats = $this->memcached->getStats();
        $size = 0;
        foreach ( $stats as $serverName=>$serverStats ) {
            $size += $serverStats['curr_items'];
        }
        return $size;
    }
}
?>
