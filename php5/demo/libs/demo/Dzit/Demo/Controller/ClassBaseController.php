<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Base controller class.
 *
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 */
abstract class Dzit_Demo_Controller_BaseController implements Dzit_IController {

    const MODEL_BASEURL             = 'baseUrl';

    const MODEL_SITE                = 'site';
    const MODEL_SITE_TITLE          = 'title';
    const MODEL_SITE_NAME           = 'name';
    const MODEL_SITE_KEYWORDS       = 'keywords';
    const MODEL_SITE_DESCRIPTION    = 'description';
    const MODEL_SITE_SLOGAN         = 'slogan';

    private $model = Array();

    /**
     * Gets site's description.
     *
     * @return string
     */
    protected function getSiteDescription() {
        return 'Demo for Dzit Framework';
    }

    /**
     * Gets site's keywords.
     *
     * @return string
     */
    protected function getSiteKeywords() {
        return 'Dzit Framework';
    }

    /**
     * Gets site's name.
     *
     * @return string
     */
    protected function getSiteName() {
        return 'Dzit Blog';
    }
    /**
     * Gets site's slogan.
     *
     * @return string
     */
    protected function getSiteSlogan() {
        return 'Too lazy to think of a slogan...';
    }

    /**
     * Gets site's title.
     *
     * @return string
     */
    protected function getSiteTitle() {
        return 'Dzit Blog / Demo for Dzit Framework';
    }

    /**
     * Calls this method to populate common models
     */
    protected function populateCommonModels() {
        $baseUrl = $_SERVER["HTTP_HOST"].dirname($_SERVER['SCRIPT_NAME']);
        if ( $baseUrl[strlen($baseUrl-1)] != '/' ) {
            $baseUrl .= '/';
        }
        if ( isset($_SERVER['HTTPS']) ) {
            $baseUrl = "https://$baseUrl";
        } else {
            $baseUrl = "http://$baseUrl";
        }
        $this->setModel(self::MODEL_BASEURL, $baseUrl);

        $site = Array();
        $site[self::MODEL_SITE_DESCRIPTION] = $this->getSiteDescription();
        $site[self::MODEL_SITE_KEYWORDS] = $this->getSiteKeywords();
        $site[self::MODEL_SITE_NAME] = $this->getSiteName();
        $site[self::MODEL_SITE_SLOGAN] = $this->getSiteSlogan();
        $site[self::MODEL_SITE_TITLE] = $this->getSiteTitle();
        $this->setModel(self::MODEL_SITE, $site);
    }

    /**
     * Gets the root model.
     *
     * @return Array
     */
    protected function getRootModel() {
        return $this->model;
    }

    /**
     * Sets a model.
     *
     * @param string $name
     * @param mixed $value
     */
    protected function setModel($name, $value) {
        $this->model[$name] = $value;
    }
}
?>
