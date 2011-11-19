<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Yadif-based action handler mapping.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Quack
 * @subpackage	Controller
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassICache.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Yadif-based action handler mapping.
 *
 * This class utilizes yadif (http://github.com/beberlei/yadif/)
 * to obtain the controller instance.
 *
 * @package     Quack
 * @subpackage	Controller
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Quack_Controller_YadifActionHandlerMapping extends Dzit_DefaultActionHandlerMapping {

    /**
     * @var Yadif_Container
     */
    private $yadif;

    public function __construct($router = NULL) {
        parent::__construct($router);
        global $YADIF_CONFIG;
        $this->yadif = new Yadif_Container($YADIF_CONFIG);
    }

    /**
     * @see Dzit_DefaultActionHandlerMapping::getControllerByString()
     */
    protected function getControllerByString($className) {
        return $this->yadif->getComponent($className);
    }
}
