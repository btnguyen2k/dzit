<?php
class Quack_Bo_Page_BoPage extends Quack_Bo_BaseBo {

    const COL_ID = 'pageId';
    const COL_POSITION = 'pagePosition';
    const COL_TITLE = 'pageTitle';
    const COL_CONTENT = 'pageContent';
    const COL_CATEGORY = 'pageCategory';
    const COL_ATTR = 'pageAttr';

    private $id, $position, $title, $content, $category, $attr;

    /*
     * (non-PHPdoc) @see Quack_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_ID => Array('id'),
                self::COL_POSITION => Array('position', self::TYPE_INT),
                self::COL_TITLE => Array('title'),
                self::COL_CONTENT => Array('content'),
                self::COL_CATEGORY => Array('category'),
                self::COL_ATTR => Array('attr', self::TYPE_INT));
    }

    /**
     * Gets the URL to edit the page.
     *
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function getAttr() {
        return $this->attr;
    }

    public function setAttr($attr) {
        $this->attr = $attr;
    }
}