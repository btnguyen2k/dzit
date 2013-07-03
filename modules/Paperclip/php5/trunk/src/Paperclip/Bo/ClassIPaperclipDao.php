<?php
interface Paperclip_Bo_IPaperclipDao extends Ddth_Dao_IDao {

    const PARAM_FILE_NAME        = 'file_name';        //(string) logical file name
    const PARAM_STORAGE_DIR      = 'storage_dir';      //(string) storage's root directory
    const PARAM_EXTERNAL_STORAGE = 'external_storage'; //(bool) is file stored outside database table?
    const PARAM_MIMETYPE         = 'mimetype';         //(string)
    const PARAM_STATUS           = 'status';           //(string)
    const PARAM_OWNER            = 'owner';            //(string)
    const PARAM_METADATA         = 'metadata';         //(Array)
    const PARAM_CONTENT          = 'content';          //(binary) source file's content
    const PARAM_FILE_LOCATION    = 'file_location';    //(string) source file's full path

    /**
     * Creates a new attachment.
     *
     * @param string $params
     *            input parameters as a map (see parameter list above)
     * @return Paperclip_Bo_BoPaperclip
     */
    public function createAttachment($params = Array());

    /**
     * Deletes an attachment.
     *
     * @param Paperclip_Bo_BoPaperclip $attachment
     * @param string|Ddth_Commons_File $storageDir
    */
    public function deleteAttachment($attachment, $storageDir);

    /**
     * Gets an attachment by id.
     *
     * @param string $id
     * @return Paperclip_Bo_BoPaperclip
    */
    public function getAttachment($id);

    /**
     * Update an attachment.
     *
     * @param Paperclip_Bo_BoPaperclip $attachment
     * @param string|Ddth_Commons_File $storageDir
    */
    public function updateAttachment($attachment, $storageDir=NULL);
}
