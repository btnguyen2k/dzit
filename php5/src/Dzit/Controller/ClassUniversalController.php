<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Universal controller for web application.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage	Controller
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassIController.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since       File available since v0.3
 */

/**
 * Universal controller for web application.
 *
 * This controller maps one action to one class member function. By default, the function
 * name is "do".ucfirst($action).
 * Note: the "do" prefix is configurable!
 *
 * @package     Dzit
 * @subpackage	Controller
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.3
 */
class Dzit_Controller_UniversalController implements Dzit_IController {

    const FUNCTION_PREFIX = 'do';

    private $module, $action;
    private $actionFuncPrefix = self::FUNCTION_PREFIX;

    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $this->module = $module;
        $this->action = $action;
        $actionFunction = $this->getActionFunction();
        if (method_exists($this, $actionFunction)) {
            return $this->actionFuncPrefix();
        }
        $msg = "Action function $actionFunction does not exist!";
        throw new Dzit_Exception($msg);
    }

    /**
     * Gets the current action.
     *
     * @return string
     */
    protected function getAction() {
        return $this->action;
    }

    /**
     * Gets the current module.
     *
     * @return string
     */
    protected function getModule() {
        return $this->module;
    }

    /**
     * Gets the action function name.
     *
     * @return string
     */
    protected function getActionFunction() {
        $prefix = $this->getActionFunctionPrefix();
        $action = $this->getAction();
        return ($prefix != NULL && $prefix != '') ? $prefix . ucfirst($action) : $action;
    }

    /**
     * Gets the action function prefix.
     *
     * @return string
     */
    protected function getActionFunctionPrefix() {
        return $this->actionFuncPrefix;
    }

    /**
     * Sets the action function prefix.
     *
     * @param string $prefix
     */
    public function setActionFunctionPrefix($prefix) {
        $this->actionFuncPrefix = $prefix;
    }
}
