<?php
/**
 * Pager is the base class for all pagers.
 *
 * It provides the calculation of page count and maintains the current page.
 *
 * @property Pagination $pages The pagination information.
 * @property integer $pageSize Number of items in each page.
 * @property integer $itemCount Total number of items.
 * @property integer $pageCount Number of pages.
 * @property integer $currentPage The zero-based index of the current page. Defaults to 0.
 *
 */

namespace app\widgets\base;

use \yii\base\Widget;

abstract class Pager extends Widget
{
	private $_pages;

	/**
	 * Returns the pagination information used by this pager.
	 * @return Pagination the pagination information
	 */
	public function getPages()
	{
		if($this->_pages===null)
			$this->_pages=$this->createPages();
		return $this->_pages;
	}

	/**
	 * Sets the pagination information used by this pager.
	 * @param Pagination $pages the pagination information
	 */
	public function setPages($pages)
	{
		$this->_pages=$pages;
	}

	/**
	 * Creates the default pagination.
	 * This is called by {@link getPages} when the pagination is not set before.
	 * @return Pagination the default pagination instance.
	 */
	protected function createPages()
	{
		return new Pagination;
	}

	/**
	 * @return integer number of items in each page.
	 * @see Pagination::getPageSize
	 */
	public function getPageSize()
	{
		return $this->getPages()->getPageSize();
	}

	/**
	 * @param integer $value number of items in each page
	 * @see Pagination::setPageSize
	 */
	public function setPageSize($value)
	{
		$this->getPages()->setPageSize($value);
	}

	/**
	 * @return integer total number of items.
	 * @see Pagination::getItemCount
	 */
	public function getItemCount()
	{
		return $this->getPages()->getItemCount();
	}

	/**
	 * @param integer $value total number of items.
	 * @see Pagination::setItemCount
	 */
	public function setItemCount($value)
	{
		$this->getPages()->setItemCount($value);
	}

	/**
	 * @return integer number of pages
	 * @see Pagination::getPageCount
	 */
	public function getPageCount()
	{
		return $this->getPages()->getPageCount();
	}

	/**
	 * @param boolean $recalculate whether to recalculate the current page based on the page size and item count.
	 * @return integer the zero-based index of the current page. Defaults to 0.
	 * @see Pagination::getCurrentPage
	 */
	public function getCurrentPage($recalculate=true)
	{
		return $this->getPages()->getPage($recalculate);
	}

	/**
	 * @param integer $value the zero-based index of the current page.
	 * @see Pagination::setCurrentPage
	 */
	public function setCurrentPage($value)
	{
		$this->getPages()->setPage($value);
	}

	/**
	 * Creates the URL suitable for pagination.
	 * @param integer $page the page that the URL should point to.
	 * @return string the created URL
	 * @see Pagination::createPageUrl
	 */
	protected function createPageUrl($page)
	{
		return $this->getPages()->createUrl($page);
	}
}
