<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
class Dzit_Demo_Bo_Post extends Dzit_Demo_Bo_BaseBo {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $createdTime;

    /**
     * @var string
     */
    private $modifiedTime;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getCreatedTime() {
        return $this->createdTime;
    }

    /**
     * @return string
     */
    public function getModifiedTime() {
        return $this->modifiedTime;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @param string $body
     */
    public function setBody($body) {
        $this->body = $body;
    }

    /**
     * @param string $createdTime
     */
    public function setCreatedTime($createdTime) {
        $this->createdTime = $createdTime;
    }

    /**
     * @param string $modifiedTime
     */
    public function setModifiedTime($modifiedTime) {
        $this->modifiedTime = $modifiedTime;
    }

    public function getUrlDelete() {
        $urlCreator = $this->getUrlCreator();
        return $urlCreator->createUrl(Array('module' => 'deletePost',
                'queryStrParams' => Array('id' => $this->id)));
    }
}
