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

    protected function getTargetObject() {
        return $this->obj;
    }

    protected function setTargetObject($obj) {
        $this->obj = $obj;
    }
}
