<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Abstract template pack.
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
 * Abstract template pack.
 *
 * @package    	Template
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
abstract class Ddth_Template_AbstractTemplate implements Ddth_Template_ITemplate {

    /**
     * @var Array
     */
    private $config = Array();

    /**
     * @var string
     */
    private $templateName = NULL;

    /**
     * @var string
     */
    private $displayName = NULL;

    /**
     * @var string
     */
    private $description = NULL;

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * Constructs a new Ddth_Template_AbstractTemplate object.
     */
    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
    }

    /**
     * Gets the configuration array.
     *
     * @return Array
     */
    protected function getConfig() {
        return $this->config;
    }

    /**
     * Sets the configuration array.
     *
     * @param Array $config
     */
    protected function setConfig($config) {
        $this->config = $config;
    }

    /**
     * @see Ddth_Template_ITemplate::getConfigSetting()
     */
    public function getConfigSetting($key) {
        return isset($this->config[$key]) ? $this->config[$key] : NULL;
    }

    /**
     * @see Ddth_Template_ITemplate::getDescription()
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets the template pack's description.
     *
     * @param string $description
     */
    protected function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @see Ddth_Template_ITemplate::getDisplayName()
     */
    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * Sets the template pack's display name.
     *
     * @param string $displayName
     */
    protected function setDisplayName($displayName) {
        $this->displayName = $displayName;
    }

    /**
     * @see Ddth_Template_ITemplate::getName()
     */
    public function getName() {
        return $this->templateName;
    }

    /**
     * Sets the template pack's name.
     *
     * @param string $name
     */
    protected function setName($name) {
        $this->templateName = $name;
    }

    /**
     * Gets character encoding setting.
     *
     * @return string
     */
    protected function getCharset() {
        return isset($this->config[self::CONF_CHARSET]) ? $this->config[self::CONF_CHARSET] : NULL;
    }

    /**
     * {@see Ddth_Template_ITemplate::getDir()}.
     */
    public function getDir() {
        return isset($this->config[self::CONF_LOCATION]) ? $this->config[self::CONF_LOCATION] : NULL;
    }

    /**
     * Gets physical template filename for a page.
     *
     * @param string $pageId
     * @return string
     */
    protected function getPageTemplateFile($pageId) {
        $key = str_replace('{0}', $pageId, self::CONF_PAGE_FILE);
        return isset($this->config[$key]) ? $this->config[$key] : NULL;
    }

    /**
     * Gets name of class to create the page instance.
     *
     * @return string
     */
    protected function getPageClass() {
        return isset($this->config[self::CONF_PAGE_CLASS]) ? $this->config[self::CONF_PAGE_CLASS] : NULL;
    }

    /**
     * @see Ddth_Template_ITemplate::getPage()
     */
    public function getPage($pageId) {
        $pageTemplateFile = $this->getPageTemplateFile($pageId);
        if ($pageTemplateFile !== NULL) {
            $pageClass = $this->getPageClass();
            if ($pageClass !== NULL) {
                $page = new $pageClass();
                if ($page instanceof Ddth_Template_IPage) {
                    $page->init($pageId, $pageTemplateFile, $this);
                    return $page;
                } else {
                    $msg = "[$pageClass] does not implement [Ddth_Template_IPage]!";
                    $this->LOGGER->error($msg);
                }
            } else {
                $msg = "There is no specified class for page instances!";
                $this->LOGGER->error($msg);
            }
        } else {
            $msg = "Page [$pageId] not found!";
            $this->LOGGER->warn($msg);
        }
        return NULL;
    }

    /**
     * {@see Ddth_Template_ITemplate::init()}
     */
    public function init($templateName, $config) {
        $this->setName($templateName);
        $this->config = $config;
        $this->setDisplayName(isset($config[self::CONF_DISPLAY_NAME]) ? $config[self::CONF_DISPLAY_NAME] : NULL);
        $this->setDescription(isset($config[self::CONF_DESCRIPTION]) ? $config[self::CONF_DESCRIPTION] : NULL);
    }
}
?>
