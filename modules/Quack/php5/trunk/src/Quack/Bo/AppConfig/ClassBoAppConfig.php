<?php
class Quack_Bo_AppConfig_BoAppConfig extends Quack_Bo_BaseBo {

    const COL_KEY = 'confKey';
    const COL_VALUE = 'confValue';

    private $key, $value;

    /*
     * (non-PHPdoc) @see Commons_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_KEY => Array('key'), self::COL_VALUE => Array('value'));
    }

    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }
}