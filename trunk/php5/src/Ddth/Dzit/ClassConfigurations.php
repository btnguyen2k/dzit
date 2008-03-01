<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Encapsulates Dzit's start up configurations.
 *
 * LICENSE: This source file is subject to version 3.0 of the GNU Lesser General
 * Public License that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/lgpl.html. If you did not receive a copy of
 * the GNU Lesser General Public License and are unable to obtain it through the web,
 * please send a note to gnu@gnu.org, or send an email to any of the file's authors
 * so we can email you a copy.
 *
 * @package		Dzit
 * @author		NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html LGPL 3.0
 * @id			$Id$
 * @since      	File available since v0.1
 */

/**
 * Encapsulates Dzit's start up configurations.
 * 
 * @package    	Dzit
 * @author     	NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version    	0.1
 * @since      	Class available since v0.1 
 */
class Ddth_Dzit_Configurations {
    
    const DEFAULT_APPLICATION_CLASS = 'Ddth_Dzit_GenericApplication';
    
    const PROPERTY_APPLICATION_CLASS = 'dzit.application.class';
    
    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;
    
    /**
     * @var Ddth_Commons_Properties
     */
    private $settings;
    
    /**
     * Constructs a new Ddth_Dzit_Configurations object
     *
     * @param string
     */
    public function __constructs($configFile) {
        $clazz = 'Ddth_Dzit_Configurations';
        $this->LOGGER = Ddth_Commons_Loggings_LogFactory::getLog($clazz);
        $this->settings = new Ddth_Commons_Properties();
        try {
            $this->settings->load($configFile);
        } catch ( Exception $e ) {
            $msg = $e->getMessage();
            $this->LOGGER->error($msg, $e);
        }
    }

    /**
     * Gets application class name setting.
     *
     * @return string
     */
    public function getApplicationClass() {
        $key = self::PROPERTY_APPLICATION_CLASS;
        return $this->getSetting($key, self::DEFAULT_APPLICATION_CLASS);
    }
    
    /**
     * Gets the internal settings object.
     *
     * @return Ddth_Commons_Properties
     */
    protected function getSettings() {
        return $this->settings;
    }
    
    /**
     * Gets a single setting.
     *
     * @param string
     * @return string
     */
    protected function getSetting($key, $defaultValue=NULL) {
        return $this->settings->getProperty($key, $defaultValue);
    }
}
?>