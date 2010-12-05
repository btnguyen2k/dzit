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
 * @version     $Id: ClassAbstractPage.php 227 2010-12-05 06:57:50Z btnguyen2k@gmail.com $
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
     *
     * @param string
     * @param string
     * @param Ddth_Template_ITemplate
     */
    public function __construct($id, $templateFile, $template) {
        $this->setId($id);
        $this->setTemplateFile($templateFile);
        $this->setTemplate($template);
    }

    /**
     * Gets page's id.
     *
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets page's id.
     *
     * @param string
     */
    protected function setId($id) {
        $this->id = $id;
    }

    /**
     * Gets associated template instance.
     *
     * @return Ddth_Template_ITemplate
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Sets associated template instance.
     *
     * @param Ddth_Template_ITemplate
     */
    protected function setTemplate($template) {
        $this->template = $template;
    }

    /**
     * {@see Ddth_Template_IPage::getTemplateFile()}
     */
    public function getTemplateFile() {
        return $this->templateFile;
    }

    /**
     * Sets page's associated template file.
     *
     * @param string
     */
    protected function setTemplateFile($templateFile) {
        $this->templateFile = $templateFile;
    }

    /**
     * {@see Ddth_Template_IPage::setModel()}
     */
    public function setModel($model) {
        $this->model = $model;
    }

    /**
     * Gets page's data model.
     *
     * @return mixed
     */
    protected function getModel() {
        return $this->model;
    }

    /**
     * Gets a template's setting property.
     *
     * @param string
     * @return string
     */
    protected function getTemplateProperty($key) {
        return $this->template->getSetting($key);
    }
}
?>
