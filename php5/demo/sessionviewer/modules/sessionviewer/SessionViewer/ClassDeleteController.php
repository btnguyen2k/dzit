<?php
class SessionViewer_DeleteController implements Dzit_IController {

    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        if (isset($_GET['key'])) {
            $key = $_GET['key'];
            if (isset($_SESSION[$key])) {
                unset($_SESSION[$key]);
            }
        }
        $script = $_SERVER['SCRIPT_NAME'];
        $view = new Dzit_View_RedirectView($script);
        return new Dzit_ModelAndView($view);
    }
}