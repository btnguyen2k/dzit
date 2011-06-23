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
 * @version     $Id$
 * @since       File available since v0.1
 */

/**
 * Represents a template pack.
 *
 * This interface represents a single template pack.
 *
 * Each template pack is configured via a configuration file stored as {@link Ddth_Commons_Properties .properties format}:
 * <code>
 * # Template consists of pages, each page has a unique id.
 * # Each page.<id> property points to a physical template file on disk which is
 * # associated with the page.
 * # This file is located within the template's directory.
 * page.index=index.tpl
 * </code>
 * Note: template's configuration settings are merged with
 * {@link Ddth_Template_BaseTemplateFactory::getInstance() template factory's settings} and
 * passed to the {@link init()} function by the template factory upon
 * {@link Ddth_Template_ITemplateFactory::getTemplate() creating template objects}.
 *
 * @package    	Template
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Ddth_Template_ITemplate {

    const CONF_PAGE_FILE = 'page.{0}';
    const CONF_DISPLAY_NAME = 'displayName';
    const CONF_DESCRIPTION = 'description';
    const CONF_LOCATION = 'location';
    const CONF_PAGE_CLASS = 'pageClass';

    /**
     * Gets a template configuration setting entry.
     *
     * @param string $key
     * @return mixed
     */
    public function getConfigSetting($key);

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
     * @param string $templateName
     * @param Array $config
     * @throws Ddth_Template_TemplateException
     */
    public function init($templateName, $config);
}
?>
