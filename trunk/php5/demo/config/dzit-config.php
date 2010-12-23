<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Dzit's core configuration file.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: index.php 30 2010-11-21 16:08:30Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

date_default_timezone_set('Asia/Ho_Chi_Minh');

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
$router = Array(
    ''  => 'Dzit_Demo_Controller_Home'
);
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
