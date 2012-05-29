<?php
abstract class Quack_Bo_Site_BaseSiteDao extends Quack_Bo_BaseDao implements Quack_Bo_Site_ISiteDao {

    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * Creates the cache key for site.
     *
     * @param mixed $siteDomain
     */
    protected function createCacheKeySite($siteDomain) {
        return "SITE_$siteDomain";
    }

    /**
     * Creates the cache key for product.
     *
     * @param mixed $siteDomain
     * @param mixed $prodName
     */
    protected function createCacheKeyProduct($siteDomain, $prodName) {
        return "PROD_{$siteDomain}_{$prodName}";
    }

    /**
     * Invalidates the site cache due to change.
     *
     * @param Quack_Bo_Site_BoSite $site
     */
    protected function invalidateSiteCache($site = NULL) {
        if ($site !== NULL) {
            $cacheKey = $this->createCacheKeySite($site->getSiteDomain());
            $this->deleteFromCache($cacheKey);
        }
    }

    /**
     * Invalidates the product cache due to change.
     *
     * @param Quack_Bo_Site_BoProduct $prod
     */
    protected function invalidateProdCache($prod = NULL) {
        if ($prod !== NULL) {
            $cacheKey = $this->createCacheKeyProduct($prod->getSiteDomain(), $prod->getProductName());
            $this->deleteFromCache($cacheKey);
        }
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::countNumSites()
     */
    public function countNumSites($filter = Array()) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array();
        $result = $this->execCount($sqlStm, $params);
        return (int)$result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::createProduct()
     */
    public function createProduct($product) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoProduct::COL_SITE_DOMAIN => $product->getSiteDomain(),
                Quack_Bo_Site_BoProduct::COL_CONFIG => $product->getProductConfig(),
                Quack_Bo_Site_BoProduct::COL_EXPIRY => (int)$product->getProductExpiry(),
                Quack_Bo_Site_BoProduct::COL_LEVEL => (int)$product->getProductLevel(),
                Quack_Bo_Site_BoProduct::COL_NAME => $product->getProductName(),
                Quack_Bo_Site_BoProduct::COL_TIMESTAMP => (int)$product->getProductTimestamp(),
                Quack_Bo_Site_BoProduct::COL_VERSION_1 => (int)$product->getProductVersion1(),
                Quack_Bo_Site_BoProduct::COL_VERSION_2 => (int)$product->getProductVersion2(),
                Quack_Bo_Site_BoProduct::COL_VERSION_3 => (int)$product->getProductVersion3(),
                Quack_Bo_Site_BoProduct::COL_VERSION_4 => (int)$product->getProductVersion4());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateProdCache();
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::createSite()
     */
    public function createSite($site) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoSite::COL_DOMAIN => $site->getSiteDomain(),
                Quack_Bo_Site_BoSite::COL_REF => $site->getSiteRef(),
                Quack_Bo_Site_BoSite::COL_PROD_CONFIG => $site->getProductConfig(),
                Quack_Bo_Site_BoSite::COL_PROD_EXPIRY => (int)$site->getProductExpiry(),
                Quack_Bo_Site_BoSite::COL_PROD_LEVEL => (int)$site->getProductLevel(),
                Quack_Bo_Site_BoSite::COL_PROD_TIMESTAMP => (int)$site->getProductTimestamp());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateSiteCache();
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::deleteProduct()
     */
    public function deleteProduct($product) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoProduct::COL_SITE_DOMAIN => $product->getSiteDomain(),
                Quack_Bo_Site_BoProduct::COL_NAME => $product->getProductName());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateProdCache($product);
        return $result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::deleteSite()
     */
    public function deleteSite($site) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoSite::COL_DOMAIN => $site->getSiteDomain());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateSiteCache($site);
        return $result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::getProductByName()
     */
    public function getProductByName($site, $name) {
        $cacheKey = $this->createCacheKeyProduct($site->getSiteDomain(), $name);
        $prod = $this->getFromCache($cacheKey);
        if ($prod == NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Quack_Bo_Site_BoProduct::COL_SITE_DOMAIN => $site->getSiteDomain(),
                    Quack_Bo_Site_BoProduct::COL_NAME => $name);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $prod = new Quack_Bo_Site_BoProduct();
                $prod->populate($rows[0]);
                $this->putToCache($cacheKey, $prod);
            }
        }
        return $prod;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::getSiteByDomain()
     */
    public function getSiteByDomain($domain) {
        $cacheKey = $this->createCacheKeySite($domain);
        $site = $this->getFromCache($cacheKey);
        if ($site === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Quack_Bo_Site_BoSite::COL_DOMAIN => $domain);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $site = new Quack_Bo_Site_BoSite();
                $site->populate($rows[0]);

                $siteRef = $site->getSiteRef();
                if ($siteRef !== NULL && $siteRef === '') {
                    $site->setRefSite($this->getSiteByDomain($siteRef));
                }
                $this->putToCache($cacheKey, $site);
            }
        }
        $prods = $this->getProductsForSite($site);
        $site->setProducts($prods);
        return $site;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::getProductsForSite()
     */
    public function getProductsForSite($site) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoProduct::COL_SITE_DOMAIN => $site->getSiteDomain());
        $rows = $this->execSelect($sqlStm, $params);
        $result = Array();
        if ($rows !== NULL) {
            foreach ($rows as $row) {
                //$siteDomain = $row[Quack_Bo_Site_BoProduct::COL_SITE_DOMAIN];
                $prodName = $row[Quack_Bo_Site_BoProduct::COL_NAME];
                $prod = $this->getProductByName($site, $prodName);
                $result[] = $prod;
            }
        }
        return $result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::getSites()
     */
    public function getSites($pageNum = 1, $pageSize = PHP_INT_MAX, $filter = Array()) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize,
                self::PARAM_PAGE_SIZE => $pageSize);
        $rows = $this->execSelect($sqlStm, $params);
        $result = Array();
        if ($rows !== NULL) {
            foreach ($rows as $row) {
                $domain = $row[Quack_Bo_Site_BoSite::COL_DOMAIN];
                $site = $this->getSiteByDomain($domain);
                $result[] = $site;
            }
        }
        return $result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::updateProduct()
     */
    public function updateProduct($product) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoProduct::COL_SITE_DOMAIN => $product->getSiteDomain(),
                Quack_Bo_Site_BoProduct::COL_CONFIG => $product->getProductConfig(),
                Quack_Bo_Site_BoProduct::COL_EXPIRY => (int)$product->getProductExpiry(),
                Quack_Bo_Site_BoProduct::COL_LEVEL => (int)$product->getProductLevel(),
                Quack_Bo_Site_BoProduct::COL_NAME => $product->getProductName(),
                Quack_Bo_Site_BoProduct::COL_TIMESTAMP => (int)$product->getProductTimestamp(),
                Quack_Bo_Site_BoProduct::COL_VERSION_1 => (int)$product->getProductVersion1(),
                Quack_Bo_Site_BoProduct::COL_VERSION_2 => (int)$product->getProductVersion2(),
                Quack_Bo_Site_BoProduct::COL_VERSION_3 => (int)$product->getProductVersion3(),
                Quack_Bo_Site_BoProduct::COL_VERSION_4 => (int)$product->getProductVersion4());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateProdCache($product);
        return $result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::updateSite()
     */
    public function updateSite($site) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoSite::COL_DOMAIN => $site->getSiteDomain(),
                Quack_Bo_Site_BoSite::COL_REF => $site->getSiteRef(),
                Quack_Bo_Site_BoSite::COL_PROD_CONFIG => $site->getProductConfig(),
                Quack_Bo_Site_BoSite::COL_PROD_EXPIRY => (int)$site->getProductExpiry(),
                Quack_Bo_Site_BoSite::COL_PROD_LEVEL => (int)$site->getProductLevel(),
                Quack_Bo_Site_BoSite::COL_PROD_TIMESTAMP => (int)$site->getProductTimestamp());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateSiteCache($site);
        return $result;
    }
}
