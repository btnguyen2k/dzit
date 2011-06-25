<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * MVC Controller for a web application.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.2
 */

/**
 * MVC Controller for a web application.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.2
 */
interface Dzit_IController {
    /**
     * Handles the action and returns a Dzit_ModelAndView object.
     *
     * @param string $module
     * @param string $action
     * @return Dzit_ModelAndView
     */
    public function execute($module, $action);
}
