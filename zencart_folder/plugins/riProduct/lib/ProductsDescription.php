<?php 

namespace plugins\riProduct;

use plugins\riCore\Model;

class ProductsDescription extends Model{
    
    protected $table = TABLE_PRODUCTS_DESCRIPTION;
    
    public function save($new = false){
        $data = $this->getArray();
        if(!$new){        
            unset($data['products_id']);
            unset($data['language_id']);
            zen_db_perform($this->table, $data, 'update', ' products_id = ' . $this->get('products_id') . ' AND language_id = ' . $this->get('language_id'));
        }
        else{
            zen_db_perform($this->table, $data);            
        }
        
        return $this;
    }
}