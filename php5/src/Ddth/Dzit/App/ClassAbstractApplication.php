<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Abstract implementation of IApplication.
 *
 * LICENSE: This source file is subject to version 3.0 of the GNU Lesser General
 * Public License that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/lgpl.html. If you did not receive a copy of
 * the GNU Lesser General Public License and are unable to obtain it through the web,
 * please send a note to gnu@gnu.org, or send an email to any of the file's authors
 * so we can email you a copy.
 *
 * @package		Dzit
 * @author		NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html LGPL 3.0
 * @id			$Id$
 * @since      	File available since v0.1
 */

/**
 * Abstract implementation of IApplication.
 *
 * @package    	Dzit
 * @author     	NGUYEN, Ba Thanh <btnguyen2k@gmail.com>
 * @copyright	2008 DDTH.ORG
 * @license    	http://www.gnu.org/licenses/lgpl.html  LGPL 3.0
 * @version    	0.1
 * @since      	Class available since v0.1
 */
abstract class Ddth_Dzit_AbstractApplication implements Ddth_Dzit_IApplication {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * @var Ddth_Dzit_Configurations
     */
    private $dzitConfig;

    /**
     * @var Ddth_Adodb_IAdodbFactory
     */
    private $adodbFactory = NULL;

    /**
     * @var ADOConnection
     */
    private $adodbConn = NULL;

    private $countAdodbConn = 0;

    /**
     * Constructs a new Ddth_Dzit_AbstractApplication object.
     */
    public function __construct() {
        $clazz = 'Ddth_Dzit_AbstractApplication';
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog($clazz);
        Ddth_Dzit_ApplicationRegistry::registerApplication($this);
    }

    /**
     * Clean-up method.
     *
     * This method is called just before the application object is abandoned.
     *
     * @throws Ddth_Dzit_DzitException
     */
    public function destroy($hasError=false) {
        $this->closeAdodbConnection($hasError);
    }

    /**
     * Executes the application (serves the Http request).
     *
     * @throws Ddth_Dzit_DzitException
     */
    public function execute();

    /**
     * Gets Dzit's configuration instance.
     *
     * @return Ddth_Dzit_Configurations
     */
    protected function getDzitConfig() {
        return $this->dzitConfig;
    }

    /**
     * {@see Ddth_Dzit_IApplication::init()}
     */
    public function init($config) {
        $this->dzitConfig = $config;
        initSession();
        initAdodbFactory();
    }

    /**
     * Initializes ADOdb factory.
     *
     * @Throws Ddth_Dzit_DzitException
     */
    protected function initAdodbFactory() {
        try {
            if ( $this->getDzitConfig()->supportAdodb() ) {
                $adodbConfigFile = $this->getDzitConfig()->getAdodbConfigFile();
                if ( trim($adodbConfigFile) == "" ) {
                    $adodbConfigFile = NULL;
                }
                $this->adodbFactory = Ddth_Adodb_AdodbFactory::getInstance($adodbConfigFile);
            } else {
                $this->adodbFactory = NULL;
            }
        } catch ( Exception  $e ) {
            $msg = $e->getMessage();
            throw new Ddth_Dzit_DzitException($msg);
        }
    }

    /**
     * Initializes session.
     *
     * @Throws Ddth_Dzit_DzitException
     */
    protected function initSession() {
        session_start();
    }

    /**
     * Gets the ADOdb connection.
     *
     * @return ADOConnection
     */
    public function getAdodbConnection() {
        if ( $this->adodbFactory == NULL ) {
            return NULL;
        }
        if ( $this->adodbConn == NULL ) {
            $this->adodbConn = $this->adodbFactory->getConnection(true);
            $this->countAdodbConn = 0;
        }
        $this->countAdodbConn++;
        return $this->adodbConn;
    }

    /**
     * Closes the ADOdb connection.
     *
     * @param bool indicate if an error has occurred
     */
    public function closeAdodbConnection($hasError=false) {
        if ( $this->adodbConn != NULL ) {
            if ( $hasError ) {
                $this->adodbConn->FailTrans();
            }
            $this->countAdodbConn--;
            if ( $this->countAdodbConn == 0 ) {
                $this->adodbFactory->closeConnection($this->adodbConn);
                $this->adodbConn = NULL;
            }
        }
    }
}
?>