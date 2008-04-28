<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * An abstract implementation of IActionHandler.
 *
 * LICENSE: This source file is subject to version 3.0 of the GNU Lesser General
 * Public License that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/lgpl.html. If you did not receive a copy of
 * the GNU Lesser General Public License and are unable to obtain it through the web,
 * please send a note to gnu@gnu.org, or send an email to any of the file's authors
 * so we can email you a copy.
 *
 * @package		Dzit
 * @subpackage  ActionHandler
 * @author		NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html LGPL 3.0
 * @id			$Id$
 * @since      	File available since v0.1
 */

/**
 * Abstract implementation of IActionHandler.
 *
 * @package    	Dzit
 * @subpackage  ActionHandler
 * @author     	NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version    	0.1
 * @since      	Class available since v0.1
 */
abstract class Ddth_Dzit_ActionHandler_AbstractActionHandler implements Ddth_Dzit_IActionHandler {

    /**
     * @var Array()
     */
    private $dataModel = Array();

    /**
     * Gets the currently running application.
     *
     * @return Ddth_Dzit_IApplication
     */
    protected function getApplication() {
        return Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
    }

    /**
     * Gets an application-level attribute.
     *
     * @param string
     * @return mixed
     */
    protected function getAppAttribute($name) {
        return $this->getApplication()->getAttribute($name);
    }

    /**
     * sets an application-level attribute.
     *
     * @param string
     * @param mixed
     */
    protected function setAppAttribute($name, $value) {
        $this->getApplication()->setAttribute($name, $value);
    }

    /**
     * Gets language pack.
     *
     * @return Ddth_Mls_ILanguage
     */
    protected function getLanguage() {
        return $this->getApplication()->getLanguage();
    }

    /**
     * Gets collection of root data models
     *
     * @return Array()
     */
    public function getRootDataModels() {
        $dataModel = $this->getAppAttribute(Ddth_Dzit_DzitConstants::APP_ATTR_ROOT_DATA_MODELS);
        if ( is_array($dataModel) ) {
            $dataModel = Array();
            $this->setAppAttribute(self::APP_ATTR_ROOT_DATA_MODELS, $dataModel);
        }
        return $dataModel;
    }

    /**
     * Populates page's data models.
     * 
     * @throws Ddth_Dzit_DzitException
     */
    protected function populateDataModels() {
    }
}
?>