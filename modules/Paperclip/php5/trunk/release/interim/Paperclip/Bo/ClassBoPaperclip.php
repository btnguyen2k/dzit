<?php
class Paperclip_Bo_BoPaperclip extends Quack_Bo_BaseBo {

    const META_FILE_NAME          = 'file_name';        //(string) logical file name
    const META_FILE_DISK_NAME     = 'file_disk_name';   //(string) file on disk
    const META_FILE_DIR           = 'file_dir';         //(string) sub-directory (if any) that stores file on disk
    const META_EXTERNAL_STORAGE   = 'external_storage'; //(bool) is file stored outside database table?

    const COL_ID = 'pc_id';
    const COL_TIMESTAMP = 'pc_timestamp';
    const COL_FILESIZE = 'pc_filesize';
    const COL_FILESTATUS = 'pc_filestatus';
    const COL_FILECONTENT = 'pc_filecontent';
    const COL_MIMETYPE = 'pc_mimetype';
    const COL_OWNER = 'pc_owner';
    const COL_METADATA = 'pc_metadata';

    private $id;
    private $timestamp;
    private $filesize;
    private $filestatus;
    private $filecontent;
    private $mimetype;
    private $owner;
    private $metadata;
    private $objMetadata = NULL;

    /**
     *
     * @see Quack_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_ID => Array('id'),
                self::COL_FILECONTENT => Array('filecontent'),
                self::COL_FILESIZE => Array('filesize', self::TYPE_INT),
                self::COL_FILESTATUS => Array('filestatus'),
                self::COL_METADATA => Array('metadata'),
                self::COL_MIMETYPE => Array('mimetype'),
                self::COL_OWNER => Array('owner'),
                self::COL_TIMESTAMP => Array('timestamp', self::TYPE_INT));
    }

    /**
     * Getter for $id.
     *
     * @return field_type
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Getter for $timestamp.
     *
     * @return field_type
     */
    public function getTimestamp() {
        return $this->timestamp;
    }

    /**
     * Getter for $filesize.
     *
     * @return field_type
     */
    public function getFilesize() {
        return $this->filesize;
    }

    /**
     * Getter for $filestatus.
     *
     * @return field_type
     */
    public function getFilestatus() {
        return $this->filestatus;
    }

    /**
     * Getter for $filecontent.
     *
     * @return field_type
     */
    public function getFilecontent() {
        return $this->filecontent;
    }

    /**
     * Getter for $mimetype.
     *
     * @return field_type
     */
    public function getMimetype() {
        return $this->mimetype;
    }

    /**
     * Getter for $owner.
     *
     * @return field_type
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * Getter for $metadata.
     *
     * @return field_type
     */
    public function getMetadata() {
        return $this->metadata;
    }

    /**
     * Setter for $id.
     *
     * @param field_type $id
     * @return this object
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Setter for $timestamp.
     *
     * @param field_type $timestamp
     * @return this object
     */
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Setter for $filesize.
     *
     * @param field_type $filesize
     * @return this object
     */
    public function setFilesize($filesize) {
        $this->filesize = $filesize;
        return $this;
    }

    /**
     * Setter for $filestatus.
     *
     * @param field_type $filestatus
     * @return this object
     */
    public function setFilestatus($filestatus) {
        $this->filestatus = $filestatus;
        return $this;
    }

    /**
     * Setter for $filecontent.
     *
     * @param field_type $filecontent
     * @return this object
     */
    public function setFilecontent($filecontent) {
        $this->filecontent = $filecontent;
        return $this;
    }

    /**
     * Setter for $mimetype.
     *
     * @param field_type $mimetype
     * @return this object
     */
    public function setMimetype($mimetype) {
        $this->mimetype = $mimetype;
        return $this;
    }

    /**
     * Setter for $owner.
     *
     * @param field_type $owner
     * @return this object
     */
    public function setOwner($owner) {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Setter for $metadata.
     *
     * @param field_type $metadata
     * @return this object
     */
    public function setMetadata($metadata) {
        $this->metadata = $metadata;
        $this->objMetadata = json_decode($this->metadata, TRUE);
        return $this;
    }

    public function getMetadataEntry($name) {
        return isset($this->objMetadata[$name]) ? $this->objMetadata[$name] : NULL;
    }

    public function setMetadataEntry($name, $value) {
        $this->objMetadata[$name] = $value;
        $this->metadata = json_encode($this->objMetadata);
        return $this;
    }

    public function removeMetadataEntry($name) {
        if (isset($this->objMetadata[$name])) {
            unset($this->objMetadata[$name]);
            $this->metadata = json_encode($this->objMetadata);
        }
        return $this;
    }

    public function isExternalStorage() {
        $externalStorage = $this->getMetadataEntry(self::META_EXTERNAL_STORAGE);
        return $externalStorage != NULL && $externalStorage;
    }
}
