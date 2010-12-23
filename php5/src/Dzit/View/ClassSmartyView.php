<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * MVC View for Smarty-based template.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.2
 */

/**
 * MVC View for Smarty-based template.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Dzit_View_SmartyView extends Dzit_View_AbstractView {
    /**
     * @var Ddth_Template_IPage
     */
    private $page;

    public function __construct($page) {
        $this->page = $page;
    }

    /**
     * Gets the associated page.
     *
     * @return Ddth_Template_IPage
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * @see Dzit_IView::render();
     */
    public function render($model, $module, $action) {
        $this->page->render($model);
    }
}
?>
