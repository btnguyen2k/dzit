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
 * @version     $Id: ClassDownloadController.php 257 2013-05-11 17:18:46Z btnguyen2k $
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
        $viewValue = is_array($viewValue) ? $viewValue : Array();
        $id = isset($viewValue['id']) ? $viewValue['id'] : NULL;
        if (isset($viewValue['onetime']) && $viewValue['onetime']) {
            unset($_SESSION["PAPERCLIP_$viewKey"]);
        }
        $item = $dao->getAttachment($id);
        if ($item !== NULL) {
            if (isset($viewValue['onetime']) && $viewValue['onetime']) {
                header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
                header("Expires: Sat, 1 Jan 2011 00:00:00 GMT"); // Date in the past
            } else {
                $timeStrItem = gmdate('D, d M Y H:i:s ', $item->getTimestamp()) . 'GMT';
                $timeStrExpiry = gmdate('D, d M Y H:i:s ', time()+3600) . 'GMT';
                $etag = md5($timeStrItem);

                header('Cache-Control: public, max-age=3600');
                header("ETag: \"$etag\"");
                header("Last-Modified: $timeStrItem");
                header("Expires: $timeStrExpiry");

                $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : FALSE;
                $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : FALSE;
                if ( ($if_none_match && $if_none_match===$etag) || ($if_modified_since && $if_modified_since===$timeStrItem) ) {
                    header('HTTP/1.1 304 Not Modified');
                    return;
                }
            }
            header('Content-Disposition: attachment; filename="' . $item->getFilename() . '"');
            if ($item->getMimetype()) {
                header('Content-type: ' . $item->getMimeType());
            }
            header('Content-length: ' . $item->getFilesize());
            echo $item->getFilecontent();
        } else {
            header('HTTP/1.1 404 Not Found', TRUE, 404);
            echo "File not found!";
        }
    }
}
