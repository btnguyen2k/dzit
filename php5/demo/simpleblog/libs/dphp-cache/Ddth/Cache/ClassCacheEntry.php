<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * A cache entry wrapper.
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
 * A cache entry wrapper.
 *
 * This class wraps a cache entry inside and also provides extra functionality such as
 * max idle time.
 *
 * Usage:
 * <code>
 * $cacheEntry = new Ddth_Cache_CacheEntry($realValue, 3600); //max idle time = 3600 seconds
 * //put $cacheEntry to cache
 * $cache->put($key, $cacheEntry);
 * //...
 * //get $cacheEntry from cache
 * $cacheEntry = $cache->get($key);
 * $value = $cacheEntry!==NULL ? $cacheEntry->getValue() : NULL;
 * </code>
 *
 * @package    	Cache
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Cache_CacheEntry {
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var int
     */
    private $maxIdleTime;

    /**
     * @var int
     */
    private $lastAccessTimestamp;

    /**
     * Constructs a new Ddth_Cache_CacheEntry object
     *
     * @param mixed $value
     * @param int $maxIdleTime max idle time (in seconds)
     */
    public function __construct($value, $maxIdleTime=0) {
        $this->value = $value;
        $this->maxIdleTime = $maxIdleTime+0;
        $this->lastAccessTimestamp = time();
    }

    /**
     * Gets max idle time.
     *
     * @return int max idle time (in seconds)
     */
    public function getMaxIdleTime() {
        return $this->maxIdleTime;
    }

    /**
     * Sets max idle time.
     *
     * @param int $maxIdleTime max idle time (in seconds)
     */
    public function setMaxIdleTime($maxIdleTime) {
        $this->maxIdleTime = $maxIdleTime+0;
    }

    /**
     * Gets entry's value.
     *
     * @return mixed
     */
    public function getValue() {
        if ( !$this->isExpired() ) {
            $this->lastAccessTimestamp = time();
            return $this->value;
        } else {
            return NULL;
        }
    }

    /**
     * Gets entry's last access timestamp.
     *
     * @return int UNIX timestamp
     */
    public function getLastAccessTimestamp() {
        return $this->lastAccessTimestamp;
    }

    /**
     * Checks if this entry is expired.
     *
     * @return bool
     */
    public function isExpired() {
        $maxIdleTime = $this->maxIdleTime;
        return $maxIdleTime > 0 && $this->lastAccessTimestamp+$maxIdleTime < time();
    }
}
?>
