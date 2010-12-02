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

if ( !function_exists('__autoload') ) {
    /**
     * Automatically loads class source file when used.
     *
     * @param string
     * @ignore
     */
    function __autoload($className) {
        require_once 'Ddth/Commons/ClassDefaultClassNameTranslator.php';
        require_once 'Ddth/Commons/ClassLoader.php';
        $translator = Ddth_Commons_DefaultClassNameTranslator::getInstance();
        if ( !Ddth_Commons_Loader::loadClass($className, $translator) ) {
            trigger_error("Can not load class [$className]!");
        }
    }
}

/*
 * This is the directory where configuration files are stored.
 * It should not be reachable from the web.
 */
define('CONFIG_DIR', '../config');
if ( !is_dir(CONFIG_DIR) ) {
    exit('Invalid CONFIG_DIR setting!');
}

/*
 * This is the directory where 3rd party libraries are located.
 * All 1st level sub-directories of this directory will be included
 * in the include_path
 */
define('LIBS_DIR', '../libs');
if ( !is_dir(LIBS_DIR) ) {
    exit('Invalid LIBS_DIR setting!');
}

/* set up include path */
$includePath = '.'.PATH_SEPARATOR.CONFIG_DIR.PATH_SEPARATOR;
if ( $dh = @opendir(LIBS_DIR) ) {
    while ( ($file = readdir($dh)) !== false ) {
        if ( is_dir(LIBS_DIR."/$file") && $file!="." && $file!=".." ) {
            $includePath .= PATH_SEPARATOR.LIBS_DIR."/$file";
        }
    }
} else {
    exit('Can not open LIBS_DIR!');
}
ini_set('include_path', $includePath);

require_once CONFIG_DIR.'/dzit-config.php';

$logger = Ddth_Commons_Logging_LogFactory::getLog('Dzit');
try {
    /**
     * @var Dzit_IDispatcher
     */
    $dispatcher = Dzit_Config::get(Dzit_Config::CONF_DISPATCHER);
    if ( $dispatcher === NULL || !($dispatcher instanceof Dzit_IDispatcher) ) {
        $dispatcher = new Dzit_DefaultDispatcher();
    }
    $dispatcher->dispatch();
} catch ( Exception $e ) {
    $logger->error($e->getMessage(), $e);
}
?>
