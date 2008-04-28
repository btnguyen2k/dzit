<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Application declaration.
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
 * Application declaration.
 *
 * Each HTTP request will be handled by an instance of application.
 *
 * @package    	Dzit
 * @author     	NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version    	0.1
 * @since      	Class available since v0.1
 */
interface Ddth_Dzit_IApplication {
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
     * Initializing the application.
     *
     * This method is called just after the application instance is created.
     *
     * @param Ddth_Dzit_Configurations
     * @throws Ddth_Dzit_DzitException
     */
    public function init($config);

    /**
     * Gets an application-level attribute.
     *
     * @param string
     * @return mixed
     */
    public function getAttribute($name);

    /**
     * Sets an application-level attribute.
     *
     * @param string
     * @param mixed
     */
    public function setAttribute($name, $value);

    /**
     * Open an ADOdb connection.
     *
     * @return ADOConnection
     */
    public function getAdodbConnection();

    /**
     * Gets the current action handler.
     *
     * @return Ddth_Dzit_IActionHandler
     */
    public function getCurrentActionHandler();

    /**
     * Gets a HTTP request wrapper.
     *
     * @return Ddth_Dzit_IHttpRequest
     */
    public function getHttpRequest();

    /**
     * Gets a specified language pack.
     *
     * @param string
     * @return Ddth_Mls_ILanguage
     */
    public function getLanguage($name=NULL);

    /**
     * Gets a specified template pack.
     *
     * @param string
     * @return Ddth_Template_ITemplate
     */
    public function getTemplate($name=NULL);

    /**
     * Gets an URL creator instance.
     *
     * @return Ddth_Dzit_IUrlCreator
     */
    public function getUrlCreator();
}
?>