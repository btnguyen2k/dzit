<?php
abstract class SessionViewer_BaseController implements Dzit_IController {

    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $model = Array();
        foreach ($_SESSION as $key => $value) {
            $model[$key] = $value;
        }
        return new Dzit_ModelAndView($this->getViewName(), $model);
    }

    protected abstract function getViewName();
}