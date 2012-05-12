<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Controller that redirects user to a URL or action.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package Dzit
 * @subpackage Controller
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version $Id: ClassIController.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since File available since v0.3
 */

/**
 * Controller that redirects user to a URL or action.
 *
 * @package Dzit
 * @subpackage Controller
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.3
 */
class Dzit_Controller_RedirectController implements Dzit_IController {

    /**
     * The URL to redirect to. By default, this is the URL to redirect to.
     *
     * @var string
     */
    private $url;

    /**
     * Constructs a new {@link Dzit_Controller_RedirectController} object.
     *
     * @param string $url
     */
    public function __construct($url) {
        $this->url = $url;
    }

    /**
     * Get the url to redirect to.
     * @return string
     */
    protected function getUrl() {
        return $this->url;
    }

    /**
     *
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $view = new Dzit_View_RedirectView($this->url);
        return new Dzit_ModelAndView(view, null);
    }
}
