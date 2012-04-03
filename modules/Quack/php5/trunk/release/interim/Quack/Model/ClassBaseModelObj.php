<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Base Model Object.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package Quack
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version $Id: ClassICache.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since File available since v0.1
 */

/**
 * Base Model Object.
 *
 * @package Quack
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Quack_Model_BaseModelObj {

    private $obj = NULL;

    /**
     * Construts a new {@link Quack_Model_BaseModelObj} object.
     *
     * @param moxed $obj
     */
    public function __construct($obj) {
        $this->setTargetObject($obj);
    }

    public function __get($name) {
        $methodName = 'get' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->{$methodName}();
        }
        if (method_exists($this->obj, $methodName)) {
            return $this->obj->{$methodName}();
        }
        $trace = debug_backtrace();
        trigger_error('Undefined property via __get(): ' . $name . ' in ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'], E_USER_ERROR);
        return NULL;
    }

    public function __call($name, $arguments) {
        if (substr($name, 0, 3) == 'get') {
            return $this->obj->{$name}($arguments);
        }
        throw new RuntimeException("Can not invoke method [$name] on this object!");
    }

    protected function getTargetObject() {
        return $this->obj;
    }

    protected function setTargetObject($obj) {
        $this->obj = $obj;
    }
}
