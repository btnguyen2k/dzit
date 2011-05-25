<?php
class Helloworld_AboutController extends Helloworld_BaseController {
    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        parent::execute($module, $action);
        echo "<br />";
        echo "Myself: ", __CLASS__, ":", __FUNCTION__;
        echo "<br />";
        echo "About: this is the 'about' controller!";
    }
}
