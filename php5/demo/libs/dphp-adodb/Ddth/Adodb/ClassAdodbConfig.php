<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * ADOdb configurations.
 *
 * LICENSE: This source file is subject to version 3.0 of the GNU Lesser General
 * Public License that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/lgpl.html. If you did not receive a copy of
 * the GNU Lesser General Public License and are unable to obtain it through the web,
 * please send a note to gnu@gnu.org, or send an email to any of the file's authors
 * so we can email you a copy.
 *
 * @package		Adodb
 * @author		NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @id			$Id: ClassAdodbConfig.php 137 2008-02-28 00:27:48Z btnguyen2k@gmail.com $
 * @since      	File available since v0.1
 */

if ( !function_exists('__autoload') ) {
    /**
     * Automatically loads class source file when used.
     *
     * @param string
     */
    function __autoload($className) {
        require_once 'Ddth/Commons/ClassDefaultClassNameTranslator.php';
        require_once 'Ddth/Commons/ClassLoader.php';
        $translator = Ddth_Commons_DefaultClassNameTranslator::getInstance();
        Ddth_Commons_Loader::loadClass($className, $translator);
    }
}

/**
 * ADOdb configurations.
 *
 * This class encapsulates ADOdb's configuration settings.
 *
 * @package    	Adodb
 * @author     	NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version    	0.1
 * @since      	Class available since v0.1
 */
class Ddth_Adodb_AdodbConfig {

    const PROPERTY_URL = "adodb.url";

    //    const PROPERTY_USER = "adodb.user";
    //
    //    const PROPERTY_PASSWORD = "adodb.password";

    /**
     * Loads configurations from file and encapsulates them inside a
     * Ddth_Adodb_AdodbConfig instance.
     *
     * See: {@link Ddth_Adodb_AdodbConfig configuration file format}.
     *
     * @param string name of the configuration file (located in
     * {@link http://www.php.net/manual/en/ini.core.php#ini.include-path include-path})
     * @return Ddth_Adodb_AdodbConfig
     * @throws {@link Ddth_Adodb_AdodbException AdodbException}
     */
    public static function loadConfig($configFile) {
        $fileContent = Ddth_Commons_Loader::loadFileContent($configFile);
        if ( $fileContent === NULL ) {
            $msg = "Can not read file [$configFile]!";
            throw new Ddth_Adodb_AdodbException($msg);
        }
        $prop = new Ddth_Commons_Properties();
        try {
            $prop->import($fileContent);
        } catch ( Exception $e ) {
            throw new Ddth_Adodb_AdodbException($e->getMessage(), $e->getCode());
        }
        return new Ddth_Adodb_AdodbConfig($prop);
    }

    private $properties;

    /**
     * Constructs a new Ddth_Adodb_AdodbConfig object.
     *
     * @param Ddth_Commons_Properties
     */
    protected function __construct($prop) {
        $this->properties = $prop;
    }

    /**
     * Gets the internal properties.
     *
     * @return Ddth_Commons_Properties
     */
    protected function getProperties() {
        return $this->properties;
    }

    //    /**
    //     * Gets the password configuration setting.
    //     *
    //     * @return string
    //     */
    //    public function getPassword() {
    //        return $this->properties->getProperty(self::PROPERTY_PASSWORD);
    //    }

    /**
     * Gets the connection url configuration setting.
     *
     * @return string
     */
    public function getUrl() {
        return $this->properties->getProperty(self::PROPERTY_URL);
    }

    //    /**
    //     * Gets the user name configuration setting.
    //     *
    //     * @return string
    //     */
    //    public function getUser() {
    //        return $this->properties->getProperty(self::PROPERTY_USER);
    //    }
}
?>