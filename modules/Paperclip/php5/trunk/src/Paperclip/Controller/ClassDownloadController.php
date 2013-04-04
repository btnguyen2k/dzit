<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Controller to force download the attachment.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Paperclip
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.1
 */

/**
 * Controller to force download the attachment.
 *
 * @package    	Paperclip
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Paperclip_Controller_ViewController implements Dzit_IController {
    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $dao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao(DAO_PAPERCLIP);
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $viewKey = $requestParser->getPathInfoParam(2);
        $viewValue = Commons_Utils_SessionUtils::getSessionEntry("PAPERCLIP_$viewKey");
        $id = $viewValue !== NULL ? $viewValue['id'] : NULL;
        if ($viewValue !== NULL && $viewValue['onetime']) {
            Commons_Utils_SessionUtils::deleteSessionEntry("PAPERCLIP_$viewKey");
        }
        $item = $dao->getAttachment($id);
        if ($item !== NULL) {
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 1 Jan 2011 00:00:00 GMT"); // Date in the past
            header('Content-Disposition: attachment; filename="' . $item->getFilename() . '"');
            if ($item->getMimetype()) {
                header('Content-type: ' . $item->getMimeType());
            }
            header('Content-length: ' . $item->getFilesize());
            echo $item->getFilecontent();
        } else {
            header('HTTP/1.0 404 Not Found', TRUE, 404);
        }
    }
}