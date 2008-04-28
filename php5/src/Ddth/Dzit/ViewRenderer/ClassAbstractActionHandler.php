<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * An abstract implementation of IViewRenderer.
 *
 * LICENSE: This source file is subject to version 3.0 of the GNU Lesser General
 * Public License that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/lgpl.html. If you did not receive a copy of
 * the GNU Lesser General Public License and are unable to obtain it through the web,
 * please send a note to gnu@gnu.org, or send an email to any of the file's authors
 * so we can email you a copy.
 *
 * @package		Dzit
 * @subpackage  ViewRenderer
 * @author		NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html LGPL 3.0
 * @id			$Id$
 * @since      	File available since v0.1
 */

/**
 * Abstract implementation of IViewRenderer.
 *
 * @package    	Dzit
 * @subpackage  ViewRenderer
 * @author     	NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version    	0.1
 * @since      	Class available since v0.1
 */
abstract class Ddth_Dzit_ViewRenderer_AbstractViewRenderer implements Ddth_Dzit_IViewRenderer {

    /**
     * Constructs a new Ddth_Dzit_ViewRenderer_AbstractViewRenderer object.
     */
    public function __construct() {
        //empty
    }

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
     * Gets collection of root data models
     *
     * @return Array()
     */
    protected function getRootDataModels() {
        $rootDataModels = $this->getAppAttribute(Ddth_Dzit_DzitConstants::APP_ATTR_ROOT_DATA_MODELS);
        //assuming its type is already correct (an associative array)
        return $rootDataModels;
    }
}
?>