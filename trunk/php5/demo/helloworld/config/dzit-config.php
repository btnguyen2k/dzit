<?php
defined('DZIT_INCLUDE_KEY') || die('No direct access allowed!');
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Dzit's core configuration file.
 */

/*
 * If environment variable DEV_ENV exists then we are on development server.
 */
define('IN_DEV_ENV', isset($_ENV['DEV_ENV']));

/*
 * If CLI_MODE is TRUE, the application is running in CLI (command line interface) mode.
 */
define('CLI_MODE', strtolower(php_sapi_name()) == 'cli' && empty($_SERVER['REMOTE_ADDR']));

/*
 * Since PHP 5.3, you should not rely on the default time zone setting any more!
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');

/*
 * Configurations for Ddth::Commons::Logging
 */
global $DPHP_COMMONS_LOGGING_CONFIG;
$DPHP_COMMONS_LOGGING_CONFIG = Array(
        'ddth.commons.logging.Logger' => 'Ddth_Commons_Logging_SimpleLog',
        'logger.setting.default' => IN_DEV_ENV ? 'DEBUG' : 'WARN');

/*
 * Configurations for Ddth::Dao
 */
/*
 * NOTE: CONFIGURE YOUR OWN DAO HERE!
 */
global $DPHP_DAO_CONFIG;
$DPHP_DAO_CONFIG = Array('ddth-dao.factoryClass' => 'Ddth_Dao_Adodb_BaseAdodbDaoFactory',
        'dao.simpleBlog' => 'Dzit_Demo_Bo_MysqlSimpleBlogDao');

/*
 * Configurations for Ddth::Adodb
 */
/*
 * NOTE: IF YOU USE AODB, CONFIGURE IT HERE.
 */
global $DPHP_ADODB_CONFIG;
$DPHP_ADODB_CONFIG = Array('adodb.url' => 'mysql://vcs:vcs@localhost/vcs',
        'adodb.setupSqls' => Array("SET NAMES 'utf8'"));

/*
 * Configurations for Ddth::Mls
 */
/*
 * NOTE: CONFIGURATE YOUR LANGUAGE SETTINGS HERE!
 */
global $DPHP_MLS_CONFIG;
$DPHP_MLS_CONFIG = Array('factory.class' => 'Ddth_Mls_BaseLanguageFactory',
        'languages' => 'vn, en',
        'language.baseDirectory' => '../config/languages',
        'language.class' => 'Ddth_Mls_FileLanguage',
        'language.vn.location' => 'vi_vn',
        'language.vn.displayName' => 'Tiếng Việt',
        'language.vn.locale' => 'vi_VN',
        'language.vn.description' => 'Ngôn ngữ tiếng Việt',
        'language.en.location' => 'en_us',
        'language.en.displayName' => 'English',
        'language.en.locale' => 'en_US',
        'language.en.description' => 'English (US) language pack');

/*
 * Configurations for Ddth::Template
 */
/*
 * NOTE: CONFIGURATE YOUR WEB-TEMPLATE SETTINGS HERE!
 */
global $DPHP_TEMPLATE_CONFIG;
$DPHP_TEMPLATE_CONFIG = Array('factory.class' => 'Ddth_Template_BaseTemplateFactory',
        'templates' => 'default',
        'template.baseDirectory' => './skins',
        'template.default.class' => 'Ddth_Template_Php_PhpTemplate',
        'template.default.pageClass' => 'Ddth_Template_Php_PhpPage',
        'template.default.location' => 'default',
        'template.default.charset' => 'utf-8',
        'template.default.configFile' => 'config.properties',
        'template.default.displayName' => 'Default',
        'template.default.description' => 'Default template pack');

/*
 * Action dispatcher configuration: the default dispatcher should work out-of-the-box.
 *
 * Dispatcher is responsible for:
 * <ul>
 *     <li>Routing the request {module:action} to the corresponding controller.</li>
 *     <li>Rendering the view.</li>
 * </ul>
 */
$dispatcherClass = 'Dzit_DefaultDispatcher';
Dzit_Config::set(Dzit_Config::CONF_DISPATCHER, new $dispatcherClass());

/*
 * Router configurations.
 *
 * Router information is {key:value} based, as the following:
 * <code>
 * {
 *     'module1' => ControllerInstance1,
 *     'module2' => 'ControllerClassName2',
 *     'module3' =>
 *     {
 *         'action1' => ControllerInstance3,
 *         'action2' => 'ControllerClassName4'
 *     }
 * }
 * </code>
 */
/*
 * NOTE: CONFIGURATE YOUR ROUTINGS HERE!
 */
$router = Array('*' => 'Helloworld_DefaultController',
        'about' => 'Helloworld_AboutController',
        'contact' => 'Helloworld_ContactController');
Dzit_Config::set(Dzit_Config::CONF_ROUTER, $router);

/*
 * Action handler mapping configuration: the default action handler mapping should work
 * out-of-the-box. It follows the convensions of the above router configurations.
 *
 * Action handler mapping is responsible for obtaining a controller instance
 * (type {@link Dzit_IController}) for a request {module:action}.
 */
$actionHandlerMappingClass = 'Dzit_DefaultActionHandlerMapping';
Dzit_Config::set(Dzit_Config::CONF_ACTION_HANDLER_MAPPING, new $actionHandlerMappingClass($router));

/*
 * View resolver configuration.
 *
 * View resolver is responsible for resolving a {@link Dzit_IView} from name (string).
 *
 * Built-in view resolvers:
 * <ul>
 *     <li>{@link Dzit_View_PhpViewResolver}: use this view resolver if the application use a single PHP-based template.</li>
 * </ul>
 */
$viewResolverClass = 'Dzit_View_PhpViewResolver';
Dzit_Config::set(Dzit_Config::CONF_VIEW_RESOLVER, new $viewResolverClass('skins/default/page_'));

/*
 * Name of the default language pack.
 */
Dzit_Config::set(Dzit_Config::CONF_DEFAULT_LANGUAGE_NAME, 'default');

/*
 * Name of the default template pack.
 */
Dzit_Config::set(Dzit_Config::CONF_DEFAULT_TEMPLATE_NAME, 'default');

/*
 * Name of the module's bootstrap file.
 */
define('MODULE_BOOTSTRAP_FILE', 'bootstrap.php');
