<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * In-memory cache engine.
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
 * In-memory cache engine.
 *
 * This cache engine stores PHP variables as-is in current process's memory space. Cache
 * entries have the scope of a HTTP request, which means they will NOT be persisted between
 * HTTP requests.
 *
 * @package     Cache
 * @subpackage  Engine
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Ddth_Cache_Engine_MemoryEngine implements Ddth_Cache_ICacheEngine {

    private $cache = Array();

    /**
     * @see Ddth_Cache_ICacheEngine::clear()
     */
    public function clear() {
        $this->cache = Array();
        return TRUE;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::destroy()
     */
    public function destroy() {
        //EMPTY
    }

    /**
     * @see Ddth_Cache_ICacheEngine::init()
     */
    public function init($config) {
        //EMPTY
    }

    /**
     * @see Ddth_Cache_ICacheEngine::exists()
     */
    public function exists($key) {
        return isset($this->cache[$key]);
    }

    /**
     * @see Ddth_Cache_ICacheEngine::get()
     */
    public function get($key) {
        return isset($this->cache[$key])?$this->cache[$key]:NULL;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::put()
     */
    public function put($key, $value) {
        $result = isset($this->cache[$key])?$this->cache[$key]:NULL;
        $this->cache[$key] = $value;
        return $result;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::remove()
     */
    public function remove($key) {
        $result = isset($this->cache[$key])?$this->cache[$key]:NULL;
        if ( $result !== NULL ) {
            unset($this->cache[$key]);
        }
        return $result;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::getNumHits()
     */
    public function getNumHits() {
        return FALSE;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::getNumMisses()
     */
    public function getNumMisses() {
        return FALSE;
    }

    /**
     * @see Ddth_Cache_ICacheEngine::getSize()
     */
    public function getSize() {
        return count($this->cache);
    }
}
?>
