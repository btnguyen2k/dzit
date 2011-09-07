<?php
/* Quack module's boostrap file */

/* Add Yadif to Dzit's autoloading ignore list */
global $DZIT_IGNORE_AUTOLOAD;
if ( !isset($DZIT_IGNORE_AUTOLOAD) || !is_array($DZIT_IGNORE_AUTOLOAD) ) {
    $DZIT_IGNORE_AUTOLOAD = Array('/^Yadif_*/');
} else {
    $DZIT_IGNORE_AUTOLOAD[] = '/^Yadif_*/';
}

include_once 'Yadif/Exception.php';
include_once 'Yadif/Container.php';

global $YADIF_CONFIG;
if ( !isset($YADIF_CONFIG) || !is_array($YADIF_CONFIG) ) {
    $YADIF_CONFIG = Array();
}
