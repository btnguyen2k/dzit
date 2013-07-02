<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Controller to view the attachment online.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Paperclip
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassViewController.php 259 2013-05-11 17:40:34Z btnguyen2k $
 * @since       File available since v0.1
 */

/**
 * Controller to view the attachment online.
 *
 * @package    	Paperclip
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Paperclip_Controller_ViewController extends Paperclip_Controller_BaseController {
    /**
     * (non-PHPdoc)
     * @see Paperclip_Controller_BaseController::doHeader()
     */
    protected function doHeader($attachment) {
        header('Content-Disposition: inline; filename="' . $attachment->getMetadataEntry(Paperclip_Bo_BoPaperclip::META_FILE_NAME) . '"');
    }
}
