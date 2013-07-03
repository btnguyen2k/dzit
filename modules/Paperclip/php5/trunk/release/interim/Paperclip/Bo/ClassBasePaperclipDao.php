<?php
abstract class Paperclip_Bo_BasePaperclipDao extends Quack_Bo_BaseDao implements Paperclip_Bo_IPaperclipDao {

    public static function calcCacheKeyPaperclip($attachmentOrId) {
        $pcId = ($attachmentOrId instanceof Paperclip_Bo_BoPaperclip) ? $attachmentOrId->getId() : $attachmentOrId;
        return "PAPERCLIP_$pcId";
    }

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     *
     * @see Quack_Bo_BaseDao::getCacheName()
     */
    public function getCacheName() {
        return 'IPaperclipDao';
    }

    /**
     * Invalidates the cache due to change.
     *
     * @param Paperclip_Bo_BoPaperclip $attachment
     */
    protected function invalidateCache($attachment = NULL) {
        if ($attachment !== NULL) {
            $this->deleteFromCache(self::calcCacheKeyPaperclip($attachment));
        }
    }

    /**
     * (non-PHPdoc)
     * @see Paperclip_Bo_IPaperclipDao::updateAttachment()
     */
    public function updateAttachment($attachment, $storageDir=NULL) {
        if ( $attachment->isExternalStorage() ) {
            if ( $storageDir == NULL ) {
                throw new Exception('Storage dir is NULL!');
            }
            $fileContent = $attachment->getFilecontent();
            $destFile = Paperclip_Utils::buildFile($storageDir,
                    $attachment->getMetadataEntry(Paperclip_Bo_BoPaperclip::META_FILE_DISK_NAME),
                    $attachment->getMetadataEntry(Paperclip_Bo_BoPaperclip::META_FILE_DIR)
            );
            Paperclip_Utils::saveToFile($fileContent, $destFile);
            $attachment->setFilecontent(NULL);
        }

        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Paperclip_Bo_BoPaperclip::COL_ID  => $attachment->getId(),
                Paperclip_Bo_BoPaperclip::COL_FILECONTENT => $attachment->getFilecontent(),
                Paperclip_Bo_BoPaperclip::COL_FILESIZE    => $attachment->getFilesize(),
                Paperclip_Bo_BoPaperclip::COL_FILESTATUS  => $attachment->getFilestatus(),
                Paperclip_Bo_BoPaperclip::COL_METADATA    => $attachment->getMetadata(),
                Paperclip_Bo_BoPaperclip::COL_MIMETYPE    => $attachment->getMimetype(),
                Paperclip_Bo_BoPaperclip::COL_OWNER       => $attachment->getOwner(),
                Paperclip_Bo_BoPaperclip::COL_TIMESTAMP   => $attachment->getTimestamp()
        );

