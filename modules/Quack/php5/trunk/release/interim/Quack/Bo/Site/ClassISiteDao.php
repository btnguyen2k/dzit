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
     * Creates a new product.
     *
     * @param Quack_Bo_Site_BoProduct $product
     */
    public function createProduct($product);

    /**
     * Creates a new site.
     *
     * @param Quack_Bo_Site_BoSite $site
     */
    public function createSite($site);

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
     * Gets a product by name.
     *
     * @param Quack_Bo_Site_BoSite $site
     * @param string $name
     * @return Quack_Bo_Site_BoProduct
     */
    public function getProductByName($site, $name);

    /**
     * Gets a site by domain.
     *
     * @param string $domain
     * @return Quack_Bo_Site_BoSite
     */
    public function getSiteByDomain($domain);

    /**
     * Gets all products for a site.
     *
     * @param Quack_Bo_Site_BoSite $site
     */
    public function getProductsForSite($site);

    /**
     * Gets sites as a list.
     *
     * @param Array $filter
     * @return Array
     */
    public function getSites($pageNum = 1, $pageSize = PHP_INT_MAX, $filter = Array());

    /**
     * Updates a site.
     *
     * @param Quack_Bo_Site_BoSite $site
     */
    public function updateSite($site);
}
