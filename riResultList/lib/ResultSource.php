<?php
namespace plugins\riResultList;

use plugins\riCore\Object;

class ResultSource extends Object implements ResultSourceInterface{
    protected $resultList_, $model, $from, $select;
    /**
     * Set the corresponding result list.
     *
     * @param ZMResultList resultList The *parent* result list.
     */        
    
    public function select($select){
        $this->select = $select;
        return $this;
    }
    
    public function from($from){
        $this->from = $from;
        return $this;
    }
    
    public function setResultList($resultList){
        $this->resultList_ = $resultList;
        return $this;
    }

    /**
     * Get the results.
     *
     * @param boolean reload Optional reload flag; default is <code>false</code>.
     *
     * @return array List of results.
     */
        
    
    public function getResults($reload=false){
        global $db;                

        $sql = 'SELECT ' . $this->select . ' FROM ' . $this->from;
		$sql = $this->resultList_->buildPaginationQuery($sql);			
		$result = $db->Execute($sql);
		
		$results = array();
		while(!$result->EOF){
			$results[] = $this->create($result->fields);			
			$result->MoveNext();
		}
		return $results;
    }

    /**
     * Get the class name of the results.
     *
     * @return string The class name of the results.
     */
    public function getResultClass(){
        
    }

    /**
     * Total number of results.
     *
     * @return int The total number if results.
     */
    public function getTotalNumberOfResults(){
        global $db;
		$sql = 'SELECT COUNT(*) AS count FROM ' . $this->from;
		
		$sql = $this->resultList_->buildBaseQuery($sql);
			
		$result = $db->execute($sql);
		return $result->fields['count'];
    }

    /**
     * Indicates whether the returned results are final or not.
     *
     * <p>Sources may opt to filter and sort results already (for example for performance
     * reasons. In that case, no further action is required by the result list.</p>
     *
     * <p>As a side effect, the method <code>getAllResults()</code> may then return the same
     * results (number and sort order) as <code>getResults()</code>, even if the source
     * reports more than one page.</p>
     *
     * @return boolean <code>true</code> if the result source is handling all sorting and filtering, too.
     */
    public function isFinal(){
        
    }
}