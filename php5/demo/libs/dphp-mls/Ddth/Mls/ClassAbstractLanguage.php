<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Abstract language pack.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAbstractLanguage.php 222 2010-11-21 07:25:10Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Abstract language pack.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
abstract class Ddth_Mls_AbstractLanguage implements Ddth_Mls_ILanguage {
    const PROPERTY_NAME = "name";

    const PROPERTY_DISPLAY_NAME = "display";

    const PROPERTY_DESCRIPTION = "description";

    /**
     * @var Ddth_Commons_Properties
     */
    private $settings = NULL;

    /**
     * @var string
     */
    private $languageName = NULL;

    /**
     * @var string
     */
    private $displayName = NULL;

    /**
     * @var string
     */
    private $description = NULL;

    /**
     * @var Ddth_Commons_Properties
     */
    private $languageData = NULL;

    /**
     * Constructs a new Ddth_Mls_AbstractLanguage object.
     */
    public function __construct() {
    }

    /**
     * Gets this factory's configuration settings.
     *
     * @return Ddth_Commons_Properties
     */
    protected function getSettings() {
        if ( !($this->settings instanceof Ddth_Commons_Properties) ) {
            $this->settings = new Ddth_Commons_Properties();
        }
        return $this->settings;
    }

    /**
     * Gets a configuration setting.
     *
     * @param string
     * @return string
     */
    protected function getSetting($key) {
        return $this->getSettings()->getProperty($key);
    }

    /**
     * Sets this factory's configuration settings.
     *
     * @param Ddth_Commons_Properties
     */
    protected function setSettings($settings) {
        $this->settings = $settings;
    }

    /**
     * {@see Ddth_Mls_ILanguage::getMessage()}
     */
    public function getMessage($key, $replacements=NULL) {
        if ( $replacements === NULL ) {
            $msg = $this->getLanguageData()->getProperty($key);
            return $msg;
        }
        if ( !is_array($replacements) ) {
            $replacements = Array();
            for ( $i = 1, $n = func_num_args(); $i < $n; $i++ ) {
                $t = func_get_arg($i);
                if ( $t !== NULL ) {
                    $replacements[] = $t;
                }
            }
        }
        $msg = $this->getLanguageData()->getProperty($key);
        return Ddth_Commons_MessageFormat::formatString($msg, $replacements);
    }

    /**
     * {@see Ddth_Mls_ILanguage::getDescription()}
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * {@see Ddth_Mls_ILanguage::getDisplayName()}
     */
    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * {@see Ddth_Mls_ILanguage::getName()}
     */
    public function getName() {
        return $this->languageName;
    }

    /**
     * {@see Ddth_Mls_ILanguage::init()}
     */
    public function init($settings) {
        $this->setSettings($settings);
        $this->languageName = $this->getSetting(self::PROPERTY_NAME);
        $this->displayName = $this->getSetting(self::PROPERTY_DISPLAY_NAME);
        $this->description = $this->getSetting(self::PROPERTY_DESCRIPTION);
        $this->buildLanguageData();
    }

    /**
     * Loads and builds language data. Called by
     * {@link Ddth_Mls_AbstractLanguage::init()} method.
     *
     * @throws Ddth_Mls_MlsException
     */
    protected abstract function buildLanguageData();

    /**
     * Sets language data.
     *
     * @param Ddth_Commons_Properties
     */
    protected function setLanguageData($languageData) {
        if ( $languageData===NULL || !($languageData instanceof Ddth_Commons_Properties) ) {
            $this->languageData = new Ddth_Commons_Properties();
        } else {
            $this->languageData = $languageData;
        }
    }

    /**
     * Gets language data.
     *
     * @return Ddth_Commons_Properties
     */
    protected function getLanguageData() {
        return $this->languageData;
    }
}
?>
