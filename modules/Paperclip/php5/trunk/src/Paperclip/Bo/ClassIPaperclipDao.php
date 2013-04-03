<?php
interface Paperclip_Bo_IPaperclipDao extends Ddth_Dao_IDao {

    const PARAM_FILENAME      = 'filename';
    const PARAM_MIMETYPE      = 'mimetype';
    const PARAM_STATUS        = 'status';
    const PARAM_OWNER         = 'owner';
    const PARAM_METADATA      = 'metadata';
    const PARAM_CONTENT       = 'content';
    const PARAM_FILE_LOCATION = 'file_location';

    /**
     * Creates a new attachment.
     *
     * @param string $params
     *            input parameters as a map
     * - filename: (required, string) name of the attachment
     * - mimetype: (required, string) MIME type of the attachment
     * - status  : (optional, string) custom file status
     * - owner   : (optional, string) custom file owner
     * - metadata: (optional, array) custom file metadata
     * + content      : (binary) file content
     * + file_location: (string) path to the file on disk
     * required either "content" or "file_location" (only one)
     * @return Paperclip_Bo_BoPaperclip
     */
    public function createAttachment($params = Array());

    /**
     * Deletes an attachment.
     *
     * @param Paperclip_Bo_BoPaperclip $attachment
     */
    public function deleteAttachment($attachment);

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
     */
    public function updateAttachment($attachment);
}
