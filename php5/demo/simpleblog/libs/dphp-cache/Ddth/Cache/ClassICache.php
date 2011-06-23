<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Representation of a cache.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Cache
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.1
 */

/**
 * Representation of a cache.
 *
 * @package     Cache
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Ddth_Cache_ICache {

    const CACHE_TYPE_MEMCACHE   = 'memcache';   //cache type: MemcacheD (use php-memcache APIs)
    const CACHE_TYPE_MEMCACHED  = 'memcached';  //cache type: MemcacheD (use php-memcacheD APIs)
    const CACHE_TYPE_APC        = 'apc';        //cache type: APC
    const CACHE_TYPE_MEMORY     = 'memory';     //cache type: in-memory

    /**
     * Removes all entries from this cache.
     *
     * @return bool TRUE if successful, FALSE otherwise
     */
    public function clear();

    /**
     * Clean-up method. After this function is called, the cache is considered no longer usable.
     */
    public function destroy();

    /**
     * Initializing method. The cache should not be used unless this function is called.
     *
     * @param string $name cache's name
     * @param Array $config cache configuration
     * @param Ddth_Cache_CacheManager $manager
     */
    public function init($name, $config, $manager);

    /**
     * Checks if an entry exists in this cache.
     *
     * @param string $key
     * @return bool TRUE if exists, FALSE otherwise
     */
    public function exists($key);

    /**
     * Retrieves a cache entry from this cache.
     *
     * @param string $key
     * @return mixed the returned cache entry, NULL if not found
     */
    public function get($key);

    /**
     * Gets cache's current size (number of elements).
     *
     * @return int -1 or FALSE should be returned if getting cache size is not supported
     */
    public function getSize();

    /**
     * Gets this cache's associated cache manager.
     *
     * @return Ddth_Cache_CacheManager
     */
    public function getCacheManager();

    /**
     * Gets this cache's name.
     *
     * @return string
     */
    public function getName();

    /**
     * Gets number of cache "hits".
     *
     * @return int -1 or FALSE should be returned if getting cache hits is not supported
     */
    public function getNumHits();

    /**
     * Gets number of cache "misses".
     *
     * @return int -1 or FALSE should be returned if getting cache misses is not supported
     */
    public function getNumMisses();

    /**
     * Gets number of cache "get" requests.
     *
     * @return int -1 or FALSE should be returned if getting number of get requests is not supported
     */
    public function getNumGets();

    /**
     * Gets number of cache "put" requests.
     *
     * @return int -1 or FALSE should be returned if getting number of put requests is not supported
     */
    public function getNumPuts();

    /**
     * Puts an entry into this cache.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed old entry with the same key (if exists)
     */
    public function put($key, $value);

    /**
     * Removes an entry from this cache.
     *
     * @param string $key
     * @return mixed existing entry associated with the key (if exists)
     */
    public function remove($key);
}
?>
