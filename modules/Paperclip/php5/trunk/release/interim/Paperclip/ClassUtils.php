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
        $id = $attachment->getId();
        $viewEntry = Array(self::ATTR_ID=>$id, self::ATTR_ONETIME=>$onetimeView, self::ATTR_TIMESTAMP=>time());
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
        $id = $attachment->getId();
        $viewEntry = Array(self::ATTR_ID=>$id, self::ATTR_ONETIME=>$onetimeView, self::ATTR_TIMESTAMP=>time());
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

    /*
     * (required|string) Name of the form's file field.
    */
    const PAPERCLIP_FORM_FIELDNAME    = 'form_fieldname';
    /*
     * (required|Paperclip_Bo_IPaperclipDao) Paperclip dao
    */
    const PAPERCLIP_DAO               = 'dao';
    /*
     * (optional|string) Path to the external storage directory, default: NULL
    */
    const PAPERCLIP_STORAGE_DIR       = 'storage_dir';
    /*
     * (optional|int) Maximum allowed file size, default: 0
    */
    const PAPERCLIP_MAX_FILESIZE      = 'max_filesize';
    /*
     * (optional|string or array) Allowed file type (extension) list, default: *
    */
    const PAPERCLIP_ALLOWED_FILETYPES = 'allowed_filetypes';
    /*
     * (optional|string) Initial/update file status, default: NULL
    */
    const PAPERCLIP_STATUS            = 'status';
    /*
     * (optional|string) Existing paperclip id, default: NULL
    */
    const PAPERCLIP_EXISTING_ID       = 'existing_id';

    const PAPERCLIP_ERROR               =   -1; //general error
    const PAPERCLIP_ERROR_FILESIZE_INI  =    1; //file size error (INI setting)
    const PAPERCLIP_ERROR_FILESIZE_FORM =    2; //file size error (Form setting)
    const PAPERCLIP_ERROR_FILESIZE      = 1003; //file size error (Application setting)
    const PAPERCLIP_ERROR_FILETYPE      = 1001; //file type error (Application setting)

    /**
     * Utility function to handle uploaded file.
     *
     * @param Array $params see the parameter list above
     * @return array|Paperclip_Bo_BoPaperclip a Paperclip_Bo_BoPaperclip object if successful,
     *     error array if error, or NULL if no file uploaded.
     *     - [PAPERCLIP_ERROR]: general error
     *     - [PAPERCLIP_ERROR_FILESIZE_INI, max_allowed_filesize, actual_filesize]: file size error (actual_filesize may not be accurate)
     *     - [PAPERCLIP_ERROR_FILESIZE_FORM, max_allowed_filesize, actual_filesize]: file size error (max_allowed_filesize and actual_filesize may not be accurate)
     *     - [PAPERCLIP_ERROR_FILESIZE, max_allowed_filesize, actual_filesize]: file size error
     *     - [PAPERCLIP_ERROR_FILETYPE, upload_filename]: file type error
     */
    public static function processUploadFile($params = Array()) {
        $formFieldName = isset($params[self::PAPERCLIP_FORM_FIELDNAME]) ? $params[self::PAPERCLIP_FORM_FIELDNAME] : NULL;
        if ( $formFieldName==NULL || !isset($_FILES[$formFieldName]) || $_FILES[$formFieldName]['error'] === UPLOAD_ERR_NO_FILE ) {
            return NULL;
        }

        $file = $_FILES[$formFieldName];

        //validate file size
        if ( $file['error'] == UPLOAD_ERR_INI_SIZE ) {
            return Array(self::PAPERCLIP_ERROR_FILESIZE_INI, ini_get('upload_max_filesize'), $file['size']);
        }
        if ( $file['error'] == UPLOAD_ERR_FORM_SIZE ) {
            $maxFileSize = isset($_POST['MAX_FILE_SIZE']) ? $_POST['MAX_FILE_SIZE'] : 0;
            return Array(self::PAPERCLIP_ERROR_FILESIZE_FORM, $maxFileSize, $file['size']);
        }
        $maxFileSize = isset($params[self::PAPERCLIP_MAX_FILESIZE]) ? (int)$params[self::PAPERCLIP_MAX_FILESIZE] : 0;
        if ( $maxFileSize > 0 && $file['size'] > $maxFileSize ) {
            return Array(self::PAPERCLIP_ERROR_FILESIZE, $maxFileSize, $file['size']);
        }

        //validate file type
        $allowedFileTypes = isset($params[self::PAPERCLIP_ALLOWED_FILETYPES]) ? $params[self::PAPERCLIP_ALLOWED_FILETYPES] : Array('*');
        if ( !is_array($allowedFileTypes) ) {
            $allowedFileTypes = Array($allowedFileTypes);
        }
        if ( !self::isValidFileExtension($file['name'], $allowedFileTypes) ) {
            return Array(self::PAPERCLIP_ERROR_FILETYPE, $file['name']);
        }

        //last validation
        if ( $file['error'] ) {
            return Array(self::PAPERCLIP_ERROR);
        }

        // generate file name
        $pathinfo = pathinfo($file['name']);
        if (!isset($pathinfo['extension'])) {
            $pathinfo['extension'] = '';
        }
        $filename = str_replace('.', '_', uniqid('', TRUE));
        if (strlen($pathinfo['extension']) > 0 && strlen($pathinfo['extension']) < 5) {
            $filename = $filename . '.' . strtolower($pathinfo['extension']);
        }

        $storageDir = isset($params[self::PAPERCLIP_STORAGE_DIR]) ? $params[self::PAPERCLIP_STORAGE_DIR] : NULL;
        $status = isset($params[self::PAPERCLIP_STATUS]) ? $params[self::PAPERCLIP_STATUS] : '';

        $paperclipDao = $params[self::PAPERCLIP_DAO];
        $paperclipItemId = isset($params[self::PAPERCLIP_EXISTING_ID]) ? $params[self::PAPERCLIP_EXISTING_ID] : NULL;
        $paperclipItem = $paperclipItemId !== NULL ? $paperclipDao->getAttachment($paperclipItemId) : NULL;
        if ($paperclipItem === NULL) {
            $paperclipItem = $paperclipDao->createAttachment(Array(
                    Paperclip_Bo_IPaperclipDao::PARAM_FILE_NAME        => $filename,
                    Paperclip_Bo_IPaperclipDao::PARAM_EXTERNAL_STORAGE => $storageDir!=NULL,
                    Paperclip_Bo_IPaperclipDao::PARAM_STORAGE_DIR      => $storageDir,
                    Paperclip_Bo_IPaperclipDao::PARAM_FILE_LOCATION    => $file['tmp_name'],
                    Paperclip_Bo_IPaperclipDao::PARAM_MIMETYPE         => $file['type'],
                    Paperclip_Bo_IPaperclipDao::PARAM_STATUS           => $status,
            )
            );
        } else {
            $filecontent = self::getFileContent($file['tmp_name']);
            $paperclipItem->setFilecontent($filecontent);
            $paperclipItem->setFilesize($file['size']);
            $paperclipItem->setMimetype($file['type']);
            $paperclipItem->setTimestamp(time());
            $paperclipItem->setFilestatus($status);
            $paperclipItem = $paperclipDao->updateAttachment($paperclipItem, $storageDir);
        }
        return $paperclipItem;
    }

    /**
     * Checks if a filename is in allowed list of file extensions.
     *
     * @param string $filename
     * @param string|array $allowedFileExtensions
     */
    public static function isValidFileExtension($filename, $allowedFileExtensions=Array('*')) {
        if ( !is_array($allowedFileExtensions) ) {
            $allowedFileExtensions = preg_split('/[,:;]+/', strtolower($allowedFileExtensions));
        }
        $pathinfo = pathinfo(strtolower($filename));
        if (!isset($pathinfo['extension'])) {
            $pathinfo['extension'] = '';
        }
        foreach ($allowedFileExtensions as $ext) {
            if ( $ext == '*' || $ext == '.*' ) {
                return TRUE;
            }
            $index = strrpos($ext, '.');
            if ($index >= 0) {
                $ext = substr($ext, $index + 1);
            }
            if ($ext == $pathinfo['extension']) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
