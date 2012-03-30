<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Debug information class.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Quack
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassICache.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Debug information.
 *
 * This class encapsulates debug information: memory usage and executed SQL queries.
 *
 * @package     Quack
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Quack_DebugInfo {
    public function getMemoryUsage() {
        return memory_get_usage();
    }

    public function getMemoryUsageKb() {
        return memory_get_usage() / 1024;
    }

    public function getMemoryUsageMb() {
        return memory_get_usage() / 1024 / 1024;
    }

    public function getMemoryPeakUsage() {
        return memory_get_peak_usage();
    }

    public function getMemoryPeakUsageKb() {
        return memory_get_peak_usage() / 1024;
    }

    public function getMemoryPeakUsageMb() {
        return memory_get_peak_usage() / 1024 / 1024;
    }

    public function getMemoryLimit() {
        return ini_get('memory_limit');
    }

    public function getSqlLog() {
        $sqlLog = Ddth_Dao_BaseDaoFactory::getQueryLog();
        for ($i = 0; $i < count($sqlLog); $i++) {
            $sql = $sqlLog[$i][0];
            if (strlen($sql) > 200) {
                $sqlLog[$i][0] = substr($sql, 0, 197) . '...';
            }
        }
        return $sqlLog;
    }

    public function getCacheInfo() {
        return Ddth_Cache_CacheManager::getInstance()->getCaches();
    }
}
