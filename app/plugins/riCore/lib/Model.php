<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

namespace plugins\riCore;

/**
 * core model class
 */
class Model extends Object{

    /**
     * table name of the model
     *
     * @var
     */
    protected $table;

    /**
     * column name of the id field
     * @var
     */
    protected $id;

    /**
     * init the model with table name and id field name
     *
     * <code>
     * init (TABLE_PRODUCTS, 'products_id');
     * </code>
     *
     * @param $table
     * @param $id
     */
    public function init($table, $id){
        $this->table = $table;
        $this->id = $id;
    }

    /**
     * gets the id field name of our model
     * using the example above, we should get 'products_id' if we call this method
     *
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * gets the table name of the model
     * @return mixed
     */
    public function getTable(){
        return $this->table;
    }

    /**
     * creates and returns the object of our model using the input data array
     *
     * @param $data
     * @return mixed
     */
    public function create($data){
        return $this->setArray($data);
    }

    /**
     * saves the current object into database, if id already exists it will try to update instead
     *
     * @return Model
     */
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

    /**
     * delete the current object from database
     *
     * @return bool
     */
    public function delete(){
        global $db;
        $sql = "DELETE FROM " . $this->table . " WHERE " . $this->id . " = :".$this->id;
        $sql = $db->bindVars($sql, ":".$this->id, $this->get($this->id), 'integer');
        $db->Execute($sql);

        return mysql_affected_rows() > 0;
    }
}