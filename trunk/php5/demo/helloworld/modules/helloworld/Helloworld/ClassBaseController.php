<?php
class Helloworld_BaseController implements Dzit_IController {

    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $this->displayMenu();
    }

    /**
     * Displays a menu bar.
     */
    protected function displayMenu() {
        $script = $_SERVER['SCRIPT_NAME'];
        echo "Menu: ";
        echo "[<a href='$script'>Home</a>] | ";
        echo "[<a href='$script/about'>About Us</a>] | ";
        echo "[<a href='$script/contact'>Contact</a>] | ";
        echo "[<a href='$script/dummy'>Dummy</a>]";
        echo "<br />";
    }
}