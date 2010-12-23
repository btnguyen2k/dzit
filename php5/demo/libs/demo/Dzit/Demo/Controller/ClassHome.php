<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
class Dzit_Demo_Controller_Home extends Dzit_Demo_Controller_BaseController {

    const VIEW_NAME = 'home';

    public function execute($module, $action) {
        $this->populateCommonModels();
        $mav = new Dzit_ModelAndView(self::VIEW_NAME);
        $mav->setModel($this->getRootModel());
        return $mav;
    }
}
?>
