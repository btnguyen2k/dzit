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
     * Creates a new site.
     *
     * @param Quack_Bo_Site_BoSite $site
     */
    public function createSite($site);

    /**
     * Deletes a site.
     *
     * @param Quack_Bo_Site_BoSite $site
     */
    public function deleteSite($site);

    /**
     * Gets a site by domain.
     *
     * @param string $domain
     * @return Quack_Bo_Site_BoSite
     */
    public function getSiteByDomain($domain);

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
