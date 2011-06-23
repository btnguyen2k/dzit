<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Cache manager.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Cache
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.2
 */

/**
 * Cache manager.
 *
 * This class provides APIs to manage caches.
 *
 * @package     Cache
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version    	$Id$
 * @since      	Class available since v0.2
 */
class Ddth_Cache_CacheManager {

    /**
     * Name of the default cache.
     *
     * @var string
     */
    const DEFAULT_CACHE_NAME = 'default';

    const CONF_CACHE_TYPE = 'cache.type';
    const CONF_CACHE_CLASS = 'cache.class';

    private static $cacheInstances = Array();

    /**
     * @var Array
     */
    private $config;

    /**
     * @var Array
     */
    private $caches = Array();

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;


    /**
     * Static function to get instances of {@link Ddth_Cache_CacheManager}.
     *
     * This function accept an associative array as parameter. If the argument is NULL,
     * the global variable $DPHP_CACHE_CONFIG is used instead (if there is no global variable
     * $DPHP_CACHE_CONFIG, the function fallbacks to use the global variable $DPHP_CACHE_CONF).
     *
     * Detailed specs of the configuration array:
     * <code>
     * Array(
     *     'default' => Array(
     *         #the 'default' cache (where 'default' is cache's name), required
     *         'cache.type'         => 'type of cache, either: memcache, memcached, apc, or memory',
     *         'cache.class'        => '(optional) name of the cache class,
     *                                  must implement Ddth_Cache_ICache',
     *         'cache.engine.class' => '(optional) name of the cache engine class (if Ddth_Cache_GenericCache
     *                                  is used - which is the default), must implement Ddth_Cache_ICacheEngine',
     *         'other configs'      => 'specified by each type of cache/engine'
     *     ),
     *     'memory' => Array(
     *         #example of in-memory cache. Cache entries will NOT be persisted across HTTP requests!
     *         'cache.type'         => 'memory'
     *     ),
     *     'apc' => Array(
     *         #example of APC cache. Cache entries will be persisted across HTTP requests.
     *         'cache.type'         => 'apc'
     *     ),
     *     'memcache' => Array(
     *         #example of MemcacheD cache (use php-memcache APIs). Cache entries will be persisted across HTTP requests.
     *         'cache.type'         => 'memcache',
     *         'memcache.servers'   => Array(
     *             #list of MemcacheD servers
     *             Array(
     *                 #see http://www.php.net/manual/en/memcache.addserver.php for more information
     *                 'host'       => '192.168.0.1',
     *                 'port'       => '(optional) 11211',
     *                 'weight'     => '(optional) 1'
     *             ),
     *             Array(
     *                 'host'       => 'unix:///path/to/memcached.sock',
     *                 'port'       => 0, #must be 0 if using UNIX socket
     *                 'weight'     => '(optional) 1'
     *             )
     *         )
     *     ),
     *     'memcached' => Array(
     *         #example of MemcacheD cache (use php-memcached APIs). Cache entries will be persisted across HTTP requests.
     *         'cache.type'         => 'memcached',
     *         'memcached.servers'   => Array(
     *             #list of MemcacheD servers
     *             Array(
     *                 #see http://www.php.net/manual/en/memcached.addserver.php for more information
     *                 'host'       => '192.168.0.1',
     *                 'port'       => '(optional) 11211',
     *                 'weight'     => '(optional) 1'
     *             ),
     *             Array(
     *                 'host'       => '192.168.0.2',
     *                 'port'       => '(optional) 11211',
     *                 'weight'     => '(optional) 1'
     *             )
     *         )
     *     )
     * );
     * </code>
     *
     * @param Array $config the configuration array
     * @return Ddth_Cache_CacheManager
     */
    public static function getInstance($config=NULL) {
        if ( $config === NULL ) {
            global $DPHP_CACHE_CONFIG;
            $config = isset($DPHP_CACHE_CONFIG)?$DPHP_CACHE_CONFIG:NULL;
        }
        if ( $config === NULL ) {
            global $DPHP_CACHE_CONF;
            $config = isset($DPHP_CACHE_CONF)?$DPHP_CACHE_CONF:NULL;
        }
        if ( $config === NULL ) {
            global $DPHP_CACHE_CFG;
            $config = isset($DPHP_CACHE_CFG)?$DPHP_CACHE_CFG:NULL;
        }
        if ( $config === NULL ) {
            return NULL;
        }
        $hash = md5(serialize($config));
        if ( !isset(self::$cacheInstances[$hash]) ) {
            $instance = new Ddth_Cache_CacheManager($config);
            self::$cacheInstances[$hash] = $instance;
        }
        return self::$cacheInstances[$hash];
    }

    /**
     * Constructs a new Ddth_Cache_CacheManager object.
     *
     * @param Array $config see {@link Ddth_Cache_CacheManager::getInstance()} for more information
     */
    protected function __construct($config) {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        $this->config = $config;
    }

