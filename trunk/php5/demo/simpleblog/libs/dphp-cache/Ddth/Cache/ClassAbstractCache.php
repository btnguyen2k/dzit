<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * An abstract implementation of {@link Ddth_Cache_ICache}.
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
 * An abstract implementation of {@link Ddth_Cache_ICache}.
 *
 * @package    	Cache
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
abstract class Ddth_Cache_AbstractCache implements Ddth_Cache_ICache {
    /**
     * @var Array
     */
    private $config;

    /**
     * @var Ddth_Cache_CacheManager
     */
    private $manager;

    /**
     * @var string
     */
    private $cacheName = NULL;

    /**
     * Number of current items in cache.
     *
     * @var int
     */
    private $cacheSize = 0;

    /**
     * Number of cache hits.
     *
     * @var int
     */
    private $cacheHits = 0;

    /**
     * Number of cache misses.
     *
     * @var int
     */
    private $cacheMisses = 0;

    /**
     * Number of cache get requests.
     *
     * @var int
     */
    private $cacheGets = 0;

    /**
     * Number of cache put requests.
     *
     * @var int
     */
    private $cachePuts = 0;

    /**
     * Constructs a new Ddth_Cache_AbstractCache object.
     */
    public function __construct() {
    }

    /**
     * @see Ddth_Cache_ICache::destroy()
     */
    public function destroy() {
        $this->clear();
    }

    /**
     * @see Ddth_Cache_ICache::init()
     */
    public function init($name, $config, $manager) {
        $this->cacheName = $name;
        $this->config = $config;
        $this->manager = $manager;
        $this->initCache();
    }

    /**
     * Convenient function for sub-class to override.
     *
     * Sub-class overrides this method to perform its initializing work.
     */
    protected abstract function initCache();

    /**
     * Gets cache configuration object.
     *
     * @return Ddth_Cache_CacheConfig
     */
    protected function getConfig() {
        return $this->config;
    }

    /**
     * @see Ddth_Cache_ICache::getCacheManager()
     */
    public function getCacheManager() {
        return $this->manager;
    }

    /**
     * @see Ddth_Cache_ICache::getName()
     */
    public function getName() {
        return $this->cacheName;
    }

    /**
     * @see Ddth_Cache_ICache::getSize()
     */
    public function getSize() {
        return $this->cacheSize;
    }

    /**
     * Sets cache size.
     *
     * @param int $size
     */
    protected function setSize($size) {
        $this->cacheSize = $size;
    }

    /**
     * @see Ddth_Cache_ICache::getNumHits()
     */
    public function getNumHits() {
        return $this->cacheHits;
    }

    /**
     * Sets number of cache hits.
     *
     * @param int $hits
     */
    protected function setNumHits($hits) {
        $this->cacheHits = $hits;
    }

    /**
     * Increase number of cache hits.
     *
     * @param int $value
     */
    protected function incNumHits($value=1) {
        $this->cacheHits += $value;
    }

    /**
     * @see Ddth_Cache_ICache::getNumMisses()
     */
    public function getNumMisses() {
        return $this->cacheMisses;
    }

    /**
     * Sets number of cache misses.
     *
     * @param int $misses
     */
    protected function setNumMisses($misses) {
        $this->cacheMisses = $misses;
    }

    /**
     * Increase number of cache misses.
     *
     * @param int $value
     */
    protected function incNumMisses($value=1) {
        $this->cacheMisses += $value;
    }

    /**
     * @see Ddth_Cache_ICache::getNumGets()
     */
    public function getNumGets() {
        return $this->cacheGets;
    }

    /**
     * Sets number of cache get requests.
     *
     * @param int $gets
     */
    protected function setNumGets($gets) {
        $this->cacheGets = $gets;
    }

    /**
     * Increase number of cache get requests.
     *
     * @param int $value
     */
    protected function incNumGets($value=1) {
        $this->cacheGets += $value;
    }

    /**
     * @see Ddth_Cache_ICache::getNumPuts()
     */
    public function getNumPuts() {
        return $this->cachePuts;
    }

    /**
     * Sets number of cache put requests.
     *
     * @param int $puts
     */
    protected function setNumPuts($puts) {
        $this->cachePuts = $puts;
    }

    /**
     * Increase number of cache put requests.
     *
     * @param int $value
     */
    protected function incNumPuts($value=1) {
        $this->cachePuts += $value;
    }
}
?>
