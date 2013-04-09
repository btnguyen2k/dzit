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
 * @version     $Id: ClassDownloadController.php 250 2013-04-09 04:52:01Z btnguyen2k $
 * @since       File available since v0.1
 */

/**
 * Controller to force download the attachment.
 *
 * @package    	Paperclip
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Paperclip_Controller_DownloadController implements Dzit_IController {
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
        $viewValue = isset($_SESSION["PAPERCLIP_$viewKey"]) ? $_SESSION["PAPERCLIP_$viewKey"] : NULL;
        $id = $viewValue !== NULL ? $viewValue['id'] : NULL;
        $onetime = FALSE;
        if ($viewValue !== NULL && $viewValue['onetime']) {
            $onetime = TRUE;
            unset($_SESSION["PAPERCLIP_$viewKey"]);
        }
        $item = $dao->getAttachment($id);
        if ($item !== NULL) {
            if ( $onetime ) {
                header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
                header("Expires: Sat, 1 Jan 2011 00:00:00 GMT"); // Date in the past
            } else {
                $timeStrItem = gmdate('D, d M Y H:i:s ', $item->getTimestamp()) . 'GMT';
                $timeStrExpiry = gmdate('D, d M Y H:i:s ', time()+3600) . 'GMT';

                $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : FALSE;
                $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : FALSE;
                if ( ($if_none_match && $if_none_match===$etag) || ($if_modified_since && $if_modified_since===$timeStrItem) ) {
                    header('HTTP/1.1 304 Not Modified');
                    return;
                }

                $etag = md5($timeStrItem);
                header('Cache-Control: public, max-age=3600');
                header("ETag: \"$etag\"");
                header("Last-Modified: $timeStrItem");
                header("Expires: $timeStrExpiry");
            }
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
