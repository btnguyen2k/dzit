<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Representation of a cache engine.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Cache
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassICacheEngine.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

/**
 * Representation of a cache engine.
 *
 * @package     Cache
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
interface Ddth_Cache_ICacheEngine {
    /**
     * Removes all entries.
     *
     * @return bool TRUE if successful, FALSE otherwise
     */
    public function clear();

    /**
     * Clean-up method. After this function is called, the cache engine is considered no longer usable.
     */
    public function destroy();

    /**
     * Initializing method. The cache engine should not be used unless this function is called.
     *
     * @param Array $config cache configurations
     */
    public function init($config);

    /**
     * Checks if an entry exists.
     *
     * @param string $key
     * @return bool TRUE if exists, FALSE otherwise
     */
    public function exists($key);

    /**
     * Retrieves a cache entry.
     *
     * @param string $key
     * @return mixed the returned cache entry, NULL if not found
     */
    public function get($key);

    /**
     * Puts an entry into the cache.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed old entry with the same key (if exists)
     */
    public function put($key, $value);

    /**
     * Removes an entry.
     *
     * @param string $key
     * @return mixed existing entry associated with the key (if exists)
     */
    public function remove($key);

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
     * Gets cache's current size (number of elements).
     *
     * @return int -1 or FALSE should be returned if getting cache size is not supported
     */
    public function getSize();
}
?>
