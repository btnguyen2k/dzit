<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Encapsulates the model and view objects.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassConfigurations.php 30 2010-11-21 16:08:30Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

/**
 * Encapsulates the model and view objects.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Dzit_ModelAndView {

    private $model = NULL;

    private $view = NULL;

    /**
     * Constructs a new Dzit_ModelAndView object.
     */
    private function __construct($model=NULL, $view=NULL) {
        $this->model = $model;
        $this->view = $view;
    }

    /**
     * Gets the model.
     *
     * @return mixed
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * Sets the model.
     *
     * @param mixed $model
     */
    public function setModel($model) {
        $this->model = $model;
    }

    /**
     * Gets the view.
     *
     * @return mixed
     */
    public function getView() {
        return $this->view;
    }

    /**
     * Sets the view.
     *
     * @param mixed $view
     */
    public function setView($view) {
        $this->view = $view;
    }
}
?>
