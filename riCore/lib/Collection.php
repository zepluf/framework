<?php
namespace plugins\riCore;

use Symfony\Component\Validator\Constraints\Email;

use plugins\riResultList\ResultSource;
use plugins\riPlugin\Plugin;

class Collection extends ResultSource{
    
    protected $model, $model_service = '', $collection = array(0 => false), $map = array();
    
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

    public function __call($name, $args){
        if(strpos($name, 'findBy') === 0){
            $field_name = Plugin::get('riUtility.String')->fromCamelCase(substr($name, 6));

            global $db;

            $sql = "SELECT * FROM ".$this->model->getTable()." WHERE ".$field_name." = :id";

            // TODO: better way to map field?
            $sql = $db->bindVars($sql, ':id', $args[0], isset($args[1]) ? $args[1] : 'string');

            $result = $db->Execute($sql);

            $collection = array();
            if($result->RecordCount()){
                $collection[] = $this->create($result->fields);
            }

            $count = count($collection);
            if($count == 0) return false;
            if($count == 1) return $collection[0];
            else return $collection;
        }
        else
            return parent::__call($name, $args);
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