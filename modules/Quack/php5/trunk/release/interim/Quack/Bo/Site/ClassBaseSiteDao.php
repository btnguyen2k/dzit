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
     * @param mixed $prodName
     */
    protected function createCacheKeyProduct($prodName) {
        return "PROD_{$prodName}";
    }

    /**
     * Creates the cache key for site-product.
     *
     * @param mixed $siteDomain
     * @param mixed $prodName
     */
    protected function createCacheKeySiteProduct($siteDomain, $prodName) {
        return "SITEPROD_{$siteDomain}_{$prodName}";
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
            $cacheKey = $this->createCacheKeyProduct($prod->getProductName());
            $this->deleteFromCache($cacheKey);
        }
    }

    /**
     * Invalidates the site-product cache due to change.
     *
     * @param Quack_Bo_Site_BoSiteProduct $siteProd
     */
    protected function invalidateSiteProdCache($siteProd = NULL) {
        if ($siteProd !== NULL) {
            $cacheKey = $this->createCacheKeySiteProduct($siteProd->getSiteDomain(), $siteProd->getProductName());
            $this->deleteFromCache($cacheKey);
            $cacheKey = $this->createCacheKeySite($siteProd->getSiteDomain());
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
     * @see Quack_Bo_Site_ISiteDao::countNumProducts()
     */
    public function countNumProducts($filter = Array()) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array();
        $result = $this->execCount($sqlStm, $params);
        return (int)$result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::countNumProductsForSite()
     */
    public function countNumProductsForSite($site, $filter = Array()) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array($site->getSiteDomain());
        $result = $this->execCount($sqlStm, $params);
        return (int)$result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::createProduct()
     */
    public function createProduct($product) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoProduct::COL_ACTIVE => $product->isActive() ? 1 : 0,
                Quack_Bo_Site_BoProduct::COL_CONFIG => $product->getProductConfig(),
                Quack_Bo_Site_BoProduct::COL_NAME => $product->getProductName(),
                Quack_Bo_Site_BoProduct::COL_VERSION_1 => (int)$product->getProductVersion1(),
                Quack_Bo_Site_BoProduct::COL_VERSION_2 => (int)$product->getProductVersion2(),
                Quack_Bo_Site_BoProduct::COL_VERSION_3 => (int)$product->getProductVersion3(),
                Quack_Bo_Site_BoProduct::COL_VERSION_4 => (int)$product->getProductVersion4());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateProdCache($product);
        $cacheKey = $this->createCacheKeyProduct($product->getProductName());
        $this->putToCache($cacheKey, $product);
        return $product;
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
        $this->invalidateSiteCache($site);
        $cacheKey = $this->createCacheKeySite($site->getSiteDomain());
        $this->putToCache($cacheKey, $site);
        return $site;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::createSiteProduct()
     */
    public function createSiteProduct($siteProd) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoSiteProduct::COL_SITE_DOMAIN => $siteProd->getSiteDomain(),
                Quack_Bo_Site_BoSiteProduct::COL_CONFIG => $siteProd->getProductConfig(),
                Quack_Bo_Site_BoSiteProduct::COL_EXPIRY => (int)$siteProd->getProductExpiry(),
                Quack_Bo_Site_BoSiteProduct::COL_LEVEL => (int)$siteProd->getProductLevel(),
                Quack_Bo_Site_BoSiteProduct::COL_NAME => $siteProd->getProductName(),
                Quack_Bo_Site_BoSiteProduct::COL_TIMESTAMP => (int)$siteProd->getProductTimestamp());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateProdCache($siteProd);
        $cacheKey = $this->createCacheKeySiteProduct($siteProd->getSiteDomain(), $siteProd->getProductName());
        $this->putToCache($cacheKey, $siteProd);
        return $siteProd;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::deleteProduct()
     */
    public function deleteProduct($product) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoProduct::COL_NAME => $product->getProductName());
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
     * @see Quack_Bo_Site_ISiteDao::deleteSiteProduct()
     */
    public function deleteSiteProduct($siteProd) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoSiteProduct::COL_SITE_DOMAIN => $siteProd->getSiteDomain(),
                Quack_Bo_Site_BoSiteProduct::COL_NAME => $siteProd->getProductName());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateSiteProdCache($siteProd);
        return $result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::getProductByName()
     */
    public function getProductByName($name) {
        $cacheKey = $this->createCacheKeyProduct($name);
        $result = $this->getFromCache($cacheKey);
        if ($result == NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Quack_Bo_Site_BoProduct::COL_NAME => $name);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Quack_Bo_Site_BoProduct();
                $result->populate($rows[0]);
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::getSiteByDomain()
     */
    public function getSiteByDomain($domain) {
        $cacheKey = $this->createCacheKeySite($domain);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Quack_Bo_Site_BoSite::COL_DOMAIN => $domain);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Quack_Bo_Site_BoSite();
                $result->populate($rows[0]);

                $siteRef = $result->getSiteRef();
                if ($siteRef !== NULL && $siteRef !== '') {
                    $temp = $this->getSiteByDomain($siteRef);
                    $result->setRefSite($temp);
                }
                $prods = $this->getProductsForSite($result);
                $result->setProducts($prods);
            }
        }
        // if ($result !== NULL && $result->getRefSite() === NULL) {
        // $prods = $this->getProductsForSite($result);
        // $result->setProducts($prods);
        // }
        return $this->returnCachedResult($result, $cacheKey);
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::getSiteProductByName()
     */
    public function getSiteProductByName($site, $name) {
        $cacheKey = $this->createCacheKeySiteProduct($site->getSiteDomain(), $name);
        $result = $this->getFromCache($cacheKey);
        if ($result == NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Quack_Bo_Site_BoSiteProduct::COL_SITE_DOMAIN => $site->getSiteDomain(),
                    Quack_Bo_Site_BoSiteProduct::COL_NAME => $name);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Quack_Bo_Site_BoSiteProduct();
                $result->populate($rows[0]);
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::getProductsForSite()
     */
    public function getProductsForSite($site) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoSiteProduct::COL_SITE_DOMAIN => $site->getSiteDomain());
        $rows = $this->execSelect($sqlStm, $params);
        $result = Array();
        if ($rows !== NULL) {
            foreach ($rows as $row) {
                $prodName = $row[Quack_Bo_Site_BoSiteProduct::COL_NAME];
                $siteProd = $this->getSiteProductByName($site, $prodName);
                $result[$prodName] = $siteProd;
            }
        }
        return $result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::getProsucts()
     */
    public function getProsucts($pageNum = 1, $pageSize = PHP_INT_MAX, $filter = Array()) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize,
                self::PARAM_PAGE_SIZE => $pageSize);
        $rows = $this->execSelect($sqlStm, $params);
        $result = Array();
        if ($rows !== NULL) {
            foreach ($rows as $row) {
                $prodName = $row[Quack_Bo_Site_BoProduct::COL_NAME];
                $prod = $this->getProductByName($prodName);
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
        $params = Array(Quack_Bo_Site_BoProduct::COL_ACTIVE => $product->isActive() ? 1 : 0,
                Quack_Bo_Site_BoProduct::COL_CONFIG => $product->getProductConfig(),
                Quack_Bo_Site_BoProduct::COL_NAME => $product->getProductName(),
                Quack_Bo_Site_BoProduct::COL_VERSION_1 => (int)$product->getProductVersion1(),
                Quack_Bo_Site_BoProduct::COL_VERSION_2 => (int)$product->getProductVersion2(),
                Quack_Bo_Site_BoProduct::COL_VERSION_3 => (int)$product->getProductVersion3(),
                Quack_Bo_Site_BoProduct::COL_VERSION_4 => (int)$product->getProductVersion4());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateProdCache($product);
        $cacheKey = $this->createCacheKeyProduct($product->getProductName());
        $this->putToCache($cacheKey, $product);
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
        $cacheKey = $this->createCacheKeySite($site->getSiteDomain());
        $this->putToCache($cacheKey, $site);
        return $result;
    }

    /**
     *
     * @see Quack_Bo_Site_ISiteDao::updateSiteProduct()
     */
    public function updateSiteProduct($siteProd) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Site_BoSiteProduct::COL_SITE_DOMAIN => $siteProd->getSiteDomain(),
                Quack_Bo_Site_BoSiteProduct::COL_CONFIG => $siteProd->getProductConfig(),
                Quack_Bo_Site_BoSiteProduct::COL_EXPIRY => (int)$siteProd->getProductExpiry(),
                Quack_Bo_Site_BoSiteProduct::COL_LEVEL => (int)$siteProd->getProductLevel(),
                Quack_Bo_Site_BoSiteProduct::COL_NAME => $siteProd->getProductName(),
                Quack_Bo_Site_BoSiteProduct::COL_TIMESTAMP => (int)$siteProd->getProductTimestamp());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateSiteProdCache($siteProd);
        $cacheKey = $this->createCacheKeySiteProduct($siteProd->getSiteDomain(), $siteProd->getProductName());
        $this->putToCache($cacheKey, $siteProd);
        return $result;
    }
}
