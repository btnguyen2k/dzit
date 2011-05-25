<?php
require_once 'utils.php';

function buildDemo($demoApp) {
	/* remove existing dzit libs */
    $dir = "demo/$demoApp/libs";
    if ( FALSE !== ($dh = opendir($dir)) ) {
        while ( FALSE !== ($file = readdir($dh)) ) {
            if ( strpos($file, 'dzit')===0 ) {
                removeTree("$dir/$file");
            }
        }
    }

    global $DZIT_VERSION;
    //removeTree("demo/$demoApp/libs/dzit-$DZIT_VERSION");
    @mkdir("demo/$demoApp/libs/dzit-$DZIT_VERSION");
    @mkdir("demo/$demoApp/libs/dzit-$DZIT_VERSION/Dzit");
    copyDir("src/Dzit", "demo/$demoApp/libs/dzit-$DZIT_VERSION/Dzit");
    copy("src/index.php", "demo/$demoApp/www/index.php");
    copy("src/template/dzit-config.php", "demo/$demoApp/config/dzit-config.php.template");
    copy("src/template/dzit-bootstrap.php", "demo/$demoApp/config/dzit-bootstrap.php.template");
    copy("src/index.php", "demo/$demoApp/www/index.php");
}

$includePath = ".";
$includePath .= PATH_SEPARATOR."libs/dphp-commons";
$includePath .= PATH_SEPARATOR."libs/dphp-xpath";
ini_set("include_path", $includePath);

if ( !function_exists('__autoload') ) {
    function __autoload($className) {
        require_once 'Ddth/Commons/ClassDefaultClassNameTranslator.php';
        require_once 'Ddth/Commons/ClassLoader.php';
        $translator = Ddth_Commons_DefaultClassNameTranslator::getInstance();
        Ddth_Commons_Loader::loadClass($className, $translator);
    }
}

$DIR_SOURCE = 'src';
if ( !is_dir($DIR_SOURCE) ) {
    error("$DIR_SOURCE is not a directory or does not exists!");
}

$xml = Ddth_Commons_Loader::loadFileContent($DIR_SOURCE.DIRECTORY_SEPARATOR.'package.xml');
$xpath = Ddth_Xpath_XmlParser::getInstance();
$xnode = $xpath->parseXml($xml);
$xnodes = $xnode->xpath("/package/version");
global $DZIT_VERSION;
$DZIT_VERSION = $xnodes[0]->getValue();

$demoApps = Array('helloworld', 'simpleblog');
foreach ($demoApps as $app) {
    echo "Building demo application [$app]...\n";
    buildDemo($app);
}
?>
