<?php
require_once 'utils.php';

/* Use phpDocumentor to build docs for php projects */
if ( count($argv) != 3 && count($argv) != 4 ) {
    echo "Usage:\n";
    echo "\tphp builddocs.php <full_path_to_php_executable> <path_to_phpDocumentor>";
    echo "\n";
    echo "Example:\n";
    echo "\tphp builddocs.php /usr/bin/php /usr/phpDocumentor";
    echo "\n";
    exit(-1);
}

$PHP = $argv[1];
if ( !is_executable($PHP) ) {
    error("$PHP is not an executable file!");
}

$PHP_DOCUMENTOR = $argv[2].'/phpDocumentor/phpdoc.inc';
if ( !is_readable($PHP_DOCUMENTOR) ) {
    error("$PHP_DOCUMENTOR is not readable!");
}

removeTree('phpDocs');
@mkdir('phpDocs');

/*
 * Some styles:
 * - HTML:frames:* - output is HTML with frames.
 *   + HTML:frames:default - JavaDoc-like template, very plain, minimal formatting
 *   + HTML:frames:earthli - BEAUTIFUL template written by Marco von Ballmoos
 *   + HTML:frames:l0l33t - Stylish template
 *   + HTML:frames:phpdoc.de - Similar to phpdoc.de's PHPDoc output
 *   + HTML:frames:phphtmllib - Very nice user-contributed template
 *   all of the templates listed above are also available with javascripted expandable
 *   indexes, as HTML:frames:DOM/name where name is default, l0l33t, phpdoc.de, etcetera
 *   + HTML:frames:phpedit - Based on output from PHPEdit Help Generator
 * - HTML:Smarty:* - output is HTML with no frames.
 *   + HTML:Smarty:default - Bold template design using css to control layout
 *   + HTML:Smarty:HandS - Layout is based on PHP, but more refined, with logo image
 *   + HTML:Smarty:PHP - Layout is identical to the PHP website
 * - CHM:default:* - output is CHM, compiled help file format (Windows help).
 *   + CHM:default:default - Windows help file, based on HTML:frames:l0l33t
 * - PDF:default:* - output is PDF, Adobe Acrobat format.
 *   + PDF:default:default - standard, plain PDF formatting
 * - XML:DocBook:* - output is XML, in DocBook format
 *   + XML:DocBook/peardoc2:default - documentation ready for compiling into peardoc
 *     for online pear.php.net documentation, 2nd revision 
 */
$STYLE = "";
if ( count($argv) == 2 ) {
    $STYLE = "-o \"$argv[1]\"";
} else {
    //default stype
    $STYLE = "-o \"HTML:Smarty:HandS\"";
}
$CMD = "$PHP \"$PHP_DOCUMENTOR\" -t \"phpDocs\" $STYLE -d \"src\" -ti \"Dzit Documentation\"";
echo $CMD, "\n";
system($CMD);
?>