    /**
     * Perform clean-up work before shutting down this cache manager.
     */
    public function destroy() {
        if ( $this->LOGGER->isDebugEnabled() ) {
            $this->LOGGER->debug(__CLASS__.'::'.__FUNCTION__.'() is called');
        }
        //EMPTY
    }

    /**
     * Performs initializing work before using this cache manager.
     */
    public function init() {
        if ( $this->LOGGER->isDebugEnabled() ) {
            $this->LOGGER->debug(__CLASS__.'::'.__FUNCTION__.'() is called');
        }
        //EMPTY
    }

    /**
     * Gets a cache by its name.
     *
     * @param string
     * @return Ddth_Cache_ICache
     */
    public function getCache($name) {
        $cache = isset($this->caches[$name])?$this->caches[$name]:NULL;
        if ( $cache === NULL ) {
            if ( $this->LOGGER->isDebugEnabled() ) {
                $this->LOGGER->debug("Can not get cache [$name] from pool.");
            }
            $cache = $this->createCache($name);
            if ( $cache !== NULL ) {
                $this->caches[$name] = $cache;
            }
        }
        return $cache;
    }

    /**
     * Creates a cache by name.
     *
     * @param string $name
     */
    protected function createCache($name) {
        if ( $this->LOGGER->isInfoEnabled() ) {
            $this->LOGGER->info("Creating cache [$name]...");
        }
        $cacheConfig = isset($this->config[$name])?$this->config[$name]:NULL;
        if ( $cacheConfig === NULL ) {
            if ( $this->LOGGER->isInfoEnabled() ) {
                $this->LOGGER->info("Can not find configurations for cache [$name], fall back to default.");
            }
            $tempName = self::DEFAULT_CACHE_NAME;
            $cacheConfig = isset($this->config[$tempName])?$this->config[$tempName]:NULL;
        }
        if ( $cacheConfig === NULL ) {
            $this->LOGGER->error("Can not create cache [$name]!");
            return NULL;
        }
        $cache = $this->_createCache($name, $cacheConfig);
        return $cache;
    }

    private function _createCache($name, $cacheConfig) {
        /**
         * @var Ddth_Cache_ICache
         */
        $cache = NULL;
        $cacheClass = isset($cacheConfig[self::CONF_CACHE_CLASS])?$cacheConfig[self::CONF_CACHE_CLASS]:NULL;
        if ( $cacheClass !== NULL ) {
            if ( $this->LOGGER->isDebugEnabled() ) {
                $this->LOGGER->debug("Found configuration cache class [$cacheClass].");
            }
            $cache = new $cacheClass();
        } else {
            $cacheType = isset($cacheConfig[self::CONF_CACHE_TYPE])?$cacheConfig[self::CONF_CACHE_TYPE]:NULL;
            if ( $this->LOGGER->isDebugEnabled() ) {
                $this->LOGGER->debug("Creating a new cache of type [$cacheType].");
            }
            $cache = new Ddth_Cache_GenericCache();
        }
        if ( $cache !== NULL ) {
            $cache->init($name, $cacheConfig, $this);
        }
        return $cache;
    }

    /**
     * Shortcut for {@link getCache()}.{@link Ddth_Cache_ICache::clear() clear()}.
     *
     * @param string $name
     */
    public function clearCache($name) {
        $cache = $this->getCache();
        if ( $cache !== NULL ) {
            $cache->clear();
        }
    }

    /**
     * Shortcut for {@link getCache()}.{@link Ddth_Cache_ICache::get() get()}.
     *
     * @param string $name name of the cache
     * @param string $key the entry's key
     * @return mixed
     */
    public function getFromCache($name, $key) {
        $cache = $this->getCache();
        if ( $cache !== NULL ) {
            return $cache->get($key);
        }
        return NULL;
    }

    /**
     * Shortcut for {@link getCache()}.{@link Ddth_Cache_ICache::put() put()}.
     *
     * @param string $name name of the cache
     * @param string $key the entry's cache
     * @param mixed $value
     * @return mixed old entry with the same key (if exists)
     */
    public function putToCache($name, $key, $value) {
        $cache = $this->getCache();
        if ( $cache !== NULL ) {
            return $cache->put($key, $value);
        }
        return NULL;
    }

    /**
     * Shortcut for {@link getCache()}.{@link Ddth_Cache_ICache::remove() remove()}.
     *
     * @param string $name name of the cache
     * @param string $key the entry's key.
     * @return mixed existing entry associated with the key (if exists)
     */
    public function removeFromCache($name, $key) {
        $cache = $this->getCache();
        if ( $cache !== NULL ) {
            return $cache->remove($key);
        }
        return NULL;
    }
}
?>
