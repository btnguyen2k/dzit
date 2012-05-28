<?php
class Quack_Bo_Site_BoSite extends Quack_Bo_BaseBo {

    const COL_DOMAIN = 'siteDomain';
    const COL_REF = 'siteRef';
    const COL_PROD_LEVEL = 'productLevel';
    const COL_PROD_TIMESTAMP = 'productTimestamp';
    const COL_PROD_EXPIRY = 'productExpiry';
    const COL_PROD_CONFIG = 'productConfig';

    private $siteDomain, $siteRef, $productLevel, $productTimestamp, $productExpiry, $productConfig;
    private $refSite = NULL;

    /*
     * (non-PHPdoc) @see Commons_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_DOMAIN => Array('siteDomain'),
                self::COL_REF => Array('siteRef'),
                self::COL_PROD_CONFIG => Array('productConfig'),
                self::COL_PROD_EXPIRY => Array('productExpiry', self::TYPE_INT),
                self::COL_PROD_LEVEL => Array('productLevel', self::TYPE_INT),
                self::COL_PROD_TIMESTAMP => Array('productTimestamp', self::TYPE_INT));
    }

    /**
     * Getter for $siteDomain.
     *
     * @return field_type
     */
    public function getSiteDomain() {
        return $this->siteDomain;
    }

    /**
     * Getter for $siteRef.
     *
     * @return field_type
     */
    public function getSiteRef() {
        return $this->siteRef;
    }

    /**
     * Getter for $productLevel.
     *
     * @return field_type
     */
    public function getProductLevel() {
        return $this->productLevel;
    }

    /**
     * Getter for $productTimestamp.
     *
     * @return field_type
     */
    public function getProductTimestamp() {
        return $this->productTimestamp;
    }

    /**
     * Getter for $productExpiry.
     *
     * @return field_type
     */
    public function getProductExpiry() {
        return $this->productExpiry;
    }

    /**
     * Getter for $productConfig.
     *
     * @return field_type
     */
    public function getProductConfig() {
        return $this->productConfig;
    }

    /**
     * Getter for $refSite.
     *
     * @return field_type
     */
    public function getRefSite() {
        return $this->refSite;
    }

    /**
     * Setter for $siteDomain.
     *
     * @param field_type $siteDomain
     */
    public function setSiteDomain($siteDomain) {
        $this->siteDomain = $siteDomain;
    }

    /**
     * Setter for $siteRef.
     *
     * @param field_type $siteRef
     */
    public function setSiteRef($siteRef) {
        $this->siteRef = $siteRef;
    }

    /**
     * Setter for $productLevel.
     *
     * @param field_type $productLevel
     */
    public function setProductLevel($productLevel) {
        $this->productLevel = $productLevel;
    }

    /**
     * Setter for $productTimestamp.
     *
     * @param field_type $productTimestamp
     */
    public function setProductTimestamp($productTimestamp) {
        $this->productTimestamp = $productTimestamp;
    }

    /**
     * Setter for $productExpiry.
     *
     * @param field_type $productExpiry
     */
    public function setProductExpiry($productExpiry) {
        $this->productExpiry = $productExpiry;
    }

    /**
     * Setter for $productConfig.
     *
     * @param field_type $productConfig
     */
    public function setProductConfig($productConfig) {
        $this->productConfig = $productConfig;
    }

    /**
     * Setter for $refSite.
     *
     * @param field_type $refSite
     */
    public function setRefSite($refSite) {
        $this->refSite = $refSite;
    }
}