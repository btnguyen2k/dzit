<?php
class Paperclip_Utils {

    private static function getDao($name) {
        return Ddth_Dao_BaseDaoFactory::getInstance()->getDao($name);
    }

    /**
     * Reads file content and returns it as binary string.
     *
     * @param string $filepath
     * @return string
     */
    public static function getFileContent($filepath) {
        $filesize = filesize($filepath);
        $fp = fopen($filepath, 'rb');
        $filecontent = fread($fp, $filesize);
        fclose($fp);
        return $filecontent;
    }

    /**
     * Gets an attached image's dimensions (width and height).
     *
     * @param string $id
     * @param
     *            Array first element is image's width, second image is image's
     *            height
     */
    public static function getImageDemensions($id) {
        $dao = self::getDao(DAO_PAPERCLIP);
        $item = $dao->getAttachment($id);
        return $item !== NULL ? Array($item->getImgWidth(), $item->getImgheight()) : Array(0, 0);
    }

    /**
     * Gets an attached image's width.
     *
     * @param string $id
     * @param
     *            int
     */
    public static function getImageWidth($id) {
        $dim = self::getImageDemensions($id);
        return $dim[0];
    }

    /**
     * Gets an attached image's height.
     *
     * @param string $id
     * @param
     *            int
     */
    public static function getImageHeight($id) {
        $dim = self::getImageDemensions($id);
        return $dim[1];
    }

    /**
     * Creates a URL to view a paperclip item as thumbnail.
     *
     * @param string $id
     * @param Paperclip_Bo_IPaperclipDao $paperclipDao
     * @param Dzit_IUrlCreator $urlCreator
     * @param string $paperclipModule='paperclip'
     * @param string $thumbnailAction='thumbnail'
     * @param boolean $onetimeView
     *            set to TRUE to make the URL one-time-use
     * @return string the URL or NULL
     */
    public static function createUrlThumbnail($id, $paperclipDao, $urlCreator, $paperclipModule='paperclip', $thumbnailAction='thumbnail', $onetimeView = FALSE) {
        $item = $paperclipDao->getAttachment($id);
        if ($item === NULL) {
            return NULL;
        }
        $viewEntry = Array('id' => $id, 'onetime' => $onetimeView, 'timestamp' => time());
        $viewKey = md5("thumbnail$id");
        if ( !isset($_SESSION["PAPERCLIP_$viewKey"]) ) {
            $_SESSION["PAPERCLIP_$viewKey"] = $viewEntry;
        }
        $url = $urlCreator->createUrl(Array(
                Dzit_IUrlCreator::PARAM_MODULE => $paperclipModule,
                Dzit_IUrlCreator::PARAM_ACTION => $thumbnailAction,
                Dzit_IUrlCreator::PARAM_PATH_INFO_PARAMS => Array($viewKey, $item->getTimestamp())
            )
        );
        return $url;
    }

    /**
     * Creates a URL to view a paperclip item.
     *
     * @param string $id
     * @param Paperclip_Bo_IPaperclipDao $paperclipDao
     * @param Dzit_IUrlCreator $urlCreator
     * @param string $paperclipModule='paperclip'
     * @param string $viewAction='thumbnail'
     * @param boolean $onetimeView
     *            set to TRUE to make the URL one-time-use
     * @return string the URL or NULL
     */
    public static function createUrlView($id, $paperclipDao, $urlCreator, $paperclipModule='paperclip', $viewAction='view', $onetimeView = FALSE) {
        $item = $paperclipDao->getAttachment($id);
        if ($item === NULL) {
            return NULL;
        }
        $viewEntry = Array('id' => $id, 'onetime' => $onetimeView, 'timestamp' => time());
        $viewKey = md5("view$id");
        if ( !isset($_SESSION["PAPERCLIP_$viewKey"]) ) {
            $_SESSION["PAPERCLIP_$viewKey"] = $viewKey;
        }
        $url = $urlCreator->createUrl(Array(
                Dzit_IUrlCreator::PARAM_MODULE => $paperclipModule,
                Dzit_IUrlCreator::PARAM_ACTION => $viewAction,
                Dzit_IUrlCreator::PARAM_PATH_INFO_PARAMS => Array($viewKey, $item->getTimestamp())
        )
        );
        return $url;
    }

    /**
     * Creates a URL to download a paperclip item.
     *
     * @param string $id
     * @param Paperclip_Bo_IPaperclipDao $paperclipDao
     * @param Dzit_IUrlCreator $urlCreator
     * @param string $paperclipModule='paperclip'
     * @param string $downloadAction='thumbnail'
     * @param boolean $onetimeView
     *            set to TRUE to make the URL one-time-use
     * @return string the URL or NULL
     */
    public static function createUrlDownload($id, $paperclipDao, $urlCreator, $paperclipModule='paperclip', $downloadAction='download', $onetimeView = FALSE) {
        $item = $paperclipDao->getAttachment($id);
        if ($item === NULL) {
            return NULL;
        }
        $viewEntry = Array('id' => $id, 'onetime' => $onetimeView, 'timestamp' => time());
        $viewKey = md5("download$id");
        if ( !isset($_SESSION["PAPERCLIP_$viewKey"]) ) {
            $_SESSION["PAPERCLIP_$viewKey"] = $viewEntry;
        }
        $url = $urlCreator->createUrl(Array(
                Dzit_IUrlCreator::PARAM_MODULE => $paperclipModule,
                Dzit_IUrlCreator::PARAM_ACTION => $downloadAction,
                Dzit_IUrlCreator::PARAM_PATH_INFO_PARAMS => Array($viewKey, $item->getTimestamp())
        )
        );
        return $url;
    }
}
