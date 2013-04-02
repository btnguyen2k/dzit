<?php
interface Quack_Bo_Site_ISiteDao extends Ddth_Dao_IDao {

    const PARAM_START_OFFSET = 'startOffset';
    const PARAM_PAGE_SIZE = 'pageSize';

    /**
     * Counts number of current sites.
     *
     * @param Array $filter
     * @return int
     */
    public function countNumSites($filter = Array());

    /**
     * Counts number of current products.
     *
     * @param Array $filter
     * @return int
     */
    public function countNumProducts($filter = Array());

    /**
     * Counts number of current products for a site.
     *
     * @param Quack_Bo_Site_BoSite $site
     * @param Array $filter
     */
    public function countNumProductsForSite($site, $filter = Array());

    /**
     * Creates a new product.
     *
     * @param Quack_Bo_Site_BoSiteProduct $product
     */
    public function createProduct($product);

    /**
     * Creates a new site.
     *
     * @param Quack_Bo_Site_BoSite $site
     */
    public function createSite($site);

    /**
     * Adds a site-product.
     *
     * @param Quack_Bo_Site_BoSiteProduct $siteProd
     */
    public function createSiteProduct($siteProd);

    /**
     * Deletes a product.
     *
     * @param Quack_Bo_Site_BoProduct $product
     */
    public function deleteProduct($product);

    /**
     * Deletes a site.
     *
     * @param Quack_Bo_Site_BoSite $site
     */
    public function deleteSite($site);

    /**
     * Removes a product from site.
     *
     * @param Quack_Bo_Site_BoSite $siteProd
     */
    public function deleteSiteProduct($siteProd);

    /**
     * Gets a product by name.
     *
     * @param string $name
     * @return Quack_Bo_Site_BoProduct
     */
    public function getProductByName($name);

    /**
     * Gets a site by domain.
     *
     * @param string $domain
     * @return Quack_Bo_Site_BoSite
     */
    public function getSiteByDomain($domain);

    /**
     * Gets a sitr-product by name.
     *
     * @param Quack_Bo_Site_BoSite $site
     * @param string $name
     * @return Quack_Bo_Site_BoSiteProduct
     */
    public function getSiteProductByName($site, $name);

    /**
     * Gets all products for a site.
     *
     * @param Quack_Bo_Site_BoSite $site
     * @return Array an index array of Quack_Bo_Site_BoSiteProduct
     */
    public function getProductsForSite($site);

    /**
     * Gets products as a list.
     *
     * @param Array $filter
     * @return Array
     */
    public function getProsucts($pageNum = 1, $pageSize = PHP_INT_MAX, $filter = Array());

    /**
     * Gets sites as a list.
     *
     * @param Array $filter
     * @return Array
     */
    public function getSites($pageNum = 1, $pageSize = PHP_INT_MAX, $filter = Array());

    /**
     * Updates a product.
     *
     * @param Quack_Bo_Site_BoProduct $product
     */
    public function updateProduct($product);

    /**
     * Updates a site.
     *
     * @param Quack_Bo_Site_BoSite $site
     */
    public function updateSite($site);

    /**
     * Updates a site-product.
     *
     * @param Quack_Bo_Site_BoSiteProduct $siteProd
     */
    public function updateSiteProduct($siteProd);
}
