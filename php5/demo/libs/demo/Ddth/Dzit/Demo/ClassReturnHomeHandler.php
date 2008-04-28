<?php
class Ddth_Dzit_Demo_ReturnHomeHandler implements Ddth_Dzit_IActionHandler {    
    /**
     * {@see Ddth_Dzit_IActionHandler::execute()}
     */
    public function execute() {
        echo __CLASS__;
        return NULL;    
    }
}
?>
