<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Abstract template page.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Template
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id$
 * @since       File available since v0.1
 */

/**
 * Abstract template page.
 *
 * @package    	Template
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
abstract class Ddth_Template_AbstractPage implements Ddth_Template_IPage {
    /**
     * @var string
     */
    private $id = NULL;

    /**
     * Name of the associated physical template file.
     *
     * @var string
     */
    private $templateFile = NULL;

    /**
     * @var mixed
     */
    private $model = NULL;

    /**
     * @var Ddth_Template_ITemplate
     */
    private $template = NULL;

    /**
     * Constructs a new Ddth_Template_AbstractPage object.
     */
    public function __construct() {
    }

    /**
     * @see Ddth_Template_IPage::init()
     */
    public function init($id, $templateFile, $template) {
        $this->setId($id);
        $this->setTemplateFile($templateFile);
        $this->setTemplate($template);
    }

    /**
     * @see Ddth_Template_IPage::getId()
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets page's id.
     *
     * @param string $id
     */
    protected function setId($id) {
        $this->id = $id;
    }

    /**
     * @see Ddth_Template_IPage::getTemplate()
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * @see Ddth_Template_IPage::getTemplateConfigSetting()
     */
    public function getTemplateConfigSetting($key) {
        return $this->template->getConfigSetting($key);
    }

    /**
     * Sets the template object that is the owner of the page.
     *
     * @param Ddth_Template_ITemplate $template
     */
    protected function setTemplate($template) {
        $this->template = $template;
    }

    /**
     * @see Ddth_Template_IPage::getTemplateFile()
     */
    public function getTemplateFile() {
        return $this->templateFile;
    }

    /**
     * Sets page's associated template file.
     *
     * @param string $templateFile
     */
    protected function setTemplateFile($templateFile) {
        $this->templateFile = $templateFile;
    }

    /**
     * @see Ddth_Template_IPage::setModel()
     */
    public function setModel($model) {
        $this->model = $model;
    }

    /**
     * @see Ddth_Template_IPage::getModel()
     */
    public function getModel() {
        return $this->model;
    }
}
?>
