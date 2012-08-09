<?php
namespace plugins\riCore;

use Symfony\Component\Validator\Constraints\Email;

use plugins\riResultList\ResultSource;
use plugins\riPlugin\Plugin;

class Collection extends ResultSource{
    
    protected $model, $model_service = '', $collection = array();
    
    public function __construct(){
        if(!empty($this->model_service)) $this->model = Plugin::get($this->model_service);         
    }
    
    public function setModel($model){
        $this->model = $model;  
        return $this;  
    }
    
    public function findAll(){
        if(empty($this->collection)){
            global $db;
            $result = $db->Execute("select * FROM " . $this->model->getTable());
            while(!$result->EOF){
                $this->collection[$result->fields[Plugin::get($this->model_service)->getId()]] = Plugin::get($this->model_service)->setArray($result->fields);
                $result->MoveNext();
            }
        }
		return $this->collection;
	}
	
    public function findById($id){
        if(!isset($this->collection[$id])){
            global $db;

            $sql = "SELECT * FROM ".$this->model->getTable()." WHERE ".$this->model->getId()." = :id";
            $sql = $db->bindVars($sql, ':id', $id, 'integer');

            $result = $db->Execute($sql);

            if($result->RecordCount())
                $this->collection[$id] = $this->create($result->fields);
        }
        return isset($this->collection[$id]) ? $this->collection[$id] : false;
    }
    
    public function create($data){
        return Plugin::get($this->model_service)->create($data);
    }
}