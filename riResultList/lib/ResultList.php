<?php

namespace plugins\riResultList;

use plugins\riCore\Object;

/**
 * A (result) list that handles lists spanning multiple pages.
 *
 * <p>A result list operates on any given set of results. Results do not have to have
 * any specific properties, type specific code is delegated to filters and sorters.</p>
 *
 * <p>Results are obtained via the <code>ZMResultSource</code> object. This defers the actual
 * query to the latest possible moment. Methods may trigger the query if they depend
 * on results; a good example for that is, for example, <code>getNumberOfResults()</code>.</p>
 *
 * @author DerManoMann <mano@zenmagick.org>
 * @package org.zenmagick.mvc.resultlist
 */
class ResultList extends Object {
	protected $resultSource_;
    protected $sorters_;
    protected $filters_;
    protected $page_;
    protected $pagination_;
    protected $number_of_results_ = false;    
    protected $results_;
    
	function __construct() {        
        $this->resultSource_ = null;        
        $this->sorters_ = array();
        $this->filters_ = array();
        $this->number_of_results_ = false;
        $this->page_ = 1;
        $this->pagination_ = 15;        
        $this->results_ = null;
    }
    /**
     * Destruct instance.
     */
    function __destruct() {
        parent::__destruct();
    }


    /**
     * Set a source for results.
     *
     * <p>The advantage of using a result source is that alternative implementations are free
     * to ignore these, modify them or replace them as needed. Providing results via
     * the constructor means that the resources used to build that list might be wasted.</p>
     *
     * @param ZMResultSource resultSource A result source.
     */
    public function setResultSource($source) {
        $this->resultSource_ = $source;
        $this->resultSource_->setResultList($this);           
        $this->results_ = null;
    }    

    /**
     * Checks if there are results available.
     *
     * @return boolean <code>true</code> if results are available, <code>false</code> if not.
     */
    public function hasResults() {
        return 0 < count($this->getResults());
    }

    /**
     * Count all results.
     *
     * @return int The total number if results.
     */
    public function getNumberOfResults() {
        if($this->number_of_results_ === false)
            $this->number_of_results_ = $this->resultSource_->getTotalNumberOfResults();
        return $this->number_of_results_;
    }

	public function getNumberOfCurrentResults() {
        return count($this->$results);
    }
    
    /**
     * Get the page number (1-based).
     *
     * @return int The page number.
     */
    public function getPageNumber() {
        return $this->page_;
    }

    /**
     * Set the page number (1-based).
     *
     * @param int page The page number.
     */
    public function setPageNumber($page) {
        $this->page_ = (0 < $page ? $page : 1);
        $this->results_ = null;
    }

    /**
     * Get the configured pagination.
     *
     * @return int The number of results per page.
     */
    public function getPagination() {
        return $this->pagination_;
    }

    public function addSorter($sorter){
    	$this->sorters_[] = $sorter;
    }
    
    
    public function getSorters(){
    	return $this->sorters_;
    }
    
	public function getSortersString(){
    	return count($this->sorters_) > 0 ? implode(" , ", $this->sorters_) : '';
    }
    
	public function addFilter($filter){
    	$this->filters_[] = $filter;
    }
    
    public function addFilters($filters, $map){
        foreach ($filters as $key => $value){    
            if(isset($map[$key])){        
                $filter = $map[$key]['field'] . $map[$key]['condition'] . (isset($map[$key]['bind']) ? $map[$key]['bind']($value) : $value);            
                $this->addFilter($filter);
            }
        } 
    }
    
    public function getFilters(){
    	return $this->filters_;
    }
    
	public function getFiltersString(){
    	return count($this->filters_) > 0 ? implode(" AND ", $this->filters_) : '';
    }
    
    public function getLimit(){
    	$start = $this->getPageNumber() == 1 ? 0 : (($this->getPageNumber() -1 ) * $this->getPagination());
    	return array($start, $this->getPagination()); 
    }
    
    /**
     * Set the configured pagination.
     *
     * @param int pagination The number of results per page.
     */
    public function setPagination($pagination) {
        $this->pagination_ = $pagination;
        $this->results_ = null;
    }

    /**
     * Get the calculated number of pages.
     *
     * @return int The number of pages; will return <em>0</em> if no results available.
     */
    public function getNumberOfPages() {
        if (0 == $this->pagination_) {
            return 1;
        }
        return (int)ceil($this->getNumberOfResults() / $this->pagination_);
    }

    /**
     * Check if a previous page is available.
     *
     * @return boolean <code>true</code> if a previous page is available, <code>false</code> if not.
     */
    public function hasPreviousPage() {
        return 1 < $this->page_;
    }

    /**
     * Check if a next page is available.
     *
     * @return boolean <code>true</code> if a next page is available, <code>false</code> if not.
     */
    public function hasNextPage() {
        return $this->page_ < $this->getNumberOfPages();
    }

    /**
     * Get the previous page number.
     *
     * @return int The previous page number; (default: 1)
     */
    public function getPreviousPageNumber() {
        return $this->hasPreviousPage() ? ($this->page_ - 1) : 1;
    }

    /**
     * Get the next page number.
     *
     * @return int The next page number.
     */
    public function getNextPageNumber() {
        return $this->hasNextPage() ? ($this->page_ + 1) : $this->getNumberOfPages();
    }

    /**
     * Get the results for the current page.
     *
     * @return array List of results for the current page.
     */
    public function getResults() {
		$this->$results_ = $this->resultSource_->getResults();
		return $this->$results_;
    }
    
    public function buildBaseQuery($query){
        $where = $this->getFiltersString();
		if(!empty($where))
			$query .= " WHERE ".$where;					
			
	    return $query;
    }
    
    public function buildPaginationQuery($query){
        $query = $this->buildBaseQuery($query);
        
        // put in sorters
        $sorter = $this->getSortersString();
		if(!empty($sorter))
			$query .= " ORDER BY ".$sorter;
			
        // put in the limit
        list($start, $duration) = $this->getLimit();
        if($duration > 0)
		$query .= " Limit $start, $duration";
		
		return $query;
    }
}
