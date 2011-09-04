<?php
defined('DZIT_INCLUDE_KEY') || die('No direct access allowed!');
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Dzit's core configuration file.
 * Note: Add/Remove/Modify your own configurations if needed!
 */

/*
 * If environment variable DEV_ENV exists then we are on development server.
 */
define('IN_DEV_ENV', getenv('DEV_ENV'));

/*
 * If CLI_MODE is TRUE, the application is running in CLI (command line interface) mode.
 */
define('CLI_MODE', strtolower(php_sapi_name()) == 'cli' && empty($_SERVER['REMOTE_ADDR']));

/*
 * Since PHP 5.3, you should not rely on the default time zone setting any more!
 * Note: See http://www.php.net/manual/en/timezones.php for list of supported timezones.
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');

/*
 * Put list of classes that should be ignored by Dzit's auto loading.
 * Note: PCRE regular expression supported (http://www.php.net/manual/en/pcre.pattern.php).
 */
global $DZIT_IGNORE_AUTOLOAD;
$DZIT_IGNORE_AUTOLOAD = Array('/^Smarty_*/');

/*
 * Configurations for Ddth::Commons::Logging
 * Note: the default logger (SimpleLog which writes log to php's system log) should
 * be sufficient for most cases. Change it if you want to use another logger.
 */
global $DPHP_COMMONS_LOGGING_CONFIG;
$DPHP_COMMONS_LOGGING_CONFIG = Array(
        'ddth.commons.logging.Logger' => 'Ddth_Commons_Logging_SimpleLog',
        'logger.setting.default' => IN_DEV_ENV ? 'DEBUG' : 'WARN');

/*
 * Configurations for Ddth::Dao
 */
global $DPHP_DAO_CONFIG;
$DPHP_DAO_CONFIG = Array('ddth-dao.factoryClass' => 'Ddth_Dao_Mysql_BaseMysqlDaoFactory',
        'ddth-dao.mysql.host' => '127.0.0.1',
        'ddth-dao.mysql.username' => 'dzit_demo',
        'ddth-dao.mysql.password' => 'dzit_demo',
        'ddth-dao.mysql.persistent' => FALSE,
        'ddth-dao.mysql.database' => 'dzit_demo',
        'dao.simpleBlog' => 'Dzit_Demo_Bo_MysqlSimpleBlogDao');

/*
 * Configurations for Ddth::Mls
 */
global $DPHP_MLS_CONFIG;
$DPHP_MLS_CONFIG = Array('factory.class' => 'Ddth_Mls_BaseLanguageFactory',
        'languages' => 'en',
        // Note: Language base directory is relative to the [www] directory!
        'language.baseDirectory' => '../config/languages',
        'language.class' => 'Ddth_Mls_FileLanguage',
        'language.en.location' => 'en_us',
        'language.en.displayName' => 'English',
        'language.en.locale' => 'en_US',
        'language.en.description' => 'English (US) language pack');

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
$router = Array('createPost' => 'Dzit_Demo_Controller_CreatePost',
        'deletePost' => 'Dzit_Demo_Controller_DeletePost',
        '' => 'Dzit_Demo_Controller_Home');
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

?>
