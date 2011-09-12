<?php
interface Quack_Bo_Session_ISessionDao extends Ddth_Dao_IDao {

    /**
     * Counts number of entries of a session.
     *
     * @param string $sessionId
     * @return int number of session's entries, or FAILSE if error
     */
    public function countEntries($sessionId);

    /**
     * Deletes a session entry.
     *
     * @param string $sessionId
     * @param string $sessionKey
     * @return int number of affected db rows (should be 0 or 1)
     */
    public function deleteEntry($sessionId, $sessionKey);

    /**
     * Gets a session entry's value.
     *
     * @param string $sessionId
     * @param string $sessionKey
     * @return string
     */
    public function getEntry($sessionId, $sessionKey);

    /**
     * Sets a session entry's value.
     *
     * @param string $sessionId
     * @param string $sessionKey
     * @param string $sessionValue
     */
    public function setEntry($sessionId, $sessionKey, $sessionValue);

    /**
     * Fetches a session entry by index.
     *
     * @param string $sessionId
     * @param int $index
     * @return Array an array where the first element is session key, the second element is session value
     */
    public function fetchEntry($sessionId, $index);

    /**
     * Deletes a session.
     *
     * @param string $sessionId
     */
    public function deleteSession($sessionId);

    /**
     * Deletes expired sessions.
     *
     * @param int $maxlifetime
     */
    public function deleteExpiredSessions($maxlifetime);
}
