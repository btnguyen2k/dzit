<?php
function error($str) {
    echo "Error: $str\n";
    echo "\n";
    exit();
}

function removeTree($dir, $removeCurrent = false) {
    if (!is_dir($dir)) {
        return;
    }
    if (($dir_handle = opendir($dir)) !== FALSE) {
        while (($file = readdir($dir_handle)) !== FALSE) {
            if ($file != "." && $file != "..") {
                if (is_dir($dir . "/" . $file)) {
                    removeTree($dir . "/" . $file, true);
                } else {
                    unlink($dir . "/" . $file);
                }
            }
        }
        closedir($dir_handle);
        if ($removeCurrent) {
            rmdir($dir);
        }
        return true;
    } else {
        return false;
    }
}

function copyDir($source, $dest) {
    if (!is_dir($source)) {
        error("$source is not a directory or does not exists!");
    }
    if (!is_dir($dest)) {
        error("$dest is not a directory or does not exists!");
    }

    if (($source_dh = opendir($source)) !== FALSE) {
        while (($file = readdir($source_dh)) !== FALSE) {
            //if ( $file != "." && $file != ".." ) {
            if ($file[0] != ".") {
                if (is_dir($source . "/" . $file)) {
                    echo "Copying directory $source/$file...\n";
                    mkdir($dest . "/" . $file);
                    copyDir($source . "/" . $file, $dest . "/" . $file);
                } else {
                    copyFile($source . "/" . $file, $dest . "/" . $file);
                }
            }
        }
        closedir($source_dh);
    }
}

function copyFile($source, $dest) {
    echo "Copying file $source...\n";
    copy($source, $dest);
}

function zipDir($dir, $filename) {
    $zip = new ZipArchive();

    if ($zip->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
        error("cannot open <$filename>\n");
    }

    performZipDir($dir, $dir, $zip);

    echo "Number of Files: " . $zip->numFiles . "\n";
    echo "Status:" . $zip->status . "\n";
    $zip->close();
}

function performZipDir($parent, $dir, $zip) {
    if (!is_dir($dir)) {
        error("$dir is not a directory or does not exists!");
    }

    if (($source_dh = opendir($dir)) !== FALSE) {
        $isEmpty = true;
        while (($file = readdir($source_dh)) !== FALSE) {
            //if ( $file != "." && $file != ".." ) {
            if ($file[0] != ".") {
                $isEmpty = false;
                $realFile = $dir . DIRECTORY_SEPARATOR . $file;
                $zipEntry = substr($realFile, strlen($parent) + 1);
                if (is_dir($realFile)) {
                    //echo "Added dir:\t$zipEntry\n";
                    //$zip->addEmptyDir($zipEntry);
                    performZipDir($parent, $realFile, $zip);
                } else {
                    echo "Added file:\t$zipEntry\n";
                    $zip->addFile($realFile, $zipEntry);
                }
            }
        }
        if ($isEmpty) {
            $zipEntry = substr($dir, strlen($parent) + 1);
            echo "Added dir:\t$zipEntry\n";
            $zip->addEmptyDir($zipEntry);
        }
        closedir($source_dh);
    }
}

$DIR_RELEASE = 'release';
if (!is_dir($DIR_RELEASE)) {
    mkdir($DIR_RELEASE);
}
if (!is_dir($DIR_RELEASE)) {
    error("$DIR_RELEASE is not a directory or does not exists!");
}

$DIR_SOURCE = 'src';
if (!is_dir($DIR_SOURCE)) {
    error("$DIR_SOURCE is not a directory or does not exists!");
}

$DIR_DEMO = 'demo';

//remove content of release directory
removeTree($DIR_RELEASE, false);

//copy Dzit source over
$DIR_RELEASE_SRC = $DIR_RELEASE . DIRECTORY_SEPARATOR . 'src';
mkdir($DIR_RELEASE_SRC);
copyDir($DIR_SOURCE, $DIR_RELEASE_SRC);

//copy the demo(s) over
$DIR_RELEASE_DEMO = $DIR_RELEASE . DIRECTORY_SEPARATOR . 'demo';
mkdir($DIR_RELEASE_DEMO);
copyDir($DIR_DEMO, $DIR_RELEASE_DEMO);

//copy the license.txt file over
copyFile("license.txt", $DIR_RELEASE_SRC . DIRECTORY_SEPARATOR . "license.txt");

$includePath = ".";
//$includePath .= PATH_SEPARATOR . "libs/dphp-commons";
//$includePath .= PATH_SEPARATOR . "libs/dphp-xpath";
$includePath .= PATH_SEPARATOR . "libs/dphp-commons-trunk";
$includePath .= PATH_SEPARATOR . "libs/dphp-xpath-trunk";
ini_set("include_path", $includePath);

if (!function_exists('__autoload')) {
    function __autoload($className) {
        require_once 'Ddth/Commons/ClassDefaultClassNameTranslator.php';
        require_once 'Ddth/Commons/ClassLoader.php';
        $translator = Ddth_Commons_DefaultClassNameTranslator::getInstance();
        Ddth_Commons_Loader::loadClass($className, $translator);
    }
}

$xml = Ddth_Commons_Loader::loadFileContent($DIR_SOURCE . DIRECTORY_SEPARATOR . 'package.xml');
$xpath = Ddth_Xpath_XmlParser::getInstance();
$xnode = $xpath->parseXml($xml);
$xnodes = $xnode->xpath("/package/version");
$VERSION = $xnodes[0]->getValue();

$t = date("Ymd");
$ZIPFILE = "Dzit-$VERSION-$t.zip";
$ZIPFILE = strtolower($ZIPFILE);
$ZIPFILE = $DIR_RELEASE . DIRECTORY_SEPARATOR . $ZIPFILE;
@unlink($ZIPFILE);
zipDir($DIR_RELEASE, $ZIPFILE);
?>
