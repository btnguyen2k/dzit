<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Abstract implementation of IApplication.
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
 * Abstract implementation of IApplication.
 * 
 * @package    	Dzit
 * @author     	NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version    	0.1
 * @since      	Class available since v0.1 
 */
abstract class Ddth_Dzit_AbstractApplication implements Ddth_Dzit_IApplication {
    
    private $LOGGER;
    
    /**
     * Constructs a new Ddth_Dzit_AbstractApplication object.
     */
    public function __construct() {
        $clazz = 'Ddth_Dzit_AbstractApplication';
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog($clazz);
    }
    
    /**
     * Clean-up method.
     * 
     * This method is called just before the application object is abandoned. 
     *
     * @throws Ddth_Dzit_DzitException
     */
    public function destroy($hasError=false);
    
    /**
     * Executes the application (serves the Http request).
     *
     * @throws Ddth_Dzit_DzitException
     */
    public function execute();
    
    /**
     * {@see Ddth_Dzit_IApplication::init()}
     */
    public function init() {
        initSession();
    }
    
    /**
     * Initializes session.
     *
     * @Throws Ddth_Dzit_DzitException
     */
    protected function initSession() {
        session_start();
    }
}
?>