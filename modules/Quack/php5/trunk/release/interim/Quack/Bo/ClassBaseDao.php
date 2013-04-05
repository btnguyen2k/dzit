<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Base DAO.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package Quack
 * @subpackage Bo
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version $Id: ClassBaseDao.php 213 2012-07-12 17:34:09Z btnguyen2k $
 * @since File available since v0.1
 */

/**
 * Base class for application's DAOs.
 *
 * @package Quack
 * @subpackage Bo
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
abstract class Quack_Bo_BaseDao extends Ddth_Dao_AbstractSqlStatementDao {

    const DEFAULT_CACHE_WRITE_EXPIRY = 3600;
    protected $cacheL1 = Array();

    /**
     * Name of the L2 cache.
     *
     * @var string
     */
    private $cacheName = 'default';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Gets name of the L2 cache for this DAO to use.
     *
     * @return string
     */
    public function getCacheName() {
        return $this->cacheName;
    }

    /**
     * Sets name of the L2 cache for this DAO to use.
     *
     * @param string $cacheName
     */
    public function setCacheName($cacheName) {
        $this->cacheName = $cacheName;
    }

    /**
     * Convenient method to return a cached result.
     *
     * @param mixed $result
     * @param string $cacheKey
     * @param boolean $includeCacheL2
     */
    protected function returnCachedResult($result, $cacheKey, $includeCacheL2 = TRUE) {
        if ( $cacheKey !== NULL ) {
            if ($result === NULL) {
                // cache "not found" result
                $this->putToCache($cacheKey, NULL, $includeCacheL2);
            } else if ($result instanceof Ddth_Cache_CacheEntry) {
                $this->putToCache($cacheKey, $result, $includeCacheL2); // refresh cache entry
                $result = $result->getValue();
            } else {
                $cacheEntry = new Ddth_Cache_CacheEntry($result);
                $this->putToCache($cacheKey, $cacheEntry, $includeCacheL2);
            }
        }
        return $result;
    }

    /**
     * Put an entry to cache.
     *
     * @param string $key
     * @param mixed $value
     * @param boolean $includeCacheL2
     */
    protected function putToCache($key, $value, $includeCacheL2 = TRUE) {
        if (!($value instanceof Ddth_Cache_CacheEntry)) {
            $obj = new Ddth_Cache_CacheEntry($value);
            if ($value === NULL) {
                $obj->setExpireAfterWrite(self::DEFAULT_CACHE_WRITE_EXPIRY);
            }
            $value = $obj;
        }
        $this->cacheL1[$key] = $value;
        if ($includeCacheL2) {
            Quack_Util_CacheUtils::put($key, $value, $this->getCacheName());
        }
    }

    /**
     * Gets an entry from cache.
     *
     * @param string $key
     * @param boolean $includeCacheL2
     * @return mixed
     */
    protected function getFromCache($key, $includeCacheL2 = TRUE) {
        $result = isset($this->cacheL1[$key]) ? $this->cacheL1[$key] : NULL;
        if ($result === NULL && $includeCacheL2) {
            $result = Quack_Util_CacheUtils::get($key, $this->getCacheName());
            if ($result !== NULL) {
                $this->cacheL1[$key] = $result;
            }
        }
        if (($result instanceof Ddth_Cache_CacheEntry) && $result->isExpired()) {
            $result = NULL;
        }
        return $result;
    }

    /**
     * Deletes an entry from cache.
     *
     * @param string $key
     * @param boolean $includeCacheL2
     */
    protected function deleteFromCache($key, $includeCacheL2 = TRUE) {
        unset($this->cacheL1[$key]);
        if ($includeCacheL2) {
            Quack_Util_CacheUtils::delete($key, $this->getCacheName());
        }
    }

    /**
     * Fetches result from the result set and returns as an associative array.
     *
     * @param resource $rs
     */
    protected abstract function fetchResultAssoc($rs);

    /**
     * Fetches result from the result set and returns as an index array.
     *
     * @param resource $rs
     */
    protected abstract function fetchResultArr($rs);

    /**
     * Executes a "COUNT" statement.
     *
     * @param
     *            {@link Ddth_Dao_SqlStatement} $stm
     * @param Array $params
     * @param mixed $conn
     *            an open db connection
     * @param string $cacheKey
     * @param boolean $includeCacheL2
     * @return int the "COUNT" value, or FALSE if error
     */
    protected function execCount($stm, $params = Array(), $conn = NULL, $cacheKey = NULL, $includeCacheL2 = TRUE) {
        if ($cacheKey !== NULL) {
            $result = $this->getFromCache($cacheKey, $includeCacheL2);
            if ($result !== NULL) {
                return $result;
            }
        }
        $closeConn = FALSE;
        if ($conn === NULL) {
            $conn = $this->getConnection()->getConn();
            $closeConn = TRUE;
        }
        if ($params === NULL) {
            $params = Array();
        }
        $rs = $stm->execute($conn, $params);
        $result = $this->fetchResultArr($rs);
        if ($closeConn) {
            $this->closeConnection();
        }
        $result = $result !== FALSE ? $result[0] : FALSE;
        return $this->returnCachedResult($result, $cacheKey, $includeCacheL2);
    }

    /**
     * Executes a non-select (DELETE, INSERT, UPDATE) statement.
     *
     * @param
     *            {@link Ddth_Dao_SqlStatement} $stm the statement to execute.
     * @param Array $params
     * @param mixed $conn
     *            an open db connection
     * @return int number of affected rows, FALSE if error, or -1 if not
     *         supported
     */
    protected function execNonSelect($stm, $params = Array(), $conn = NULL) {
        $closeConn = FALSE;
        if ($conn === NULL) {
            $conn = $this->getConnection()->getConn();
            $closeConn = TRUE;
        }
        $qres = $stm->execute($conn, $params);
        $result = $stm->getNumAffectedRows($conn, $qres);
        if ($closeConn) {
            $this->closeConnection();
        }
        return $result;
    }

    /**
     * Executes a "SELECT" statement.
     *
     * @param
     *            {@link Ddth_Dao_SqlStatement} $stm the statement to execute.
     * @param Array $params
     * @param mixed $conn
     *            an open db connection
     * @param string $cacheKey
     * @return Array
     */
    protected function execSelect($stm, $params = Array(), $conn = NULL, $cacheKey = NULL, $includeCacheL2 = TRUE) {
        if ($cacheKey !== NULL) {
            $result = $this->getFromCache($cacheKey, $includeCacheL2);
            if ($result !== NULL) {
                return $result;
            }
        }
        $closeConn = FALSE;
        if ($conn === NULL) {
            $conn = $this->getConnection()->getConn();
            $closeConn = TRUE;
        }
        if ($params === NULL) {
            $params = Array();
        }
        $rs = $stm->execute($conn, $params);
        $result = Array();
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $result[] = $row;
            $row = $this->fetchResultAssoc($rs);
        }
        if ($closeConn) {
            $this->closeConnection();
        }
        if ( count($result) == 0 ) {
            //return NULL if not found
            $result = NULL;
        }
        return $this->returnCachedResult($result, $cacheKey, $includeCacheL2);
    }

    /**
     * Gets a {@link Ddth_Dao_SqlStatement} object, throws exception if not
     * found.
     *
     * @param string $name
     *            name of the statement to get
     * @return Ddth_Dao_SqlStatement
     */
    protected function getStatement($name) {
        $stm = $this->getSqlStatement($name);
        if ($stm === NULL) {
            $msg = "Can not obtain the statement [$name]!";
            throw new Exception($msg);
        }
        return $stm;
    }
}
