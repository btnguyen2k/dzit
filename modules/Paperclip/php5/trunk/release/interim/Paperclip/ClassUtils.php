<?php
class Paperclip_Utils {

    /**
     * Builds file from root directory, partition directory and file name.
     *
     * @param string|Ddth_Commons_File $rootDir
     * @param string $filename
     * @param string $partitionDir
     * @param bool $autoCreateDir
     * @param int $dirUnixMode
     * @return Ddth_Commons_File
     */
    public static function buildFile($rootDir, $filename, $partitionDir=NULL, $autoCreateDir=FALSE, $dirUnixMode=0711) {
        $parent = $partitionDir!=NULL ? new Ddth_Commons_File($partitionDir, $rootDir) : $rootDir;
        if ( $autoCreateDir ) {
            mkdir($parent->getPathname(), $dirUnixMode, TRUE);
        }
        return new Ddth_Commons_File($filename, $parent);
    }

    /**
     * Saves content to file.
     *
     * @param string $binContent
     * @param string|Ddth_Commons_File $file
     */
    public static function saveToFile($binContent, $file) {
        $filename = $file instanceof Ddth_Commons_File ? $file->getPathname() : $file;
        $fp = fopen($filename, 'wb');
        fwrite($fp, $binContent);
        fclose($fp);
    }

    private static function getDao($name) {
        return Ddth_Dao_BaseDaoFactory::getInstance()->getDao($name);
    }

    /**
     * Reads file content and returns it as binary string.
     *
     * @param string|Ddth_Commons_File $file
     * @return string
     */
    public static function getFileContent($file) {
        $filepath = $file instanceof Ddth_Commons_File ? $file->getPathname() : $file;
        $filesize = filesize($filepath);
        $fp = fopen($filepath, 'rb');
        $fileContent = fread($fp, $filesize);
        fclose($fp);
        return $fileContent;
    }

    const ATTR_ID = 'id';
    const ATTR_ONETIME = 'onetime';
    const ATTR_TIMESTAMP = 'timestamp';
    const ATTR_STORAGE_DIR = 'storage_dir';

    /**
     * Creates a URL to view a paperclip item (Dzit framework compatible URL).
     *
     * @param Paperclip_Bo_BoPaperclip $attachment
     * @param Paperclip_Bo_IPaperclipDao $paperclipDao
     * @param Dzit_IUrlCreator $urlCreator
     * @param string $paperclipModule='paperclip'
     * @param string $viewAction='view'
     * @param boolean $absoluteUrl to generate absolute URL or relative URL
     * @param boolean $onetimeView
     *            set to TRUE to make the URL one-time-use
     * @param string $storageDir external storage directory
     * @return string the URL or NULL
     */
    public static function createUrlView($attachment, $urlCreator, $paperclipModule='paperclip', $viewAction='view',
            $absoluteUrl=FALSE, $onetimeView=FALSE, $storageDir=NULL) {
        $viewEntry = Array(self::ATTR_ID=>$attachment->getId(), self::ATTR_ONETIME=>$onetimeView, self::ATTR_TIMESTAMP=>time());
        if ( $attachment->isExternalStorage() && $storageDir != NULL ) {
            $viewEntry[self::ATTR_STORAGE_DIR] = $storageDir;
        }
        $viewKey = md5("view$id");
        $_SESSION["PAPERCLIP_$viewKey"] = $viewEntry;
        $url = $urlCreator->createUrl(Array(
                Dzit_IUrlCreator::PARAM_MODULE           => $paperclipModule,
                Dzit_IUrlCreator::PARAM_ACTION           => $viewAction,
                Dzit_IUrlCreator::PARAM_PATH_INFO_PARAMS => Array($viewKey, $attachment->getTimestamp()),
                Dzit_IUrlCreator::PARAM_FULL_URL         => $absoluteUrl
            )
        );
        return $url;
    }

    /**
     * Creates a URL to download a paperclip item (Dzit framework compatible URL).
     *
     * @param Paperclip_Bo_BoPaperclip $attachment
     * @param Paperclip_Bo_IPaperclipDao $paperclipDao
     * @param Dzit_IUrlCreator $urlCreator
     * @param string $paperclipModule='paperclip'
     * @param string $downloadAction='download'
     * @param boolean $absoluteUrl to generate absolute URL or relative URL
     * @param boolean $onetimeView
     *            set to TRUE to make the URL one-time-use
     * @param string $storageDir external storage directory
     * @return string the URL or NULL
     */
    public static function createUrlDownload($attachment, $urlCreator, $paperclipModule='paperclip', $downloadAction='download',
            $absoluteUrl=FALSE, $onetimeView=FALSE, $storageDir=NULL) {
        $viewEntry = Array(self::ATTR_ID=>$attachment->getId(), self::ATTR_ONETIME=>$onetimeView, self::ATTR_TIMESTAMP=>time());
        if ( $attachment->isExternalStorage() && $storageDir != NULL ) {
            $viewEntry[self::ATTR_STORAGE_DIR] = $storageDir;
        }
        $viewKey = md5("download$id");
        if ( !isset($_SESSION["PAPERCLIP_$viewKey"]) ) {
            $_SESSION["PAPERCLIP_$viewKey"] = $viewEntry;
        }
        $url = $urlCreator->createUrl(Array(
                Dzit_IUrlCreator::PARAM_MODULE           => $paperclipModule,
                Dzit_IUrlCreator::PARAM_ACTION           => $downloadAction,
                Dzit_IUrlCreator::PARAM_PATH_INFO_PARAMS => Array($viewKey, $attachment->getTimestamp()),
                Dzit_IUrlCreator::PARAM_FULL_URL         => $absoluteUrl
            )
        );
        return $url;
    }
}
