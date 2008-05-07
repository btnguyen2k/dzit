<?php
class Ddth_Dzit_Demo_IndexHandler extends Ddth_Dzit_ActionHandler_AbstractActionHandler {

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        return new Ddth_Dzit_ControlForward_ViewControlForward($this->getAction());
    }
}
?>
