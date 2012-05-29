<?php
class Quack_Bo_Site_BoProduct extends Quack_Bo_BaseBo {

    const COL_SITE_DOMAIN = 'siteDomain';
    const COL_NAME = 'prodName';
    const COL_LEVEL = 'prodLevel';
    const COL_TIMESTAMP = 'prodTimestamp';
    const COL_EXPIRY = 'prodExpiry';
    const COL_CONFIG = 'prodConfig';
    const COL_VERSION_1 = 'prodVer1';
    const COL_VERSION_2 = 'prodVer2';
    const COL_VERSION_3 = 'prodVer3';
    const COL_VERSION_4 = 'prodVer4';

    private $productName, $productLevel, $productTimestamp, $productExpiry, $productConfig;
    private $productVersion1, $productVersion2, $productVersion3, $productVersion4;
    private $productConfigMap = NULL;

    /*
     * (non-PHPdoc) @see Commons_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_SITE_DOMAIN => Array('siteDomain'),
                self::COL_NAME => Array('productName'),
                self::COL_CONFIG => Array('productConfig'),
                self::COL_EXPIRY => Array('productExpiry', self::TYPE_INT),
                self::COL_LEVEL => Array('productLevel', self::TYPE_INT),
                self::COL_TIMESTAMP => Array('productTimestamp', self::TYPE_INT),
                self::COL_VERSION_1 => Array('productVersion1', self::TYPE_INT),
                self::COL_VERSION_2 => Array('productVersion2', self::TYPE_INT),
                self::COL_VERSION_3 => Array('productVersion3', self::TYPE_INT),
                self::COL_VERSION_4 => Array('productVersion4', self::TYPE_INT));
    }

    public function getSiteDomain() {
        return $this->siteDomain;
    }

    public function setSiteDomain($siteDomain) {
        $this->siteDomain = $siteDomain;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
    }

    public function getProductLevel() {
        return $this->productLevel;
    }

    public function setProductLevel($productLevel) {
        $this->productLevel = $productLevel;
    }

    public function getProductTimestamp() {
        return $this->productTimestamp;
    }

    public function setProductTimestamp($productTimestamp) {
        $this->productTimestamp = $productTimestamp;
    }

    public function getProductExpiry() {
        return $this->productExpiry;
    }

    public function setProductExpiry($productExpiry) {
        $this->productExpiry = $productExpiry;
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

    public function isExpired() {
        return $this->productExpiry > 0 && $this->productExpiry < time();
    }
}
