<?php
namespace plugins\riCore;

use Symfony\Component\Validator\Constraints\Email;

use plugins\riResultList\ResultSource;
use plugins\riPlugin\Plugin;

class Collection extends ResultSource{
    
    protected $model, $model_service = '';
    
    public function __construct(){
        if(!empty($this->model_service)) $this->model = Plugin::get($this->model_service);         
    }
    
    public function setModel($model){
        $this->model = $model;  
        return $this;  
    }
    
    public function findById($id){
        global $db;
        
        $sql = "SELECT * FROM ".$this->model->getTable()." WHERE ".$this->model->getId()." = :id";
        $sql = $db->bindVars($sql, ':id', $id, 'integer');
        
        $result = $db->Execute($sql);
        
        if($result->RecordCount())
            return $this->create($result->fields);
        return false;
    }
    
    public function create($data){
        $object = clone $this->model;
        return $object->create($data);        
    }
}