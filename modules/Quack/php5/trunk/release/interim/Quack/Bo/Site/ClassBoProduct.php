<?php
class Quack_Bo_Site_BoProduct extends Quack_Bo_BaseBo {

    const COL_NAME = 'prod_name';
    const COL_ACTIVE = 'prod_active';
    const COL_CONFIG = 'prod_config';
    const COL_VERSION_1 = 'prod_ver1';
    const COL_VERSION_2 = 'prod_ver2';
    const COL_VERSION_3 = 'prod_ver3';
    const COL_VERSION_4 = 'prod_ver4';

    private $productName, $productActive, $productConfig;
    private $productVersion1, $productVersion2, $productVersion3, $productVersion4;
    private $productConfigMap = NULL;

    /*
     * (non-PHPdoc) @see Commons_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_NAME => Array('productName'),
                self::COL_CONFIG => Array('productConfig'),
                self::COL_ACTIVE => Array('productActive', self::TYPE_BOOLEAN),
                self::COL_VERSION_1 => Array('productVersion1', self::TYPE_INT),
                self::COL_VERSION_2 => Array('productVersion2', self::TYPE_INT),
                self::COL_VERSION_3 => Array('productVersion3', self::TYPE_INT),
                self::COL_VERSION_4 => Array('productVersion4', self::TYPE_INT));
    }

    public function getProductName() {
        return $this->productName;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
    }

    public function getProductConfig() {
        return $this->productConfig;
    }

    public function setProductConfig($productConfig) {
        $this->productConfig = $productConfig;
        $this->productConfigMap = json_decode($this->productConfig, TRUE);
    }

    public function getProductConfigMap() {
        if ($this->productConfigMap === NULL) {
            $this->productConfigMap = json_decode($this->productConfig, TRUE);
        }
        return $this->productConfigMap;
    }

    public function isActive() {
        return $this->getProductActive();
    }

    public function getProductActive() {
        return $this->productActive;
    }

    public function setProductActive($value) {
        $this->productActive = $value;
    }

    public function getProductVersion1() {
        return $this->productVersion1;
    }
    public function setProductVersion1($value) {
        $this->productVersion1 = $value;
    }

    public function getProductVersion2() {
        return $this->productVersion2;
    }
    public function setProductVersion2($value) {
        $this->productVersion2 = $value;
    }

    public function getProductVersion3() {
        return $this->productVersion3;
    }
    public function setProductVersion3($value) {
        $this->productVersion3 = $value;
    }

    public function getProductVersion4() {
        return $this->productVersion4;
    }
    public function setProductVersion4($value) {
        $this->productVersion4 = $value;
    }

    public function getVersions() {
        return Array($this->productVersion1,
                $this->productVersion2,
                $this->productVersion3,
                $this->productVersion4);
    }

    public function setVersions($versions = Array()) {
        $this->productVersion1 = count($versions) > 0 ? (int)$versions[0] : 0;
        $this->productVersion2 = count($versions) > 1 ? (int)$versions[1] : 0;
        $this->productVersion3 = count($versions) > 2 ? (int)$versions[2] : 0;
        $this->productVersion4 = count($versions) > 3 ? (int)$versions[3] : 0;
    }
}
