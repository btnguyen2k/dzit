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
define('IN_DEV_ENV', isset($_ENV['DEV_ENV']));

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
 * Configurations for Ddth::Commons::Logging
 * Note: the default logger (SimpleLog which writes log to php's system log) should
 * be sufficient for most cases. Change it if you want to use another logger.
 */
global $DPHP_COMMONS_LOGGING_CONFIG;
$DPHP_COMMONS_LOGGING_CONFIG = Array(
        'ddth.commons.logging.Logger' => 'Ddth_Commons_Logging_SimpleLog',
        'logger.setting.default' => IN_DEV_ENV ? 'DEBUG' : 'WARN');

/*
 * Configurations for Ddth::Mls
 */
/*
 * Note: Below is an example of 2 language packs (ENglish and VietNamese)!
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
 * Note: Configure your routings here!
 */
$router = Array('*' => 'PwdEncrypt_BaseController', 'lang' => 'PwdEncrypt_ChangeLanguageController');
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
 * Name of the default language pack.
 */
Dzit_Config::set(Dzit_Config::CONF_DEFAULT_LANGUAGE_NAME, 'en');

/*
 * Name of the module's bootstrap file.
 */
define('MODULE_BOOTSTRAP_FILE', 'bootstrap.php');
