<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Dzit's bootstrap script.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.1
 */

spl_autoload_register('dzitAutoload');

/**
 * Dzit's class auto loader.
 */
function dzitAutoload($className) {
    global $DZIT_IGNORE_AUTOLOAD;
    if (isset($DZIT_IGNORE_AUTOLOAD) && is_array($DZIT_IGNORE_AUTOLOAD)) {
        foreach ($DZIT_IGNORE_AUTOLOAD as $pattern) {
            if (preg_match($pattern, $className)) {
                return FALSE;
            }
        }
    }
    $translator = Ddth_Commons_DefaultClassNameTranslator::getInstance();
    if (!Ddth_Commons_Loader::loadClass($className, $translator)) {
        return FALSE;
    }
    return TRUE;
}

/*
 * Define a token as the include-allow key.
 * Usage: put the following code at the top of your php script.
 * <code>
 * <?php defined('DZIT_INCLUDE_KEY') || die('No direct access allowed!');
 *
 * ...
 * </code>
 */
define('DZIT_INCLUDE_KEY', 'DZIT_INCLUDE_OK');

$BASE_DIR = __DIR__ . DIRECTORY_SEPARATOR;

/*
 * This is the directory where configuration files are stored.
 * For security reason, it should not be reachable from the web.
 * Note: change the value if your config folder is located at another location!
 */
define('CONFIG_DIR', $BASE_DIR . '../config');
if (!is_dir(CONFIG_DIR)) {
    exit('Invalid CONFIG_DIR setting!');
}

/*
 * This is the directory where 3rd party libraries are located.
 * All 1st level sub-directories of this directory will be included
 * in the include_path.
 * Note: change the value if your config folder is located at another location!
 */
define('LIBS_DIR', $BASE_DIR . '../libs');
if (!is_dir(LIBS_DIR)) {
    exit('Invalid LIBS_DIR setting!');
}

/* set up include path */
$includePath = ini_get('include_path') . PATH_SEPARATOR . '.' . PATH_SEPARATOR . CONFIG_DIR . PATH_SEPARATOR;
if (($dh = @opendir(LIBS_DIR)) !== FALSE) {
    while (($file = readdir($dh)) !== FALSE) {
        if (is_dir(LIBS_DIR . "/$file") && $file != "." && $file != "..") {
            $includePath .= PATH_SEPARATOR . LIBS_DIR . "/$file";
        }
    }
} else {
    exit('Can not open LIBS_DIR!');
}
ini_set('include_path', $includePath);

/*
 * This is the directory where application's modules are located.
 * All 1st level sub-directories of this directory will be included
 * in the include_path.
 * Note: change the value if your module folder is located at another location!
 * Note: if the application does not use module directory.
 */
define('MODULES_DIR', $BASE_DIR . '../modules');

if (defined('MODULES_DIR')) {
    /* set up include path */
    $includePath = ini_get('include_path');
    if (($dh = @opendir(MODULES_DIR)) !== FALSE) {
        while (($file = readdir($dh)) !== FALSE) {
            if (is_dir(MODULES_DIR . "/$file") && $file != "." && $file != "..") {
                $includePath .= PATH_SEPARATOR . MODULES_DIR . "/$file";
            }
        }
    } else {
        exit('Can not open MODULES_DIR!');
    }
    ini_set('include_path', $includePath);
}

require_once 'Ddth/Commons/ClassDefaultClassNameTranslator.php';
require_once 'Ddth/Commons/ClassLoader.php';

//load the configuration file if exists
if (file_exists(CONFIG_DIR . '/dzit-config.php')) {
    include_once CONFIG_DIR . '/dzit-config.php';
}

//load the bootstrap file if exists
if (file_exists(CONFIG_DIR . '/dzit-bootstrap.php')) {
    include_once CONFIG_DIR . '/dzit-bootstrap.php';
}

$logger = Ddth_Commons_Logging_LogFactory::getLog('Dzit');
try {
    /**
     * @var Dzit_IDispatcher
     */
    $dispatcher = Dzit_Config::get(Dzit_Config::CONF_DISPATCHER);
    if ($dispatcher === NULL || !($dispatcher instanceof Dzit_IDispatcher)) {
        $dispatcher = new Dzit_DefaultDispatcher();
    }
    if ($logger->isDebugEnabled()) {
        $logger->debug("[__CLASS__::__FUNCTION__]Use dispatcher class [" . get_class($dispatcher) . "]");
    }
    $dispatcher->dispatch();
} catch (Exception $e) {
    $logger->error($e->getMessage(), $e);
}
?>