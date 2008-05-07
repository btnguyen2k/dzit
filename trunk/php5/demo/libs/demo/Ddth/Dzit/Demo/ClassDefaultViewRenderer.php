<?php
class Ddth_Dzit_Demo_DefaultViewRenderer extends Ddth_Dzit_ViewRenderer_GenericViewRenderer {
    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * Constructs a new Ddth_Dzit_Demo_DefaultViewRenderer object.
     */
    public function __construct() {
        $clazz = __CLASS__;
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog($clazz);
        parent::__construct();
    }
}
?>