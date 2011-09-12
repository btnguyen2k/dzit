<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Custom session handler.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Quack
 * @subpackage	Session
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassICache.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Custom session handler class.
 *
 * @package     Quack
 * @subpackage	Session
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Quack_Session_SessionHandler implements Countable, ArrayAccess, Iterator {

    private static $sessionHandler = NULL;

    /**
     * Tests if the custom session handler has started.
     *
     * @return boolean
     */
    public static function isSessionStarted() {
        return self::$sessionHandler !== NULL;
    }

    /**
     * Starts the custom session handler.
     *
     * @param mixed $sessionDao an instance of {@link Quack_Bo_Session_ISessionDao} or name of the session dao
     */
    public static function startSession($sessionDao) {
        if (self::$sessionHandler === NULL) {
            self::$sessionHandler = new Quack_Session_SessionHandler($sessionDao);
            $_SESSION = self::$sessionHandler;
        }
    }

    private $sessionDao = NULL;
    private $index = 0; //used by Iterator, store the current element's index
    private $curElement = NULL; //store the current element's key & value
    private $serialize = 'serialize';
    private $deserialize = 'unserialize';
    private $sessionId = null;

    public function __construct($sessionDao) {
        /* cancel any auto started session */
        session_write_close();

        $this->sessionDao = $sessionDao;
        $handlerOpen = Array(__CLASS__, 'sessionOpen');
        $handlerClose = Array(__CLASS__, 'sessionClose');
        $handlerRead = Array(__CLASS__, 'sessionRead');
        $handlerWrite = Array(__CLASS__, 'sessionWrite');
        $handlerDestroy = Array(__CLASS__, 'sessionDestroy');
        $handlerGc = Array(__CLASS__, 'sessionGc');
        session_set_save_handler($handlerOpen, $handlerClose, $handlerRead, $handlerWrite, $handlerDestroy, $handlerGc);
        session_cache_limiter('no-cache');
        register_shutdown_function('session_write_close');
        session_start();
        $this->sessionId = session_id();
    }

    /**
     * Sets the serializer function.
     *
     * @param string $funcName
     */
    public function setSerializer($funcName) {
        $this->serialize = $funcName;
    }

    /**
     * Sets the deserializer function.
     *
     * @param string $funcName
     */
    public function setDeserializer($funcName) {
        $this->deserialize = $funcName;
    }

    /**
     * Gets the session dao.
     *
     * @return Quack_Bo_Session_ISessionDao
     */
    protected function getSessionDao() {
        if ($this->sessionDao instanceof Quack_Bo_Session_ISessionDao) {
            return $this->sessionDao;
        }
        $this->sessionDao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao($this->sessionDao);
        if ($this->sessionDao instanceof Quack_Bo_Session_ISessionDao) {
            return $this->sessionDao;
        }
        return NULL;
    }

    public static function sessionOpen($save_path, $session_name) {
        return TRUE;
    }

    public static function sessionClose() {
        return TRUE;
    }

    public static function sessionRead($id) {
        return '';
    }

    public static function sessionWrite($id, $sess_data) {
        return TRUE;
    }

    public static function sessionDestroy($id) {
        $dao = $this->getSessionDao();
        if ($dao !== NULL) {
            $dao->deleteSession($this->sessionId);
        }
        return TRUE;
    }

    public static function sessionGc($maxlifetime) {
        $dao = $this->getSessionDao();
        if ($dao !== NULL) {
            $dao->deleteExpiredSessions($maxlifetime);
        }
        return TRUE;
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::current()
     */
    public function current() {
        return call_user_func($this->deserialize, $this->curElement[1]);
    }

    /**
     * Fetches the current element.
     */
    private function fetchCurrentElement() {
        $dao = $this->getSessionDao();
        if ($dao !== NULL) {
            $this->curElement = $dao->fetchEntry($this->sessionId, $this->index);
        }
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::next()
     */
    public function next() {
        $this->index++;
        $this->fetchCurrentElement();
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::key()
     */
    public function key() {
        return $this->curElement[0];
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::valid()
     */
    public function valid() {
        return ($this->curElement[0] !== NULL);
    }

    /**
     * (non-PHPdoc)
     * @see Iterator::rewind()
     */
    public function rewind() {
        $this->index = 0;
        $this->fetchCurrentElement();
    }

    /**
     * Checks if a session's entry exists.
     *
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset) {
        return $this->offsetGet($offset) !== NULL;
    }

    /**
     * Reads an existing session's entry.
     *
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset) {
        $dao = $this->getSessionDao();
        if ($dao !== NULL) {
            $value = $dao->getEntry($this->sessionId, $offset);
            return $value != NULL ? call_user_func($this->deserialize, $value) : NULL;
        }
    }

    /**
     * Creates a new or Replaces an existing session's entry.
     *
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value) {
        $dao = $this->getSessionDao();
        if ($dao !== NULL) {
            $value = call_user_func($this->serialize, $value);
            $dao->setEntry($this->sessionId, $offset, $value);
        }
    }

    /**
     * Deletes a session's entry.
     *
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset) {
        $dao = $this->getSessionDao();
        if ($dao !== NULL) {
            $dao->deleteEntry($this->sessionId, $offset);
        }
    }

    /**
     * Counts session's number of entries.
     *
     * @see Countable::count()
     */
    public function count() {
        $dao = $this->getSessionDao();
        return $dao !== NULL ? $dao->countEntries($this->sessionId) : FALSE;
    }
}