<?php
abstract class Quack_Bo_Session_BaseSessionDao extends Quack_Bo_BaseDao implements
        Quack_Bo_Session_ISessionDao {

    /* 'virtual' column names */
    const COL_SESSION_ID = 'sessionId';
    const COL_SESSION_KEY = 'sessionKey';
    const COL_SESSION_TIMESTAMP = 'sessionTimestamp';
    const COL_SESSION_VALUE = 'sessionValue';

    const CACHE_KEY_COUNT_ENTRY = 'SESSION_COUNT_ENTRY';
    const CACHE_KEY_SESSION = 'SESSION';
    const CACHE_KEY_SESSION_ENTRY = 'SESSION_ENTRY';

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * Invalidates cache due to changes.
     *
     * @param string $sessionId
     * @param string $sessionKey
     */
    protected function invalidateCache($sessionId, $sessionKey = NULL) {
        if ($sessionKey !== NULL) {
            $this->deleteFromCache(self::CACHE_KEY_SESSION_ENTRY . "_$sessionKey");
        } else {
            $this->deleteFromCache(self::CACHE_KEY_COUNT_ENTRY . "_$sessionId");
            $this->deleteFromCache(self::CACHE_KEY_SESSION . "_$sessionId");
        }
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::countEntries()
     */
    public function countEntries($sessionId) {
        $cacheKey = self::CACHE_KEY_COUNT_ENTRY . "_$sessionId";
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(self::COL_SESSION_ID => $sessionId);
            $result = $this->execCount($sqlStm, $params);
            $this->putToCache($cacheKey, $result);
        }
        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::deleteEntry()
     */
    public function deleteEntry($sessionId, $sessionKey) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId, self::COL_SESSION_KEY => $sessionKey);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($sessionId, $sessionKey);
        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::getEntry()
     */
    public function getEntry($sessionId, $sessionKey) {
        $session = $this->getSession($sessionId);
        if ($session === NULL) {
            //if there is no session then there is no session entry
            return NULL;
        }
        $cacheKey = self::CACHE_KEY_SESSION_ENTRY . "_$sessionId" . "_$sessionKey";
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(self::COL_SESSION_ID => $sessionId,
                    self::COL_SESSION_KEY => $sessionKey);
            $rows = $this->execSelect($sqlStm, $params);
            if (count($rows) > 0) {
                $result = $rows[0][self::COL_SESSION_VALUE];
                $this->putToCache($cacheKey, $result);
            } else {
                return NULL;
            }
        }
        return $result;
    }

    protected function createEntry($sessionId, $sessionKey, $sessionValue) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId,
                self::COL_SESSION_KEY => $sessionKey,
                self::COL_SESSION_VALUE => $sessionValue,
                self::COL_SESSION_TIMESTAMP => time());
        return $this->execNonSelect($sqlStm, $params);
    }

    protected function updateEntry($sessionId, $sessionKey, $sessionValue) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId,
                self::COL_SESSION_KEY => $sessionKey,
                self::COL_SESSION_VALUE => $sessionValue,
                self::COL_SESSION_TIMESTAMP => time());
        $result = $this->execNonSelect($sqlStm, $params);
        //refresh the cache
        $this->invalidateCache($sessionId, $sessionKey);
        $sessionEntry = $this->getEntry($sessionId, $sessionKey);
        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::setEntry()
     */
    public function setEntry($sessionId, $sessionKey, $sessionValue) {
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();

        if ($sessionValue === NULL) {
            $this->deleteEntry($sessionId, $sessionKey);
        } else {
            if ($this->getSession($sessionId) !== NULL) {
                $value = $this->getEntry($sessionId, $sessionKey);
                if ($value === NULL) {
                    $this->createEntry($sessionId, $sessionKey, $sessionValue);
                } else if ($value !== $sessionValue) {
                    $this->updateEntry($sessionId, $sessionKey, $sessionValue);
                }
            }
        }

        $this->closeConnection(FALSE);
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::fetchEntry()
     */
    public function fetchEntry($sessionId, $index) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId, 'index' => $index);
        $rows = $this->execSelect($sqlStm, $params);
        if (count($rows) > 0) {
            return Array($rows[0][self::COL_SESSION_KEY], $rows[0][self::COL_SESSION_VALUE]);
        } else {
            return NULL;
        }
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::deleteSession()
     */
    public function deleteSession($sessionId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($sessionId);
        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::deleteExpiredSessions()
     */
    public function deleteExpiredSessions($maxlifetime) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_TIMESTAMP => time() - $maxlifetime);
        return $this->execNonSelect($sqlStm, $params);
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::startSession()
     */
    public function startSession($sessionId) {
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();

        $updateResult = $this->updateSession($sessionId);
        if ($updateResult === FALSE || $updateResult <= 0) {
            $this->createSession($sessionId);
        }

        $this->closeConnection(FALSE);
    }

    protected function createSession($sessionId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId, self::COL_SESSION_TIMESTAMP => time());
        return $this->execNonSelect($sqlStm, $params);
    }

    protected function getSession($sessionId) {
        $cacheKey = self::CACHE_KEY_SESSION . "_$sessionId";
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(self::COL_SESSION_ID => $sessionId);
            $rows = $this->execSelect($sqlStm, $params);
            $result = count($rows) > 0 ? $rows[0] : NULL;
            if ($result !== NULL) {
                $this->putToCache($cacheKey, $result);
            }
        }
        return $result;
    }

    protected function updateSession($sessionId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId, self::COL_SESSION_TIMESTAMP => time());
        $result = $this->execNonSelect($sqlStm, $params);
        //refresh cache
        $this->invalidateCache($sessionId);
        $session = $this->getSession($sessionId);
        return $result;
    }
}
