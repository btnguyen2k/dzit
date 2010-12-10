<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
class Dzit_Demo_Controller_Home implements Dzit_IController {
    
    const VIEW_NAME = 'home';
    
    public function execute($module, $action) {
        $mav = new Dzit_ModelAndView(self::VIEW_NAME);
        return $mav;
    }
}
?>
