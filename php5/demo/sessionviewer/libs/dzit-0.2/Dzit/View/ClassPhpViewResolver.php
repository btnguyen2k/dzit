<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * PHP-based single-template view resolver.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassPhpViewResolver.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * PHP-based single-template view resolver.
 *
 * This class resolves view name to a .php file that can be included. Use this view resolver
 * if the application uses just a single PHP-based template.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.2
 */
class Dzit_View_PhpViewResolver implements Dzit_IViewResolver {

    private $prefix;

    /**
     * Constructs a new Dzit_View_PhpViewResolver object.
     */
    public function __construct($prefix='') {
        $this->setPrefix($prefix);
    }

    /**
     * Gets the prefix string.
     *
     * @return string.
     */
    public function getPrefix() {
        return $this->prefix;
    }

    /**
     * Sets the prefix string.
     *
     * @param stringg $prefix
     */
    public function setPrefix($prefix) {
        if ( trim($prefix) == '' || $prefix == NULL ) {
            $this->prefix = '';
        } else {
            $this->prefix = trim($prefix);
            #$this->prefix = preg_replace('/\\/+$/', '', $prefix) . '/';
        }
    }

    /**
     * This function resolves a view name to an instance of {@link Dzit_View_PhpView}.
     *
     * @see Dzit_IViewResolver::resolveViewName()
     */
    public function resolveViewName($viewName) {
        if ( preg_match('/^[a-z0-9_\\.\\-]+$/i', $viewName) ) {
            $filename = $this->prefix . $viewName . '.php';
            return new Dzit_View_PhpView($filename);
        }
        return NULL;
    }
}
?>