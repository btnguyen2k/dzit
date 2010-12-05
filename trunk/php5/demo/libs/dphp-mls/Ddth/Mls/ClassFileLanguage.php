<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * File-based language pack.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassFileLanguage.php 222 2010-11-21 07:25:10Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * File-based language pack.
 *
 * @package     Mls
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
class Ddth_Mls_FileLanguage extends Ddth_Mls_AbstractLanguage {
    const PROPERTY_LOCATION = "location";

    const PROPERTY_BASE_DIRECTORY = "base.directory";

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * @var string
     */
    private $location = NULL;

    /**
     * @var string
     */
    private $baseDirectory = NULL;

    /**
     * Constructs a new Ddth_Mls_FileLanguage object.
     */
    public function __construct() {
        parent::__construct();
        $clazz = __CLASS__;
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog($clazz);
    }

    /**
     * {@see Ddth_Mls_AbstractLanguage::buildLanguageData()}
     */
    protected function buildLanguageData() {
        $this->baseDirectory = trim($this->getSetting(self::PROPERTY_BASE_DIRECTORY));
        $this->baseDirectory = preg_replace('/[\\/]+/', '/', $this->baseDirectory);
        $this->location = trim($this->getSetting(self::PROPERTY_LOCATION));
        $this->location = preg_replace('/[\\/]+/', '/', $this->location);
        $dir = $this->baseDirectory . '/' . $this->location;
        if ( !is_dir($dir) ) {
            $msg = "[$dir] is not a directory!";
            throw new Ddth_Mls_MlsException($msg);
        }
        $languageData = new Ddth_Commons_Properties();
        if ( $dh = @opendir($dir) ) {
            while ( $file = @readdir($dh) ) {
                if ( is_readable($dir.'/'.$file) && preg_match('/^.+\.properties$/i', $file) ) {
                    try {
                        $msg = "Load language file [$dir/$file]...";
                        $this->LOGGER->info($msg);
                        $languageData->load($dir.'/'.$file);
                    } catch ( Exception $e ) {
                        $msg = $e->getMessage();
                        $this->LOGGER->warn($msg, $e);
                    }
                }
            }
            @closedir($dh);
        } else {
            $msg = "[$dir] is not accessible!";
            throw new Ddth_Mls_MlsException($msg);
        }
        $this->setLanguageData($languageData);
    }
}
?>