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
 * @version     $Id: ClassIPage.php 260 2011-01-04 04:10:06Z btnguyen2k@gmail.com $
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
     * Gets the page's id
     *
     * @return string
     */
    public function getId();

    /**
     * Gets the template file associated with this page.
     *
     * @return string
     */
    public function getTemplateFile();

    /**
     * Gets the template object that is the owner of the page.
     *
     * @return Ddth_Template_ITemplate
     */
    public function getTemplate();

    /**
     * Gets a configuration setting entry from the associated template.
     *
     * @param string $key
     * @return mixed
     */
    public function getTemplateConfigSetting($key);

    /**
     * Gets the data model of this page.
     *
     * @return mixed
     */
    public function getModel();

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
    public function render($model = NULL);

    /**
     * Initializes the page.
     *
     * @param string $id page id
     * @param string $templateFile name of the template file associated with the page
     * @param string $template the template object that is the owner of the page
     */
    public function init($id, $templateFile, $template);
}
?>
