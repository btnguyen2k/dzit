<?php
function error($str) {
    echo "Error: $str\n";
    echo "\n";
    exit(-1);
}

function removeTree($dir, $removeCurrent = false) {
    if ( !is_dir($dir) ) {
        return;
    }
    if ( $dir_handle = opendir($dir) ) {
        while ( $file = readdir($dir_handle) ) {
            if ( $file != "." && $file != ".." ) {
                $target = $dir."/".$file;                
                if ( is_dir($target) ) {
                    removeTree($target, true);
                } else {
                    echo "Deleting $target...\n";
                    unlink($target);
                }
            }
        }
        closedir($dir_handle);
        if ( $removeCurrent ) {
            echo "Deleting $dir...\n";
            rmdir($dir);
        }
        return true;
    } else {
        return false;
    }
}

function copyDir($source, $dest) {
    if ( !is_dir($source) ) {
        error("$source is not a directory or does not exists!");
    }
    if ( !is_dir($dest) ) {
        error("$dest is not a directory or does not exists!");
    }

    if ( $source_dh = opendir($source) ) {
        while ( $file = readdir($source_dh) ) {
            //if ( $file != "." && $file != ".." ) {
            if ( $file[0] != "." ) {
                if ( is_dir($source."/".$file) ) {
                    echo "Copying directory $source/$file...\n";
                    mkdir($dest."/".$file);
                    copyDir($source."/".$file, $dest."/".$file);
                } else {
                    copyFile($source."/".$file, $dest."/".$file);
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
?>