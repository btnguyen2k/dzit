<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * An engine-based cache.
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
 * An engine-based cache.
 *
 * This cache implementation delegates functionality to a wrapped {@link Ddth_Cache_ICacheEngine}.
 *
 * @package    	Cache
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Ddth_Cache_GenericCache extends Ddth_Cache_AbstractCache {

    const CONF_ENGINE_CLASS = 'cache.engine.class';

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * The wrapped cache engine.
     *
     * @var Ddth_Cache_ICacheEngine
     */
    private $engine;

    /**
     * Constructs a new Ddth_Cache_GenericCache object.
     */
    public function __construct() {
        parent::__construct();
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
    }

    /**
     * @see Ddth_Cache_AbstractCache::initCache().
     */
    protected function initCache() {
        $config = $this->getConfig();
        $engineClass = isset($config[self::CONF_ENGINE_CLASS])?$config[self::CONF_ENGINE_CLASS]:NULL;
        if ( $engineClass !== NULL ) {
            if ( $this->LOGGER->isDebugEnabled() ) {
                $this->LOGGER->debug("Found configuration engine class [$engineClass].");
            }
            $this->engine = new $engineClass;
        } else {
            $cacheType = isset($config[Ddth_Cache_CacheManager::CONF_CACHE_TYPE])?$config[Ddth_Cache_CacheManager::CONF_CACHE_TYPE]:NULL;
            switch ( $cacheType ) {
                case (self::CACHE_TYPE_APC): {
                    $this->engine = new Ddth_Cache_Engine_ApcEngine();
                    break;
                }
                case (Ddth_Cache_ICache::CACHE_TYPE_MEMCACHE): {
                    $this->engine = new Ddth_Cache_Engine_MemcacheEngine();
                    break;
                }
                case (Ddth_Cache_ICache::CACHE_TYPE_MEMCACHED): {
                    $this->engine = new Ddth_Cache_Engine_MemcachedEngine();
                    break;
                }
                default: {
                    $this->engine = new Ddth_Cache_Engine_MemoryEngine();
                    break;
                }
            }
        }
        $this->engine->init($config);
    }

    /**
     * Gets cache engine object.
     *
     * @return Ddth_Cache_ICacheEngine
     */
    protected function getEngine() {
        return $this->engine;
    }

    /**
     * @see Ddth_Cache_ICache::clear();
     */
    public function clear() {
        $result = $this->engine->clear();
        if ( $result ) {
            $this->setSize(0);
        }
        return $result;
    }

    /**
     * @see Ddth_Cache_ICache::exists();
     */
    public function exists($key) {
        $this->incNumGets();
        $result = $this->engine->exists($key);
        if ( $result ) {
            $this->incNumHits();
        } else {
            $this->incNumMisses();
        }
        return $result;
    }

    /**
     * @see Ddth_Cache_ICache::getSize()
     */
    public function getSize() {
        $result = $this->engine->getSize();
        return ($result === FALSE || $result < 0)?parent::getSize():$result;
    }

    /**
     * @see Ddth_Cache_ICache::getNumHits()
     */
    public function getNumHits() {
        $result = $this->engine->getNumHits();
        return ($result === FALSE || $result < 0)?parent::getNumHits():$result;
    }

    /**
     * @see Ddth_Cache_ICache::getNumMisses()
     */
    public function getNumMisses() {
        $result = $this->engine->getNumMisses();
        return ($result === FALSE || $result < 0)?parent::getNumMisses():$result;
    }

    /**
     * @see Ddth_Cache_ICache::get();
     */
    public function get($key) {
        $this->incNumGets();
        $result = $this->engine->get($key);
        if ( $result !== NULL ) {
            $this->incNumHits();
        } else {
            $this->incNumMisses();
        }
        return $result;
    }

    /**
     * @see Ddth_Cache_ICache::get();
     */
    public function put($key, $value) {
        $this->incNumPuts();
        $result = $this->engine->put($key, $value);
        if ( $result === NULL ) {
            //no existing entry, hence we should increase the number of entries count
            $this->setSize($this->getSize()+1);
        }
        return $result;
    }

    /**
     * @see Ddth_Cache_ICache::remove();
     */
    public function remove($key) {
        $result = $this->engine->remove($key);
        if ( $result !== NULL ) {
            //there is an existing entry, hence we should decrease the number of entries count
            $this->setSize($this->getSize()-1);
        }
        return $result;
    }
}
?>
