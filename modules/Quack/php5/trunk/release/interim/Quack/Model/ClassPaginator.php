<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Model object: Paginator.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package Quack
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version $Id: ClassICache.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since File available since v0.1
 */

/**
 * Model object: Paginator.
 *
 * @package Quack
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Quack_Model_Paginator {

    private $numVisiblePages = 11;
    private $numEntries = 0;
    private $pageSize = 1;
    private $currentPage = 1;
    private $urlTemplate;

    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * Construts a new {@link Quack_Model_Paginator} object.
     *
     * @param string $urlTemplate
     * @param int $numEntries
     * @param int $pageSize
     * @param int $currentPage
     * @param int $numVisiblePages
     */
    public function __construct($urlTemplate, $numEntries, $pageSize, $currentPage = 1, $numVisiblePages = 11) {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        $this->urlTemplate = $urlTemplate;
        $this->numEntries = $numEntries;
        $this->pageSize = $pageSize;
        $this->currentPage = $currentPage;
        $this->numVisiblePages = $numVisiblePages;
    }

    /**
     * Gets the current page number.
     *
     * @return int
     */
    public function getCurrentPage() {
        return $this->currentPage;
    }

    /**
     * Sets the current page number.
     *
     * @param int $currentPage
     */
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }

    /**
     * Gets the number of visible pages.
     *
     * @return int
     */
    public function getNumVisiblePages() {
        return $this->numVisiblePages;
    }

    /**
     * Sets the number of visible pages.
     *
     * @param int $numVisiblePages
     */
    public function setNumVisiblePages($numVisiblePages) {
        $this->numVisiblePages = $numVisiblePages;
    }

    /**
     * Gets number of pages.
     *
     * @return int
     */
    public function getNumPages() {
        $numPages = (int)($this->numEntries / $this->pageSize);
        return $numPages * $this->pageSize == $this->numEntries ? $numPages : $numPages + 1;
    }

    /**
     * Sets number of entries.
     *
     * @param int $numEntries
     */
    public function setNumEntries($numEntries) {
        $this->numEntries = $numEntries;
    }

    /**
     * Sets number of entries per page.
     *
     * @param int $pageSize
     */
    public function setPageSize($pageSize) {
        $this->pageSize = $pageSize;
    }

    /**
     * Sets the url template.
     *
     * @param string $urlTemplate
     */
    public function setUrlTemplate($urlTemplate) {
        $this->urlTemplate = $urlTemplate;
    }

    /**
     * Gets the url for a page.
     *
     * @param int $pageNum
     * @return string
     */
    public function getUrlForPage($pageNum) {
        $url = $this->urlTemplate;
        $searchTerms = Array('/\$\{PAGE_NUMBER\}/i',
                '/\$\{PAGE_NUM\}/i',
                '/\$\{pageNumber\}/i',
                '/\$\{pageNum\}/i',
                '/\$\{page\}/i');
        $url = $this->templateReplace($url, $searchTerms, $pageNum);
        return $url;
    }

    /**
     * Gets list of visible pages.
     *
     * @return Array
     */
    public function getVisiblePages() {
        $result = Array();
        $numPages = $this->getNumPages();
        if ($numPages > $this->numVisiblePages) {
            $result[] = $this->currentPage;

            // tail
            for ($temp = $this->currentPage + 1; $temp <= $this->currentPage + 2; $temp++) {
                if ($temp <= $numPages) {
                    $result[] = $temp;
                }
            }
            if ($this->currentPage + 2 < $numPages) {
                if ($this->currentPage + 4 < $numPages) {
                    $result[] = 0;
                }
                if ($this->currentPage + 3 < $numPages) {
                    $result[] = $numPages - 1;
                }
                $result[] = $numPages;
            }

            // head
            for ($temp = $this->currentPage - 1; $temp >= $this->currentPage - 2; $temp--) {
                if ($temp >= 1) {
                    array_unshift($result, $temp);
                }
            }
            if ($this->currentPage - 2 > 1) {
                if ($this->currentPage - 4 > 1) {
                    array_unshift($result, 0);
                }
                if ($this->currentPage - 3 > 1) {
                    array_unshift($result, 2);
                }
                array_unshift($result, 1);
            }
        } else {
            for ($i = 1; $i <= $numPages; $i++) {
                $result[] = $i;
            }
        }
        return $result;
    }

    private function templateReplace($subject, $searchTerms = Array(), $replacement = '') {
        foreach ($searchTerms as $term) {
            $subject = preg_replace($term, $replacement, $subject);
        }
        return $subject;
    }
}
