<?php
abstract class Quack_Bo_Page_BasePageDao extends Quack_Bo_BaseDao implements Quack_Bo_Page_IPageDao {

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
     * Creates the cache key for page.
     *
     * @param mixed $pageId
     */
    protected function createCacheKeyPage($pageId) {
        return "PAGE_$pageId";
    }

    /**
     * Invalidates the page cache due to change.
     *
     * @param Quack_Bo_Page_BoPage $page
     */
    protected function invalidatePageCache($page = NULL) {
        if ($page !== NULL) {
            $cacheKey = $this->createCacheKeyPage($page->getId());
            $this->deleteFromCache($cacheKey);
        }
    }

    private function hasFilterCategory($filter) {
        return isset($filter[self::FILTER_CATS]) && is_array($filter[self::FILTER_CATS]) && count($filter[self::FILTER_CATS]) > 0;
    }

    private function hasFilterAttr($filter) {
        return isset($filter[self::FILTER_ATTRS]) && is_array($filter[self::FILTER_ATTRS]) && count($filter[self::FILTER_ATTRS]) > 0;
    }

    /**
     *
     * @see Quack_Bo_Page_IPageDao::countNumPages()
     */
    public function countNumPages($filter = Array()) {
        $hasFilterCat = $this->hasFilterCategory($filter);
        $hasFilterAttr = $this->hasFilterAttr($filter);

        if ($hasFilterAttr && $hasFilterCat) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.filterAll');
        } elseif ($hasFilterAttr) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.filterAttr');
        } elseif ($hasFilterCat) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.filterCat');
        } else {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        }

        $params = Array();
        if ($hasFilterAttr) {
            $params['pageAttrs'] = $filter[self::FILTER_ATTRS];
        }
        if ($hasFilterCat) {
            $params['pageCategories'] = $filter[self::FILTER_CATS];
        }

        $result = $this->execCount($sqlStm, $params);
        return (int)$result;
    }

    /**
     *
     * @see Quack_Bo_Page_IPageDao::createPage()
     */
    public function createPage($page) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Page_BoPage::COL_ID => $page->getId(),
                Quack_Bo_Page_BoPage::COL_POSITION => $page->getPosition(),
                Quack_Bo_Page_BoPage::COL_TITLE => $page->getTitle(),
                Quack_Bo_Page_BoPage::COL_CONTENT => $page->getContent(),
                Quack_Bo_Page_BoPage::COL_CATEGORY => $page->getCategory(),
                Quack_Bo_Page_BoPage::COL_ATTR => $page->getAttr());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidatePageCache();
    }

    /**
     *
     * @see Quack_Bo_Page_IPageDao::deletePage()
     */
    public function deletePage($page) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Page_BoPage::COL_ID => $page->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidatePageCache($page);
        return $result;
    }

    /**
     *
     * @see Quack_Bo_Page_IPageDao::getPageById()
     */
    public function getPageById($id) {
        $cacheKey = $this->createCacheKeyPage($id);
        $page = $this->getFromCache($cacheKey);
        if ($page === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Quack_Bo_Page_BoPage::COL_ID => $id);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $page = new Quack_Bo_Page_BoPage();
                $page->populate($rows[0]);
                $this->putToCache($cacheKey, $page);
            }
        }
        return $page;
    }

    /**
     *
     * @see Quack_Bo_Page_IPageDao::getPages()
     */
    public function getPages($pageNum = 1, $pageSize = PHP_INT_MAX, $filter = Array()) {
        $hasFilterCat = $this->hasFilterCategory($filter);
        $hasFilterAttr = $this->hasFilterAttr($filter);

        if ($hasFilterAttr && $hasFilterCat) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.filterAll');
        } elseif ($hasFilterAttr) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.filterAttr');
        } elseif ($hasFilterCat) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.filterCat');
        } else {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        }

        $params = Array(self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize,
                self::PARAM_PAGE_SIZE => $pageSize);
        if ($hasFilterAttr) {
            $params['pageAttrs'] = $filter[self::FILTER_ATTRS];
        }
        if ($hasFilterCat) {
            $params['pageCategories'] = $filter[self::FILTER_CATS];
        }

        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $rows = $this->execSelect($sqlStm, $params);
        $result = Array();
        if ($rows !== NULL) {
            foreach ($rows as $row) {
                $pageId = $row[Quack_Bo_Page_BoPage::COL_ID];
                $page = $this->getPageById($pageId);
                $result[] = $page;
            }
        }
        return $result;
    }

    /**
     *
     * @see Quack_Bo_Page_IPageDao::updatePage()
     */
    public function updatePage($page) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Quack_Bo_Page_BoPage::COL_ID => $page->getId(),
                Quack_Bo_Page_BoPage::COL_POSITION => $page->getPosition(),
                Quack_Bo_Page_BoPage::COL_TITLE => $page->getTitle(),
                Quack_Bo_Page_BoPage::COL_CONTENT => $page->getContent(),
                Quack_Bo_Page_BoPage::COL_CATEGORY => $page->getCategory(),
                Quack_Bo_Page_BoPage::COL_ATTR => $page->getAttr());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidatePageCache($page);
        return $result;
    }
}
