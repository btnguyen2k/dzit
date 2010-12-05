<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Represents a template pack.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassITemplate.php 227 2010-12-05 06:57:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Represents a template pack.
 *
 * This interface represents a single template pack.
 * 
 * Each template pack is configured via a configuration file stored as .properties format:
 * <code>
 * # Character encoding used by this template pack
 * charset=utf-8
 * 
 * # Template consists of pages, each page has a unique id.
 * # Each page.<id> property points to a physical template file on disk which is
 * # associated with the page.
 * # This file is located within the template's directory.
 * page.index=index.tpl
 * </code>
 *
 * @package    	Template
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Ddth_Template_ITemplate {
    
    const PROPERTY_PREFIX_PAGE = "page.";
    
    const PROPERTY_PAGE = "page.{0}";
    
    const PROPERTY_CHARSET = "charset";
    
//    /**
//     * Gets absolute path of the directory where the template pack is located.
//     * 
//     * @return string
//     */
//    public function getAbsoluteDir();
    
    /**
     * Gets description of the template pack.
     *
     * @return string
     */
    public function getDescription();
    
    /**
     * Gets name of the directory where the template pack is located.
     * 
     * @return string
     */
    public function getDir();
    
    /**
     * Gets display name of the template pack.
     *
     * @return string
     */
    public function getDisplayName();
    
    /**
     * Gets name of the template pack.
     *
     * @return string
     */
    public function getName();

    /**
     * Retrieves a page.
     * 
     * @param string
     * @return Ddth_Template_IPage
     * @throws Ddth_Template_TemplateException
     */
    public function getPage($pageId);
    
    /**
     * Initializes the template pack.
     *
     * @param Dddth_Commons_Properties
     * @throws Ddth_Template_TemplateException
     */
    public function init($settings);
    
    /**
     * Gets a template's setting property.
     * 
     * @param string
     * @return string
     */
    public function getSetting($key);
}
?>
