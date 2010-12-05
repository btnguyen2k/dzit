<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory interface to create template pack objects.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassITemplateFactory.php 227 2010-12-05 06:57:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Factory interface to create template pack objects.
 *
 * @package     Template
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Ddth_Template_ITemplateFactory {            
    
    /**
     * Gets a template pack.
     * 
     * @param string
     * @return Ddth_Template_ITemplate
     * @throws Ddth_Template_TemplateException
     */
    public function getTemplate($name);
    
    /**
     * Gets list of names of available templates.
     * 
     * @return Array()
     */
    public function getTemplateNames();
    
    /**
     * Initializes the factory.
     * 
     * @param Dddth_Commons_Properties
     * @throws Ddth_Template_TemplateException
     */
    public function init($settings);
}
?>
