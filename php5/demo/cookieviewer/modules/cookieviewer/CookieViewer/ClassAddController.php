<?php
class CookieViewer_AddController implements Dzit_IController {

    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        if (isset($_POST['key']) && isset($_POST['value'])) {
            $key = $_POST['key'];
            $value = $_POST['value'];
        }
        setcookie($key, $value, 0, '/');
        $script = $_SERVER['SCRIPT_NAME'];
        $view = new Dzit_View_RedirectView($script);
        return new Dzit_ModelAndView($view);
    }
}