<?php
interface Quack_Bo_AppConfig_IAppConfigDao extends Ddth_Dao_IDao {
    /**
     * Load a config by key.
     *
     * @param string $key
     * @return Quack_Bo_AppConfig_BoAppConfig
     */
    public function loadConfig($key);

    /**
     * Save a config.
     *
     * @param Quack_Bo_AppConfig_BoAppConfig $config
     */
    public function saveConfig($config);
}