        $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($attachment);
    }

    /**
     * (non-PHPdoc)
     * @see Paperclip_Bo_IPaperclipDao::createAttachment()
     */
    public function createAttachment($params = Array()) {
        //verify file content
        if ( !isset($params[Paperclip_Bo_IPaperclipDao::PARAM_CONTENT]) && !isset($params[Paperclip_Bo_IPaperclipDao::PARAM_FILE_LOCATION]) ) {
            return NULL;
        }

        $id = Quack_Util_IdUtils::id64hex(0, 16);
        $timestamp = time();
        $logicalFilename = $params[Paperclip_Bo_IPaperclipDao::PARAM_FILE_NAME];
        $mimetype = $params[Paperclip_Bo_IPaperclipDao::PARAM_MIMETYPE];
        $status = isset($params[Paperclip_Bo_IPaperclipDao::PARAM_STATUS]) ? $params[Paperclip_Bo_IPaperclipDao::PARAM_STATUS] : NULL;
        $owner = isset($params[Paperclip_Bo_IPaperclipDao::PARAM_OWNER]) ? $params[Paperclip_Bo_IPaperclipDao::PARAM_OWNER] : NULL;
        $extraMetadata = isset($params[Paperclip_Bo_IPaperclipDao::PARAM_METADATA]) ? $params[Paperclip_Bo_IPaperclipDao::PARAM_FILENAME] : NULL;
        $metadata = is_array($extraMetadata) ? $extraMetadata : Array();
        $metadata[Paperclip_Bo_BoPaperclip::META_FILENAME] = $filename;

        if ( isset($params[Paperclip_Bo_IPaperclipDao::PARAM_CONTENT]) ) {
            $fileContent = $params[Paperclip_Bo_IPaperclipDao::PARAM_CONTENT];
            $filesize = strlen($content);
        } else if ( isset($params[Paperclip_Bo_IPaperclipDao::PARAM_FILE_LOCATION]) ) {
            $fileLocation = $params[Paperclip_Bo_IPaperclipDao::PARAM_FILE_LOCATION];
            $filesize = filesize($fileLocation);
        }

        if ( isset($params[Paperclip_Bo_IPaperclipDao::PARAM_EXTERNAL_STORAGE]) && $params[Paperclip_Bo_IPaperclipDao::PARAM_EXTERNAL_STORAGE] ) {
            //store file content in external storage
            $metadata[Paperclip_Bo_BoPaperclip::META_EXTERNAL_STORAGE] = TRUE;
            $metadata[Paperclip_Bo_BoPaperclip::META_FILE_DIR] = date('Y/m', $timestamp);
            $metadata[Paperclip_Bo_BoPaperclip::META_FILE_DISK_NAME] = $id . '.' . $pathinfo['extension'];
            $destFile = Paperclip_Utils::buildFile($params[Paperclip_Bo_IPaperclipDao::PARAM_STORAGE_DIR],
                    $metadata[Paperclip_Bo_BoPaperclip::META_FILE_DISK_NAME],
                    $metadata[Paperclip_Bo_BoPaperclip::META_FILE_DIR],
                    TRUE);
            if ( isset($params[Paperclip_Bo_IPaperclipDao::PARAM_CONTENT]) ) {
                Paperclip_Utils::saveToFile($fileContent, $destFile);
                $fileContent = NULL;
            } else if ( isset($params[Paperclip_Bo_IPaperclipDao::PARAM_FILE_LOCATION]) ) {
                $fileLocation = $params[Paperclip_Bo_IPaperclipDao::PARAM_FILE_LOCATION];
                move_uploaded_file($fileLocation, $destFile->getPathname());
                $fileContent = NULL;
            } else {
                //not possible
            }
        } else {
            //store file content in db table
            if ( isset($params[Paperclip_Bo_IPaperclipDao::PARAM_FILE_LOCATION]) ) {
                $fileContent = Paperclip_Utils::getFileContent($fileLocation);
            }
        }

        $sqlParams = Array(Paperclip_Bo_BoPaperclip::COL_ID => $id,
                Paperclip_Bo_BoPaperclip::COL_FILECONTENT   => $fileContent,
                Paperclip_Bo_BoPaperclip::COL_FILESIZE      => $filesize,
                Paperclip_Bo_BoPaperclip::COL_FILESTATUS    => $status,
                Paperclip_Bo_BoPaperclip::COL_METADATA      => json_encode($metadata),
                Paperclip_Bo_BoPaperclip::COL_MIMETYPE      => $mimetype,
                Paperclip_Bo_BoPaperclip::COL_OWNER         => $owner,
                Paperclip_Bo_BoPaperclip::COL_TIMESTAMP     => $timestamp
        );

        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $this->execNonSelect($sqlStm, $sqlParams);
        return $this->getAttachment($id);
    }

    /**
     * (non-PHPdoc)
     * @see Paperclip_Bo_IPaperclipDao::deleteAttachment()
     */
    public function deleteAttachment($attachment) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Paperclip_Bo_BoPaperclip::COL_ID => $attachment->getId());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($attachment);
    }

    /**
     * (non-PHPdoc)
     * @see Paperclip_Bo_IPaperclipDao::getAttachment()
     */
    public function getAttachment($id) {
        if ($id === NULL) {
            return NULL;
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Paperclip_Bo_BoPaperclip::COL_ID => $id);
        $rows = $this->execSelect($sqlStm, $params, NULL, self::calcCacheKeyPaperclip($id));
        if ($rows !== NULL && count($rows) > 0) {
            $result = new Paperclip_Bo_BoPaperclip();
            $result->populate($rows[0]);
        } else {
            $result = NULL;
        }
        return $result;
    }
}
