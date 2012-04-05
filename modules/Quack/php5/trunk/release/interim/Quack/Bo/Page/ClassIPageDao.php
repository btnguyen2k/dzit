<?php
interface Quack_Bo_Page_IPageDao extends Ddth_Dao_IDao {

    const FILTER_CATS = 'cats'; // filtered by categories
    const FILTER_ATTRS = 'attrs'; // filtered by attributes

    const PARAM_START_OFFSET = 'startOffset';
    const PARAM_PAGE_SIZE = 'pageSize';

    /**
     * Counts number of current pages.
     *
     * @param Array $filter
     * @return int
     */
    public function countNumPages($filter = Array());

    /**
     * Creates a new page.
     *
     * @param Quack_Bo_Page_BoPage $page
     */
    public function createPage($page);

    /**
     * Deletes a page.
     *
     * @param Quack_Bo_Page_BoPage $page
     */
    public function deletePage($page);

    /**
     * Gets a page by id.
     *
     * @param string $id
     * @return Quack_Bo_Page_BoPage
     */
    public function getPageById($id);

    /**
     * Gets pages as a list.
     *
     * @param Array $filter
     * @return Array
     */
    public function getPages($pageNum = 1, $pageSize = PHP_INT_MAX, $filter = Array());

    /**
     * Updates a page.
     *
     * @param Quack_Bo_Page_BoPage $page
     */
    public function updatePage($page);
}
