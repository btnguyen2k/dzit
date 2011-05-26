<?php
class PwdEncrypt_ChangeLanguageController implements Dzit_IController {

    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $langName = isset($_GET['l']) ? $_GET['l'] : '';
        setcookie('lang', $langName);
        //$_COOKIE['lang'] = $langName;
        $script = $_SERVER['SCRIPT_NAME'];
        $view = new Dzit_View_RedirectView($script);
        return new Dzit_ModelAndView($view);
    }
}