<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Represents a language pack.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassILanguage.php 222 2010-11-21 07:25:10Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Represents a language pack.
 *
 * This interface represents a single language pack.
 *
 * @package    	Mls
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Ddth_Mls_ILanguage {
    /**
     * Gets a text message from this language.
     * 
     * Note: the official type of the argument $replacements is an array.
     * Implementations of this interface, however, can take advantage of PHP's
     * variable arguments support to take in any number of single replacement.  
     *
     * @param string key of the text message to get
     * @param Array() replacements for place-holders within the text message
     * @return string
     */
    public function getMessage($key, $replacements=NULL);

    /**
     * Gets description of the language pack.
     *
     * @return string
     */
    public function getDescription();
    
    /**
     * Gets display name of the language pack.
     *
     * @return string
     */
    public function getDisplayName();
    
    /**
     * Gets name of the language pack.
     *
     * @return string
     */
    public function getName();

    /**
     * Initializes the language pack.
     *
     * @param Dddth_Commons_Properties
     * @throws Ddth_Mls_MlsException
     */
    public function init($settings);
}
?>
