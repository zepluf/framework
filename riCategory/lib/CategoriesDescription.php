<?php 

namespace plugins\riCategory;

use plugins\riCore\Model;

class CategoriesDescription extends Model{
    
    protected $table = TABLE_CATEGORIES_DESCRIPTION;
    
    public function save($new = false){
        $data = $this->getArray();
        if(!$new){        
            unset($data['categories_id']);
            unset($data['language_id']);
            zen_db_perform($this->table, $data, 'update', ' categories_id = ' . $this->get('categories_id') . ' AND language_id = ' . $this->get('language_id'));
        }
        else{
            zen_db_perform($this->table, $data);            
        }
        
        return $this;
    }
}