<?php
abstract class Quack_Bo_AppConfig_BaseAppConfigDao extends Quack_Bo_BaseDao implements
        Quack_Bo_AppConfig_IAppConfigDao {

    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     *
     * @see Quack_Bo_BaseDao::getCacheName()
     */
    public function getCacheName() {
        return 'IAppConfigDao';
    }

    /**
     * Creates a cache key from the config key
     *
     * @param string $configKey
     */
    protected function createCacheKeyConfig($configKey) {
        return $configKey;
    }

    /**
     * Invalidates cache due to change.
     *
     * @param Quack_Bo_AppConfig_BoAppConfig $config
     */
    protected function invalidateCache($config = NULL) {
        if ($config !== NULL) {
            $cacheKey = $this->createCacheKeyConfig($config->getKey());
            $this->putToCache($cacheKey, $config);
        }
    }

    /**
     *
     * @see Quack_Bo_AppConfig_IAppConfigDao::loadConfig()
     */
    public function loadConfig($key) {
        $cacheKey = $this->createCacheKeyConfig($key);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Quack_Bo_AppConfig_BoAppConfig::COL_KEY => $key);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Quack_Bo_AppConfig_BoAppConfig();
                $result->populate($rows[0]);
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
    }

    /**
     *
     * @see Quack_Bo_AppConfig_IAppConfigDao::saveConfig()
     */
    public function saveConfig($config) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_AppConfig_BoAppConfig::COL_KEY => $config->getKey(),
                Quack_Bo_AppConfig_BoAppConfig::COL_VALUE => $config->getValue());
        $result = $this->execNonSelect($sqlStm, $params);
        if ($result == 0) {
            $result = $this->createConfig($config);
        } else {
            $this->invalidateCache($config);
        }
        return $result;
    }

    protected function createConfig($config) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_AppConfig_BoAppConfig::COL_KEY => $config->getKey(),
                Quack_Bo_AppConfig_BoAppConfig::COL_VALUE => $config->getValue());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($config);
        return $result;
    }
}
