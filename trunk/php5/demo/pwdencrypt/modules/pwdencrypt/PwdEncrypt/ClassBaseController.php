<?php
class PwdEncrypt_BaseController implements Dzit_IController {

    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $this->printPageHeader();

        $lang = $this->getLanguage();
        $script = $_SERVER['SCRIPT_NAME'];
        echo "<form method='post' action='$script'>";
        echo $lang->getMessage('msg.input'), ': ';
        echo "<input type='text' value='", isset($_POST['str']) ? htmlspecialchars($_POST['str']) : "", "' name='str'>";
        echo "<input type='submit' value='", $lang->getMessage('msg.encrypt'), "'>";
        echo "</form>";

        if (isset($_POST['str'])) {
            echo '<pre>MD5   : ', md5($_POST['str']), '</pre>';
            echo '<pre>Base64: ', base64_encode($_POST['str']), '</pre>';
            echo '<pre>Crypt : ', crypt($_POST['str']), '</pre>';
        }

        $this->printPageFooter();
    }

    protected function getLanguageNames() {
        $mlsFactory = Ddth_Mls_BaseLanguageFactory::getInstance();
        return $mlsFactory->getLanguageNames();
    }

    /**
     * Gets the current language pack.
     *
     * @return Ddth_Mls_ILanguage
     */
    protected function getLanguage() {
        $defaultLanguageName = Dzit_Config::get(Dzit_Config::CONF_DEFAULT_LANGUAGE_NAME);
        $langName = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : $defaultLanguageName;
        $mlsFactory = Ddth_Mls_BaseLanguageFactory::getInstance();
        $lang = $mlsFactory->getLanguage($langName);
        if ($lang === NULL) {
            $langName = $defaultLanguageName;
        }
        setcookie('lang', $langName);
        //$_COOKIE['lang'] = $langName;
        $lang = $mlsFactory->getLanguage($langName);
        return $lang;
    }

    protected function printPageHeader() {
        $lang = $this->getLanguage();
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
        echo '<title>Dzit Demo::PwdEncrypt</title>';
        echo '</head>';
        echo '<body>';

        $script = $_SERVER['SCRIPT_NAME'];
        echo '<p>';
        echo $lang->getMessage('msg.languages'), ': ';
        $languageNames = $this->getLanguageNames();
        foreach ($languageNames as $langName) {
            echo '<a href="', $script, '/lang?l=', $langName, '">', $langName, '</a> | ';
        }
        echo '</p>';
    }

    protected function printPageFooter() {
        echo '</body>';
        echo '</html>';
    }
}