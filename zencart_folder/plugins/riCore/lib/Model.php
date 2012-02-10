<?php 
namespace plugins\riCore;

use plugins\riPlugin\Object;

class Model extends Object{
    
    protected $table, $id;
    
    public function init($table, $id){
        $this->table = $table;
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }
    
    public function getTable(){
        return $this->table;
    }
    
    public function create($data){
        return $this->setArray($data);    
    }
    
    public function save(){
        $data = $this->getArray();
        if($this->has($this->id) && $this->get($this->id) > 0){        
            unset($data[$this->id]);
            zen_db_perform($this->table, $data, 'update', $this->id . ' = ' . $this->get($this->id));
        }
        else{
            zen_db_perform($this->table, $data);
            $this->set($this->id, mysql_insert_id());
        }
        
        return $this;
    }
    
    public function delete(){
        global $db;
        $sql = "DELETE FROM " . $this->table . " WHERE " . $this->id . " = :".$this->id;
        $sql = $db->bindVars($sql, ":".$this->id, $this->get($this->id), 'integer');
        $db->Execute($sql);
        
        return mysql_affected_rows() > 0;
    }        
}