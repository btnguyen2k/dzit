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
 * Base controller to view/download the attachment online.
 *
 * @package    	Paperclip
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
abstract class Paperclip_Controller_BaseController implements Dzit_IController {

    protected abstract function doHeader($attachment);

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
        $id = isset($viewValue[Paperclip_Utils::ATTR_ID]) ? $viewValue[Paperclip_Utils::ATTR_ID] : NULL;
        $isOnetime = isset($viewValue[Paperclip_Utils::ATTR_ONETIME]) && $viewValue[Paperclip_Utils::ATTR_ONETIME];
        if ( $isOnetime ) {
            unset($_SESSION["PAPERCLIP_$viewKey"]);
        }
        $item = $dao->getAttachment($id);
        if ($item !== NULL) {
            if ( $isOnetime ) {
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

            $this->doHeader($item);

            if ($item->getMimetype()) {
                header('Content-type: ' . $item->getMimeType());
            }
            header('Content-length: ' . $item->getFilesize());
            if ( $item->isExternalStorage() ) {
                $storageDir = $viewValue[Paperclip_Utils::ATTR_STORAGE_DIR];
                $file = Paperclip_Utils::buildFile($storageDir,
                        $item->getMetadataEntry(Paperclip_Bo_BoPaperclip::META_FILE_DISK_NAME),
                        $item->getMetadataEntry(Paperclip_Bo_BoPaperclip::META_FILE_DIR)
                    );
                echo Paperclip_Utils::getFileContent($file);
            } else {
                echo $item->getFilecontent();
            }
        } else {
            header('HTTP/1.1 404 Not Found', TRUE, 404);
            echo "File not found!";
        }
    }
}