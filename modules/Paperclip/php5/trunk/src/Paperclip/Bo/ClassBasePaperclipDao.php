<?php
abstract class Paperclip_Bo_BasePaperclipDao extends Quack_Bo_BaseDao implements
Paperclip_Bo_IPaperclipDao {

    /**
     *
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

    protected function createCacheKeyPcId($pcId) {
        return $pcId;
    }

    /**
     * Invalidates the cache due to change.
     *
     * @param Paperclip_Bo_BoPaperclip $user
     */
    protected function invalidateCache($pc = NULL) {
        if ($pc !== NULL) {
            $pcId = $pc->getId();
            $this->deleteFromCache($this->createCacheKeyPcId($pcId));
        }
    }

    /**
     *
     * @see Paperclip_Bo_IPaperclipDao::createAttachment()
     */
    // public function createAttachment($pathToFileContent, $filename,
    // $mimeType, $isDraft = FALSE, $thumbnail = NULL) {
    public function createAttachment($params = Array()) {
        //file content
        if ( isset($params[Paperclip_Bo_IPaperclipDao::PARAM_CONTENT]) ) {
            $content = $params[Paperclip_Bo_IPaperclipDao::PARAM_CONTENT];
            $filesize = strlen($content);
        } else if ( isset($params[Paperclip_Bo_IPaperclipDao::PARAM_FILE_LOCATION]) ) {
            $filelocation = $params[Paperclip_Bo_IPaperclipDao::PARAM_FILE_LOCATION];
            $filesize = filesize($filelocation);
            $content = Paperclip_Utils::getFileContent($filelocation);
        } else {
            return NULL;
        }

        // $id = uniqid('', TRUE);
        $id = Quack_Util_IdUtils::id64hex(0, 16);
        $timestamp = time();
        $filename = $params[Paperclip_Bo_IPaperclipDao::PARAM_FILENAME];
        $mimetype = $params[Paperclip_Bo_IPaperclipDao::PARAM_MIMETYPE];
        $status = isset($params[Paperclip_Bo_IPaperclipDao::PARAM_STATUS]) ? $params[Paperclip_Bo_IPaperclipDao::PARAM_STATUS] : NULL;
        $owner = isset($params[Paperclip_Bo_IPaperclipDao::PARAM_OWNER]) ? $params[Paperclip_Bo_IPaperclipDao::PARAM_OWNER] : NULL;
        $extraMetadata = isset($params[Paperclip_Bo_IPaperclipDao::PARAM_METADATA]) ? $params[Paperclip_Bo_IPaperclipDao::PARAM_FILENAME] : NULL;
        $metadata = is_array($extraMetadata) ? $extraMetadata : Array();
        $metadata[Paperclip_Bo_BoPaperclip::META_FILENAME] = $filename;

        $sqlParams = Array(Paperclip_Bo_BoPaperclip::COL_ID=>$id,
                Paperclip_Bo_BoPaperclip::COL_FILECONTENT=>$content,
                Paperclip_Bo_BoPaperclip::COL_FILESIZE=>$filesize,
                Paperclip_Bo_BoPaperclip::COL_FILESTATUS=>$status,
                Paperclip_Bo_BoPaperclip::COL_METADATA=>json_encode($metadata),
                Paperclip_Bo_BoPaperclip::COL_MIMETYPE=>$mimetype,
                Paperclip_Bo_BoPaperclip::COL_OWNER=>$owner,
                Paperclip_Bo_BoPaperclip::COL_TIMESTAMP=>$timestamp
        );

        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $this->execNonSelect($sqlStm, $sqlParams);
        return $this->getAttachment($id);
    }

    /**
     *
     * @see Paperclip_Bo_IPaperclipDao::deleteAttachment()
     */
    public function deleteAttachment($attachment) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Paperclip_Bo_BoPaperclip::COL_ID => $attachment->getId());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($attachment);
    }

    /**
     *
     * @see Paperclip_Bo_IPaperclipDao::getAttachment()
     */
    public function getAttachment($id) {
        if ($id === NULL) {
            return NULL;
        }
        $cacheKey = $this->createCacheKeyPcId($id);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Paperclip_Bo_BoPaperclip::COL_ID => $id);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Paperclip_Bo_BoPaperclip();
                $result->populate($rows[0]);
            }
        }
        /*
        $timestamp = time();
        $attchment = ($result instanceof Ddth_Cache_CacheEntry) ? $result->getValue() : $result;
        if ($attchment !== NULL && $attchment->getTimestamp() + 24 * 3600 < $timestamp) {
            // update timestamp if needed
            $attchment->setTimestamp($timestamp);
            $this->updateAttachment($attchment);
            $this->putToCache($cacheKey, $attchment);
        }
        */
        return $this->returnCachedResult($result, $cacheKey);
    }

    /**
     *
     * @see Paperclip_Bo_IPaperclipDao::updateAttachment()
     */
    public function updateAttachment($attachment) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Paperclip_Bo_BoPaperclip::COL_ID => $attachment->getId(),
                Paperclip_Bo_BoPaperclip::COL_FILENAME => $attachment->getFilename(),
                Paperclip_Bo_BoPaperclip::COL_FILESIZE => $attachment->getFilesize(),
                Paperclip_Bo_BoPaperclip::COL_FILECONTENT => $attachment->getFilecontent(),
                Paperclip_Bo_BoPaperclip::COL_IMG_WIDTH => $attachment->getImgWidth(),
                Paperclip_Bo_BoPaperclip::COL_IMG_HEIGHT => $attachment->getImgHeight(),
                Paperclip_Bo_BoPaperclip::COL_THUMBNAIL => $attachment->getThumbnail(),
                Paperclip_Bo_BoPaperclip::COL_MIMETYPE => $attachment->getMimetype(),
                Paperclip_Bo_BoPaperclip::COL_TIMESTAMP => $attachment->getTimestamp(),
                Paperclip_Bo_BoPaperclip::COL_IS_DRAFT => $attachment->isDraft() ? 1 : 0);
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($attachment);
    }
}
