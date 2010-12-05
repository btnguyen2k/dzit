<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create instances of ILanguageFactory.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassLanguageFactory.php 222 2010-11-21 07:25:10Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Factory to create instances of ILanguageFactory.
 *
 * Configuration file format: the configurations are stored in
 * .properties file; supported properties are:
 * <code>
 * # Class name of the concrete factory.
 * # Default value is Ddth_Mls_FileLanguageFactory.
 * factory.class=Ddth_Mls_FileLanguageFactory
 *
 * # Each concrete factory will have its own configuration properties,
 * # eee its phpDocs for details.
 * </code>
 * The default configuration file is dphp-mls.properties located in
 * {@link http://www.php.net/manual/en/ini.core.php#ini.include-path include-path}.
 *
 * @package    	Mls
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Mls_LanguageFactory {
    private static $cacheInstances = Array();

    const DEFAULT_CONFIG_FILE = "dphp-mls.properties";

    const DEFAULT_FACTORY_CLASS = 'Ddth_Mls_FileLanguageFactory';

    const PROPERTY_FACTORY_CLASS = "factory.class";

    /**
     * Gets an instance of Ddth_Mls_ILanguageFactory.
     *
     * Note: {@link Ddth_Mls_LanguageFactory configuration file format}.
     *
     * @param string name of the configuration file (located in
     * {@link http://www.php.net/manual/en/ini.core.php#ini.include-path include-path})
     * @return Ddth_Mls_ILanguageFactory
     * @throws {@link Ddth_Mls_MlsException MlsException}
     */
    public static function getInstance($configFile=NULL) {
        if ( $configFile === NULL ) {
            return self::getInstance(self::DEFAULT_CONFIG_FILE);
        }
        if ( !isset(self::$cacheInstances[$configFile]) ) {
            $fileContent = Ddth_Commons_Loader::loadFileContent($configFile);
            if ( $fileContent === NULL ) {
                $msg = "Can not read file [$configFile]!";
                throw new Ddth_Mls_MlsException($msg);
            }
            $prop = new Ddth_Commons_Properties();
            try {
                $prop->import($fileContent);
            } catch ( Exception $e ) {
                $msg = $e->getMessage();
                throw new Ddth_Mls_MlsException($msg, $e->getCode());
            }
            $factoryClass = $prop->getProperty(self::PROPERTY_FACTORY_CLASS);
            if ( $factoryClass===NULL || trim($factoryClass)==="" ) {
                $factoryClass = self::DEFAULT_FACTORY_CLASS;
            } else {
                $factoryClass = trim($factoryClass);
            }
            try {
                @$instance = new $factoryClass();
                if ( $instance instanceof Ddth_Mls_ILanguageFactory ) {
                    $instance->init($prop);
                    self::$cacheInstances[$configFile] = $instance;
                } else {
                    $msg = "[$factoryClass] does not implement Ddth_Mls_ILanguageFactory";
                    throw new Ddth_Mls_MlsException($msg);
                }
            } catch ( Ddth_Mls_MlsException $me ) {
                throw $me;
            } catch ( Exception $e ) {
                $msg = $e->getMessage();
                throw new Ddth_Mls_MlsException($msg);
            }
        }
        return self::$cacheInstances[$configFile];
    }
}
?>
