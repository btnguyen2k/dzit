<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * An implementation of {@link Ddth_Template_ITemplateFactory}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassBaseTemplateFactory.php 260 2011-01-04 04:10:06Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * An implementation of {@link Ddth_Template_ITemplateFactory}. This can be used as the base class
 * to develop custom template factory class.
 *
 * This class provides a {@link getInstance() static function} to get instance of
 * {@link Ddth_Template_ITemplateFactory}. The static function takes an array as parameter.
 * See {@link getInstance()} for details of the configuration array.
 *
 * Usage:
 * <code>
 * $templateFactory = Ddth_Template_BaseTemplateFactory::getInstance();
 * $template = $templateFactory->getTemplate($templateName);
 * $page = $template->getPage('about');
 * $page->render($model);
 * </code>
 *
 * @package    	Template
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Template_BaseTemplateFactory implements Ddth_Template_ITemplateFactory {

    private static $cacheInstances = Array();

    const CONF_PREFIX = 'template.';

    const CONF_FACTORY_CLASS = 'factory.class';
    const CONF_TEMPLATES = 'templates';
    const CONF_BASE_DIRECTORY = 'template.baseDirectory';
    const CONF_TEMPLATE_CLASS = 'template.{0}.class';
    const CONF_TEMPLATE_LOCATION = 'template.{0}.location';
    const CONF_TEMPLATE_CONFIG_FILE = 'template.{0}.configFile';

    const DEFAULT_FACTORY_CLASS = 'Ddth_Template_BaseTemplateFactory';

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * @var Array
     */
    private $config = Array();

    /**
     * List of declared template names (index array).
     *
     * @var Array
     */
    private $templateNames = NULL;

    /**
     * Registered template packs (associative array {templateName => templateObject}).
     *
     * @var Array
     */
    private $templatePacks = NULL;

    /**
     * @var string
     */
    private $baseDir = NULL;

    /**
     * Static function to get instances of {@link Ddth_Template_ITemplateFactory}.
     *
     * This function accepts an associative array as parameter. If the argument is NULL,
     * the global variable $DPHP_TEMPLATE_CONFIG is used instead (if there is no global variable
     * $DPHP_TEMPLATE_CONFIG, the function falls back to use the global variable $DPHP_TEMPLATE_CONF).
     *
     * Detailed specs of the configuration array:
     * <code>
     * Array(
     * # Class name of the concrete factory.
     * # Default value is Ddth_Template_BaseTemplateFactory.
     * 'factory.class' => 'Ddth_Template_BaseTemplateFactory',
     *
     * # Names of registered template packs, separated by (,) or (;) or spaces.
     * # Template name should contain only lower-cased letters (a-z), digits (0-9)
     * # and underscores (_) only!
     * 'templates' => 'default, fancy',
     *
     * # Points to the root directory where all template packs are located.
     * 'template.baseDirectory' => '/path/to/templates/directory',
     *
     * # Configuration settings for each template pack. Each configuration
     * # setting follows the format:
     * 'template.<name>.<key>' => <value>,
     * # Note: <name> is the template name
     * # Note: all those configuration settings will be passed to the template
     * # pack Ddth_Template_ITemplate::init() function. Before being passed to
     * # the function, the "template.<name>." will be removed from the key.
     * # Which means, the passed array will contain elements such as {'<key>' => <value>}
     *
     * # Several important template settings:
     *
     * # - Class name of the template pack (required): must extend either
     * #   Ddth_Template_Php_PhpTemplate or Ddth_Template_Smarty_SmartyTemplate
     * 'template.fancy.class'       => 'Ddth_Template_Php_PhpTemplate',
     *
     * # - Class name of template's page object (optional)
     * 'template.fancy.pageClass'   => 'Ddth_Template_Php_PhpPage',
     *
     * # If template is Smarty-based, there are several important settings for Smarty:
     * # - Name of the directory to store Smarty's cache files (located under template.<name>.location)
     * 'template.fancy.smarty.cache'   => 'cache',
     * # - Name of the directory to store Smarty's compiled template files (located under template.<name>.location)
     * 'template.fancy.smarty.compile' => 'templates_c',
     * # - Name of the directory to store Smarty's configuration files (located under template.<name>.location)
     * 'template.fancy.smarty.configs' => 'configs',
     *
     * # - Location (required, points to a sub-directory, relative to the template.baseDirectory) where
     * #   where files of this template pack are located:
     * 'template.fancy.location'    => 'fancy',
     *
     * # - Character encoding (default is 'utf-8') used by this template pack
     * 'template.fancy.charset'     => 'utf-8',
     *
     * # - Name of the configuration file (required, {@link Ddth_Commons_Properties .properties format})
     * 'template.fancy.configFile'  => 'config.properties',
     *
     * # - Display name of the template pack (optional):
     * 'template.fancy.displayName' => 'Fancy',
     *
     * # - Description of the template pack (optional):
     * 'template.fancy.description' => 'Fancy template pack',
     * );
     * </code>
     *
     * @param Array $config
     * @return Ddth_Template_ITemplateFactory
     * @throws Ddth_Template_TemplateException
     */
    public static function getInstance($config = NULL) {
        if ($config === NULL) {
            global $DPHP_TEMPLATE_CONFIG;
            $config = isset($DPHP_TEMPLATE_CONFIG) ? $DPHP_TEMPLATE_CONFIG : NULL;
        }
        if ($config === NULL) {
            global $DPHP_TEMPLATE_CONF;
            $config = isset($DPHP_TEMPLATE_CONF) ? $DPHP_TEMPLATE_CONF : NULL;
        }
        if ($config === NULL) {
            global $DPHP_TEMPLATE_CFG;
            $config = isset($DPHP_TEMPLATE_CFG) ? $DPHP_TEMPLATE_CFG : NULL;
        }
        if ($config === NULL) {
            return NULL;
        }
        $hash = md5(serialize($config));
        if (!isset(self::$cacheInstances[$hash])) {
            $factoryClass = isset($config[self::CONF_FACTORY_CLASS]) ? $config[self::CONF_FACTORY_CLASS] : NULL;
            if ($factoryClass === NULL || trim($factoryClass) === "") {
                $factoryClass = self::DEFAULT_FACTORY_CLASS;
            } else {
                $factoryClass = trim($factoryClass);
            }
            try {
                $instance = new $factoryClass();
                if ($instance instanceof Ddth_Template_ITemplateFactory) {
                    $instance->init($config);
                } else {
                    $msg = "[$factoryClass] does not implement Ddth_Template_ITemplateFactory";
                    throw new Ddth_Template_TemplateException($msg);
                }
            } catch (Ddth_Template_TemplateException $me) {
                throw $me;
            } catch (Exception $e) {
                $msg = $e->getMessage();
                throw new Ddth_Template_TemplateException($msg);
            }
            self::$cacheInstances[$hash] = $instance;
        }
        return self::$cacheInstances[$hash];
    }

    /**
     * Constructs a new Ddth_Template_BaseTemplateFactory object.
     */
    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
    }

    /**
     * Gets base directory setting.
     *
     * @return string
     */
    protected function getBaseDir() {
        return $this->baseDir;
    }

    /**
     * Sets base directory.
     *
     * @param string $baseDir
     */
    protected function setBaseDir($baseDir) {
        $this->baseDir = $baseDir;
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
     * @see Ddth_Template_ITemplateFactory::init()
     */
    public function init($config) {
        $this->setConfig($config);
        $this->initBaseDir();
        $this->registerTemplates();
    }

    /**
     * Initializes base directory.
     *
     * @throws Ddth_Template_TemplateException
     */
    protected function initBaseDir() {
        $config = $this->config;
        $baseDir = isset($config[self::CONF_BASE_DIRECTORY]) ? trim($config[self::CONF_BASE_DIRECTORY]) : NULL;
        if ($baseDir === NULL || $baseDir === "") {
            $msg = 'Can not find base directory setting!';
            $this->LOGGER->fatal($msg);
            throw new Ddth_Template_TemplateException($msg);
        }
        $baseDir = new Ddth_Commons_File($baseDir);
        if (!$baseDir->isDirectory() || !$baseDir->canRead()) {
            $msg = "[{$baseDir->getPathname()}] is not a directory or not readable!";
            $this->LOGGER->fatal($msg);
            throw new Ddth_Template_TemplateException($msg);
        }
        $this->setBaseDir($baseDir);
    }

    /**
     * Registers declared template packs.
     */
    protected function registerTemplates() {
        $this->templatePacks = Array();
        $templateNames = $this->getTemplateNames();
        foreach ($templateNames as $templateName) {
            $template = $this->createTemplatePack($templateName);
            if ($template !== NULL) {
                $this->templatePacks[$templateName] = $template;
            }
        }
    }

    /**
     * Creates a template pack object.

     * @param string $templateName name of the template pack to create
     * @return Ddth_Template_ITemplate
     */
    protected function createTemplatePack($templateName) {
        $templateClass = $this->getTemplateClassName($templateName);
        if ($templateClass === NULL) {
            $msg = 'No language class specified!';
            $this->LOGGER->error($msg);
            return NULL;
        }
        if ($this->LOGGER->isDebugEnabled()) {
            $msg = "Template class [$templateClass].";
            $this->LOGGER->debug($msg);
            $msg = "Loading template pack [$templateName]...";
            $this->LOGGER->debug($msg);
        }
        $templatePack = new $templateClass();
        if (!($templatePack instanceof Ddth_Template_ITemplate)) {
            $msg = "[$templateClass] is not an instance of Ddth_Template_ITemplate!";
            throw new Ddth_Template_TemplateException($msg);
        }
        $templatePack->init($templateName, $this->getTemplateConfig($templateName));
        return $templatePack;
    }

    /**
     * Builds/Extracts the template settings from the factory settings. See {@link getInstance()}
     * for more information.
     *
     * @param string $templateName
     * @return Array
     */
    protected function getTemplateConfig($templateName) {
        $templateNames = $this->getTemplateNames();
        $templateConfig = Array();
        //extract template configurations from factory's config object
        $prefix = self::CONF_PREFIX . $templateName . '.';
        $len = strlen($prefix);
        foreach ($this->config as $key => $value) {
            if ($prefix === substr($key, 0, $len)) {
                $key = substr($key, $len);
                if ($key !== '') {
                    $templateConfig[$key] = $value;
                }
            } else {
                $templateConfig[$key] = $value;
            }
        }
        //load template configurations from file
        $configFromFile = $this->loadTemplateConfigFile($templateName);
        //merge them
        foreach ($configFromFile as $key => $value) {
            $templateConfig[$key] = $value;
        }

        return $templateConfig;
    }

    /**
     * Gets class name of the template pack.
     *
     * This function uses the configuration {@link CONF_TEMPLATE_CLASS} to look up
     * the name of the template pack class. Sub-class may override this function to
     * provide its own behavior.
     *
     * @param string $templateName name of the template
     * @return string
     */
    protected function getTemplateClassName($templateName) {
        $confKey = str_replace('{0}', $templateName, self::CONF_TEMPLATE_CLASS);
        return isset($this->config[$confKey]) ? $this->config[$confKey] : NULL;
    }

    /**
     * Gets location setting of the template pack.
     *
     * This function uses the configuration {@link CONF_TEMPLATE_LOCATION} to look up
     * the location of the template pack. Sub-class may override this function to
     * provide its own behavior.
     *
     * @param string $templateName name of the template
     * @return string
     */
    protected function getTemplateLocation($templateName) {
        $confKey = str_replace('{0}', $templateName, self::CONF_TEMPLATE_LOCATION);
        return isset($this->config[$confKey]) ? $this->config[$confKey] : NULL;
    }

    /**
     * Gets template pack's configuration file.
     *
     * This function uses the configuration {@link CONF_TEMPLATE_CONFIG_FILE} to look up
     * the template pack's configuration file. Sub-class may override this function to
     * provide its own behavior.
     *
     * @param string $templateName name of the template
     * @return string
     */
    protected function getTemplateConfigFile($templateName) {
        $confKey = str_replace('{0}', $templateName, self::CONF_TEMPLATE_CONFIG_FILE);
        return isset($this->config[$confKey]) ? $this->config[$confKey] : NULL;
    }

    /**
     * Loads template configurations from the template pack's configuration file.
     *
     * Template pack's configuration file is a {@link Ddth_Commons_Properties .properties file}. This
     * function, however, loads the file content and returns configurations as an associative array.
     *
     * @param string $templateName
     * @return Array
     */
    protected function loadTemplateConfigFile($templateName) {
        //the template pack's configuration is:
        //template.baseDirectory/template.<name>.location>/template.<name>.configFile
        $templateConfigFile = new Ddth_Commons_File($this->getBaseDir());
        $templateConfigFile = new Ddth_Commons_File($this->getTemplateLocation($templateName), $templateConfigFile);
        $templateConfigFile = new Ddth_Commons_File($this->getTemplateConfigFile($templateName), $templateConfigFile);
        $templateConfig = new Ddth_Commons_Properties();
        $templateConfig->load($templateConfigFile->getPathname());
        return $templateConfig->toArray();
    }

    /**
     * {@see Ddth_Template_ITemplateFactory::getTemplate()}
     */
    public function getTemplate($name) {
        if ($this->templatePacks === NULL) {
            $this->registerTemplates();
        }
        if (isset($this->templatePacks[$name])) {
            return $this->templatePacks[$name];
        } else {
            $msg = "Template pack [$name] does not exist!";
            $this->LOGGER->warn($msg);
            return NULL;
        }
    }

    /**
     * {@see Ddth_Template_ITemplateFactory::getTemplateNames()}
     */
    public function getTemplateNames() {
        if ($this->templateNames === NULL) {
            $this->templateNames = Array();
            $templatePacks = isset($this->config[self::CONF_TEMPLATES]) ? $this->config[self::CONF_TEMPLATES] : '';
            $templatePacks = trim(preg_replace('/[\s,;]+/', ' ', $templatePacks));
            $tokens = preg_split('/[\s,;]+/', trim($templatePacks));
            if (count($tokens) === 0) {
                $msg = 'No template pack defined!';
                $this->LOGGER->error($msg);
            } else {
                foreach ($tokens as $templateName) {
                    if ($templateName === '') {
                        continue;
                    }
                    $this->templateNames[] = $templateName;
                }
            }
        }
        return $this->templateNames;
    }
}
?>
