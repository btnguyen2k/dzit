<?php
class Quack_Bo_Site_BoSite extends Quack_Bo_BaseBo {

    const COL_DOMAIN = 'siteDomain';
    const COL_REF = 'siteRef';
    const COL_TIMESTAMP = 'siteTimestamp';
    const COL_CUSTOMER_ID = 'customerId';

    private $siteDomain, $siteRef, $siteTimestamp, $customerId;
    private $products = Array();

    /**
     *
     * @var Quack_Bo_Site_BoSite
     */
    private $refSite = NULL;

    /*
     * (non-PHPdoc) @see Commons_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_DOMAIN => Array('siteDomain'),
                self::COL_REF => Array('siteRef'),
                self::COL_TIMESTAMP => Array('siteTimestamp', self::TYPE_INT),
                self::COL_CUSTOMER_ID => Array('customerId'));
    }

    public function getProducts() {
        if ($this->refSite !== NULL) {
            return $this->refSite->getProducts();
        }
        return $this->products;
    }

    public function setProducts($products = Array()) {
        if ($this->refSite !== NULL) {
            $this->refSite->setProducts($products);
            return;
        }
        $this->products = $products;
    }

    /**
     * Adds a product.
     *
     * @param string $prodName
     * @param Quack_Bo_Site_BoSiteProduct $product
     */
    public function addProduct($prodName, $product) {
        if ($this->refSite !== NULL) {
            $this->refSite->addProduct($prodName, $product);
            return;
        }
        $this->products[$prodName] = $product;
    }

    /**
     * Removes a product from the site.
     *
     * @param Quack_Bo_Site_BoSiteProduct $product
     */
    public function removeProduct($product) {
        if ($this->refSite !== NULL) {
            $this->refSite->removeProduct($product);
            return;
        }
        unset($this->products[$product->getProductName()]);
    }

    /**
     * Gets a product by name.
     *
     * @param string $prodName
     * @return Quack_Bo_Site_BoSiteProduct
     */
    public function getProduct($prodName) {
        if ($this->refSite !== NULL) {
            return $this->refSite->getProduct($prodName);
        }
        return isset($this->products[$prodName]) ? $this->products[$prodName] : NULL;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId) {
        $this->customerId = $customerId;
    }

    public function getSiteDomain() {
        return $this->siteDomain;
    }

    public function setSiteDomain($siteDomain) {
        $this->siteDomain = $siteDomain;
    }

    public function getSiteRef() {
        return $this->siteRef;
    }

    public function setSiteRef($siteRef) {
        $this->siteRef = $siteRef;
    }

    public function getSiteTimestamp() {
        return $this->siteTimestamp;
    }

    public function setSiteTimestamp($siteTimestamp) {
        $this->siteTimestamp = $siteTimestamp;
    }

    public function getRefSite() {
        return $this->refSite;
    }

    public function setRefSite($refSite) {
        $this->refSite = $refSite;
    }
}
