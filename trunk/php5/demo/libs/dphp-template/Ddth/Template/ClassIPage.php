<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Represents a template page.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassIPage.php 227 2010-12-05 06:57:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Represents a template page.
 *
 * This interface represents a single template page.
 *
 * @package    	Template
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Ddth_Template_IPage {
    /**
     * Gets the template file associated with this page.
     *
     * @return string
     */
    public function getTemplateFile();

    /**
     * Sets the data model for this page.
     *
     * @param mixed $model
     */
    public function setModel($model);

    /**
     * Renders the page.
     *
     * @param mixed $model
     * @throws Ddth_Template_TemplateException
     */
    public function render($model=NULL);
}
?>
