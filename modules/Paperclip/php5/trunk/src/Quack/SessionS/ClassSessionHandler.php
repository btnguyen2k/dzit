<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Custom session handler.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package Quack
 * @subpackage SessionS
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version $Id: ClassICache.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since File available since v0.1
 */

/**
 * Custom session handler class.
 *
 * This custom handler should be used together with package Quack::Bo::SessionS.
 * The whole session array is stored in a single field in the persistent
 * storage.
 *
 * Ref: http://www.daniweb.com/web-development/php/code/216305
 *
 * @package Quack
 * @subpackage SessionS
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Quack_SessionS_SessionHandler {

    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private static $LOGGER;

    /**
     *
     * @var boolean
     */
    private $alive = TRUE;

    /**
     *
     * @var Quack_Bo_SessionS_ISessionDao
     */
    private $sessionDao = NULL;

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
     * @param mixed $sessionDao
     *            an instance of {@link Quack_Bo_SessionS_ISessionDao} or name
     *            of the session dao
     */
    public static function startSession($sessionDao) {
        if (self::$sessionHandler === NULL) {
            self::$sessionHandler = new Quack_SessionS_SessionHandler($sessionDao);
            session_start();
        }
    }

    public function __construct($sessionDao) {
        self::$LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        self::$LOGGER->debug("Session Dao: [$sessionDao]");

        $this->sessionDao = $sessionDao;
        if (!($this->sessionDao instanceof Quack_Bo_SessionS_ISessionDao)) {
            $this->sessionDao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao($sessionDao);
        }
        if (!($this->sessionDao instanceof Quack_Bo_SessionS_ISessionDao)) {
            $msg = "[$sessionDao] is not instance of Quack_Bo_SessionS_ISessionDao!";
            throw new Exception($msg);
        }

        $handlerOpen = Array(__CLASS__, 'sessionOpen');
        $handlerClose = Array(__CLASS__, 'sessionClose');
        $handlerRead = Array(__CLASS__, 'sessionRead');
        $handlerWrite = Array(__CLASS__, 'sessionWrite');
        $handlerDestroy = Array(__CLASS__, 'sessionDestroy');
        $handlerGc = Array(__CLASS__, 'sessionGc');
        session_set_save_handler($handlerOpen, $handlerClose, $handlerRead, $handlerWrite, $handlerDestroy, $handlerGc);
        session_cache_limiter('no-cache');
    }

    public function __destruct() {
        if ($this->alive) {
            session_write_close();
            $this->alive = FALSE;
        }
    }

    /**
     * Gets the session dao.
     *
     * @return Quack_Bo_Session_ISessionDao
     */
    protected function getSessionDao() {
        return $this->sessionDao;
    }

    /*
     * Open function, this works like a constructor in classes and is executed
     * when the session is being opened. The open function expects two
     * parameters, where the first is the save path and the second is the
     * session name.
     */
    public static function sessionOpen($save_path, $session_name) {
        return TRUE;
    }

    /*
     * Close function, this works like a destructor in classes and is executed
     * when the session operation is done.
     */
    public static function sessionClose() {
        return TRUE;
    }

    /*
     * Read function must return string value always to make save handler work
     * as expected. Return empty string if there is no data to read. Return
     * values from other handlers are converted to boolean expression. TRUE for
     * success, FALSE for failure.
     */
    public static function sessionRead($id) {
        $sessionData = self::$sessionHandler->getSessionDao()->readSession($id);
        return $sessionData !== NULL ? $sessionData : '';
    }

    /*
     * Write function that is called when session data is to be saved. This
     * function expects two parameters: an identifier and the data associated
     * with it.
     */
    public static function sessionWrite($id, $sess_data) {
        self::$sessionHandler->getSessionDao()->writeSession($id, $sess_data);
        return TRUE;
    }

    /*
     * The destroy handler, this is executed when a session is destroyed with
     * session_destroy() and takes the session id as its only parameter.
     */
    public static function sessionDestroy($id) {
        self::$sessionHandler->getSessionDao()->deleteSession($id);
        return TRUE;
    }

    /*
     * The garbage collector, this is executed when the session garbage
     * collector is executed and takes the max session lifetime as its only
     * parameter.
     */
    public static function sessionGc($maxlifetime) {
        self::$sessionHandler->getSessionDao()->deleteExpiredSessions($maxlifetime);
        return TRUE;
    }
}