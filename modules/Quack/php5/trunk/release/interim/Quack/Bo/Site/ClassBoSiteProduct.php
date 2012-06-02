<?php
class Quack_Bo_Site_BoSiteProduct extends Quack_Bo_BaseBo {

    const COL_SITE_DOMAIN = 'siteDomain';
    const COL_NAME = 'prodName';
    const COL_LEVEL = 'prodLevel';
    const COL_TIMESTAMP = 'prodTimestamp';
    const COL_EXPIRY = 'prodExpiry';
    const COL_CONFIG = 'prodConfig';

    private $productName, $productLevel, $productTimestamp, $productExpiry, $productConfig;
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
                self::COL_TIMESTAMP => Array('productTimestamp', self::TYPE_INT));
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

    public function isExpired() {
        return $this->productExpiry > 0 && $this->productExpiry < time();
    }
}
