<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * XML to Xnode parser using SimpleXML.
 *
 * LICENSE: This source file is subject to version 3.0 of the GNU Lesser General
 * Public License that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/lgpl.html. If you did not receive a copy of
 * the GNU Lesser General Public License and are unable to obtain it through the web,
 * please send a note to gnu@gnu.org, or send an email to any of the file's authors
 * so we can email you a copy.
 *
 * @package		Xpath
 * @subpackage	SimpleXml
 * @author		Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version			$Id: ClassXmlParser.php 222 2010-11-21 07:25:10Z btnguyen2k@gmail.com $
 * @since      	File available since v0.1
 */

if ( !function_exists('__autoload') ) {
    /**
     * Automatically loads class source file when used.
     *
     * @param string
     */
    function __autoload($className) {
        require_once 'Ddth/Commons/ClassDefaultClassNameTranslator.php';
        require_once 'Ddth/Commons/ClassLoader.php';
        $translator = Ddth_Commons_DefaultClassNameTranslator::getInstance();
        Ddth_Commons_Loader::loadClass($className, $translator);
    }
}

/**
 * XML to Xnode parser using SimpleXML.
 *
 * This implementation of {@link Ddth_Xpath_XmlParser XmlParser} parses an XML document
 * using {@link http://php.net/simplexml SimpleXML} extension.
 *
 * @package    	Xpath
 * @subpackage	SimpleXml
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version    	0.1
 * @since      	Class available since v0.1
 */
class Ddth_Xpath_SimpleXml_XmlParser extends Ddth_Xpath_XmlParser {
    /**
     * Constructs a new Ddth_Xpath_SimpleXml_XmlParser object.
     */
    protected function __construct() {
        parent::__construct();
    }

    /**
     * @param string
     * @return Xnode
     */
    public function parseXml($xml) {
        @$simpleXML = simplexml_load_string($xml);        
        if ( $simpleXML === false ) {
            return NULL;
        }
        return Ddth_Xpath_SimpleXml_Xnode::createNode($simpleXML);
    }
}
?>