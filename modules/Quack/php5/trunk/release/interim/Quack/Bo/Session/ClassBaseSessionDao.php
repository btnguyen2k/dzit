<?php
abstract class Quack_Bo_Session_BaseSessionDao extends Quack_Bo_BaseDao implements
        Quack_Bo_Session_ISessionDao {

    /* 'virtual' column names */
    const COL_SESSION_ID = 'sessionId';
    const COL_SESSION_KEY = 'sessionKey';
    const COL_SESSION_TIMESTAMP = 'sessionTimestamp';
    const COL_SESSION_VALUE = 'sessionValue';

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
     * @see Quack_Bo_Session_ISessionDao::countEntries()
     */
    public function countEntries($sessionId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId);
        return $this->execCount($sqlStm, $params);
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::deleteEntry()
     */
    public function deleteEntry($sessionId, $sessionKey) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId, self::COL_SESSION_KEY => $sessionKey);
        return $this->execNonQuery($sqlStm, $params);
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::getEntry()
     */
    public function getEntry($sessionId, $sessionKey) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId, self::COL_SESSION_KEY => $sessionKey);
        $rows = $this->execSelect($sqlStm, $params);
        if (count($rows) > 0) {
            return $rows[0][self::COL_SESSION_VALUE];
        } else {
            return NULL;
        }
    }

    protected function createEntry($sessionId, $sessionKey, $sessionValue) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId,
                self::COL_SESSION_KEY => $sessionKey,
                self::COL_SESSION_VALUE => $sessionValue,
                self::COL_SESSION_TIMESTAMP => time());
        return $this->execNonQuery($sqlStm, $params);
    }

    protected function updateEntry($sessionId, $sessionKey, $sessionValue) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId,
                self::COL_SESSION_KEY => $sessionKey,
                self::COL_SESSION_VALUE => $sessionValue,
                self::COL_SESSION_TIMESTAMP => time());
        return $this->execNonQuery($sqlStm, $params);
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::setEntry()
     */
    public function setEntry($sessionId, $sessionKey, $sessionValue) {
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sessionValue = $this->getEntry($sessionId, $sessionKey);
        if ($sessionValue === NULL) {
            $this->createEntry($sessionId, $sessionKey, $sessionValue);
        } else {
            $this->createEntry($sessionId, $sessionKey, $sessionValue);
        }
        $this->closeConnection();
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
        return $this->execNonQuery($sqlStm, $params);
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_Session_ISessionDao::deleteExpiredSessions()
     */
    public function deleteExpiredSessions($maxlifetime) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_TIMESTAMP => time() - $maxlifetime);
        return $this->execNonQuery($sqlStm, $params);
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
        $this->closeConnection();
    }

    protected function createSession($sessionId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId, self::COL_SESSION_TIMESTAMP => time());
        return $this->execNonQuery($sqlStm, $params);
    }

    protected function getSession($sessionId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId);
        $rows = $this->execSelect($sqlStm, $params);
        return count($rows) > 0 ? $rows[0] : NULL;
    }

    protected function updateSession($sessionId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId, self::COL_SESSION_TIMESTAMP => time());
        return $this->execNonQuery($sqlStm, $params);
    }
}
