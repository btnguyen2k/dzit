<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Abstract/Base implementation of {@link Quack_Bo_SessionS_ISessionDao}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Quack
 * @subpackage	Bo
 * @subpackage 	SessionS
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.1
 */

/**
 * Abstract/Base implementation of {@link Quack_Bo_SessionS_ISessionDao}.
 *
 * @package     Quack
 * @subpackage	Bo
 * @subpackage	SessionS
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
abstract class Quack_Bo_SessionS_BaseSessionDao extends Quack_Bo_BaseDao implements
        Quack_Bo_SessionS_ISessionDao {

    /* Virtual columns */
    const COL_SESSION_ID = 'session_id';
    const COL_SESSION_TIMESTAMP = 'session_timestamp';
    const COL_SESSION_DATA = 'session_data';

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * @see Quack_Bo_SessionS_ISessionDao::deleteExpiredSessions()
     */
    public function deleteExpiredSessions($maxlifetime) {
        if ($this->LOGGER->isDebugEnabled()) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Expiry: {$maxlifetime}";
            $this->LOGGER->debug($msg);
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_TIMESTAMP => time() + $maxlifetime);
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    }

    /**
     * @see Quack_Bo_SessionS_ISessionDao::deleteSession()
     */
    public function deleteSession($id) {
        if ($this->LOGGER->isDebugEnabled()) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Session Id: {$id}";
            $this->LOGGER->debug($msg);
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $id);
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    }

    /**
     * @see Quack_Bo_SessionS_ISessionDao::readSession()
     */
    public function readSession($id) {
        if ($this->LOGGER->isDebugEnabled()) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Session Id: {$id}";
            $this->LOGGER->debug($msg);
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $id);
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            return $rows[0][self::COL_SESSION_DATA];
        }
        return NULL;
    }

    protected function updateSession($id, $data) {
        if ($this->LOGGER->isDebugEnabled()) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Session Id: {$id}/Data: {$data}";
            $this->LOGGER->debug($msg);
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $id,
                self::COL_SESSION_DATA => $data,
                self::COL_SESSION_TIMESTAMP => time());
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    }

    protected function createSession($id, $data) {
        if ($this->LOGGER->isDebugEnabled()) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Session Id: {$id}/Data: {$data}";
            $this->LOGGER->debug($msg);
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $id,
                self::COL_SESSION_DATA => $data,
                self::COL_SESSION_TIMESTAMP => time());
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    }

    /**
     * @see Quack_Bo_SessionS_ISessionDao::writeSession()
     */
    public function writeSession($id, $data) {
        if ($this->LOGGER->isDebugEnabled()) {
            $msg = '[' . __CLASS__ . '::' . __FUNCTION__ . "]Session Id: {$id}/Data: {$data}";
            $this->LOGGER->debug($msg);
        }
        $result = $this->updateSession($id, $data);
        if ($result === FALSE || $result < 1) {
            $result = $this->createSession($id, $data);
        }
        return $result;
    }
}
