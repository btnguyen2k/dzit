<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory interface to create language pack objects.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassILanguageFactory.php 222 2010-11-21 07:25:10Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Factory interface to create language pack objects.
 *
 * @package    	Mls
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Ddth_Mls_ILanguageFactory {

    /**
     * Gets a language pack.
     *
     * @param string
     * @return Ddth_Mls_ILanguage
     * @throws Ddth_Mls_MlsException
     */
    public function getLanguage($name);

    /**
     * Gets list of names of available languages.
     *
     * @return Array()
     */
    public function getLanguageNames();

    /**
     * Initializes the factory.
     *
     * @param Dddth_Commons_Properties
     * @throws Ddth_Mls_MlsException
     */
    public function init($settings);
}
?>
