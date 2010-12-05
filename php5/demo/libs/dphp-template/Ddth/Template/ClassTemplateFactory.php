<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create instances of ITemplateFactory.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassTemplateFactory.php 227 2010-12-05 06:57:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Factory to create instances of ITemplateFactory.
 *
 * Configuration file format: the configurations are stored in
 * .properties file; supported properties are:
 * <code>
 * #class name of the concrete factory.
 * #Default is Ddth_Template_DefaultTemplateFactory
 * factory.class=Ddth_Template_DefaultTemplateFactory
 *
 * #each concrete factory will have its own configuration properties
 * #see its phpDocs for details
 * </code>
 * The default configuration file is dphp-template.properties located in
 * {@link http://www.php.net/manual/en/ini.core.php#ini.include-path include-path}.
 *
 * @package    	Template
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Template_TemplateFactory {
    private static $cacheInstances = Array();

    const DEFAULT_CONFIG_FILE = "dphp-template.properties";

    const DEFAULT_FACTORY_CLASS = 'Ddth_Template_DefaultTemplateFactory';

    const PROPERTY_FACTORY_CLASS = "factory.class";

    /**
     * Gets an instance of Ddth_Template_ITemplateFactory.
     *
     * Note: {@link Ddth_Template_TemplateFactory configuration file format}.
     *
     * @param string name of the configuration file (located in
     * {@link http://www.php.net/manual/en/ini.core.php#ini.include-path include-path})
     * @return Ddth_Template_ITemplateFactory
     * @throws {@link Ddth_Template_TemplateException TemplateException}
     */
    public static function getInstance($configFile=NULL) {
        if ( $configFile === NULL ) {
            return self::getInstance(self::DEFAULT_CONFIG_FILE);
        }
        if ( !isset(self::$cacheInstances[$configFile]) ) {
            $fileContent = Ddth_Commons_Loader::loadFileContent($configFile);
            if ( $fileContent === NULL ) {
                $msg = "Can not read file [$configFile]!";
                throw new Ddth_Template_TemplateException($msg);
            }
            $prop = new Ddth_Commons_Properties();
            try {
                $prop->import($fileContent);
            } catch ( Exception $e ) {
                $msg = $e->getMessage();
                throw new Ddth_Template_TemplateException($msg, $e->getCode());
            }
            $factoryClass = $prop->getProperty(self::PROPERTY_FACTORY_CLASS);
            if ( $factoryClass===NULL || trim($factoryClass)==="" ) {
                $factoryClass = self::DEFAULT_FACTORY_CLASS;
            } else {
                $factoryClass = trim($factoryClass);
            }
            try {
                @$instance = new $factoryClass();
                if ( $instance instanceof Ddth_Template_ITemplateFactory ) {
                    $instance->init($prop);
                    self::$cacheInstances[$configFile] = $instance;
                } else {
                    $msg = "[$factoryClass] does not implement Ddth_Template_ITemplateFactory";
                    throw new Ddth_Template_TemplateException($msg);
                }
            } catch ( Ddth_Template_TemplateException $me ) {
                throw $me;
            } catch ( Exception $e ) {
                $msg = $e->getMessage();
                throw new Ddth_Template_TemplateException($msg);
            }
        }
        return self::$cacheInstances[$configFile];
    }
}
?>
