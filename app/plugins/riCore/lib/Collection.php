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

use Symfony\Component\Validator\Constraints\Email;

use plugins\riResultList\ResultSource;
use plugins\riPlugin\Plugin;

/**
 * core collection class (holding the model objects)
 */
class Collection extends ResultSource{

    /**
     * mock object
     *
     * @var null
     */
    protected $mock_object = null;

    /**
     * model service
     *
     * @var string
     */
    protected $model_service = '';

    /**
     * array of objects
     *
     * @var array
     */
    protected $collection = array(0 => false);

    /**
     * sets the model service to be used when returning object from collection
     * <code>
     * setModelService('riMeta.Meta');
     * </code>
     * @param $model_service
     * @return Collection
     */
    public function setModelService($model_service){
        $this->model_service = $model_service;
        return $this;
    }

    /**
     * sets mock object in case no model service is available
     * @param $mock_object
     * @return Collection
     */
    public function setMockObject($mock_object){
        $this->mock_object = $mock_object;
        return $this;
    }

    /**
     * gets the mock object
     * @return object
     */
    public function getMockObject(){
        if($this->mock_object === null) $this->mock_object = Plugin::get($this->model_service);
        return $this->mock_object;
    }

    /**
     * finds all the objects within the collection
     * @return array of objects
     */
    public function findAll(){
        if($this->collection[0] === false){
            global $db;
            $this->collection = array();
            $result = $db->Execute("select * FROM " . $this->getMockObject()->getTable());
            while(!$result->EOF){
                $this->collection[$result->fields[Plugin::get($this->model_service)->getId()]] = Plugin::get($this->model_service)->setArray($result->fields);
                $result->MoveNext();
            }
        }
        return $this->collection;
    }

    /**
     * the magical find methods
     * can support un-predefined methods such as
     * findByProductsNameAndProductsStatus('name', 'string', 1, 'integer');
     * findByProductsNameAndProductsStatusOrMasterCategoriesId('name', 'string', 1, 'integer', 19, 'integer');
     * parameters must be passed in pairs value, datatype
     * @param string $name
     * @param array $args
     * @return array|bool|mixed
     */
    public function __call($name, $args){
        if(strpos($name, 'findBy') === 0){
            $field_names = Plugin::get('riUtility.String')->fromCamelCase(substr($name, 6));

            $field_names = preg_split('/(_or_|_and_)/', $field_names, -1, PREG_SPLIT_DELIM_CAPTURE);

            global $db;

            $field_names_count = count($field_names);

            $sql = "SELECT * FROM ".$this->getMockObject()->getTable()." WHERE ";
            if($field_names_count == 1) {
                $sql .= $db->bindVars($field_names[0] . " = :id", ':id', $args[0], isset($args[1]) ? $args[1] : 'string');
            }
            else{
                $j = $i = 0;
                while($i < $field_names_count){
                    $sql .= $db->bindVars($field_names[$i] . " = :arg", ':arg', $args[$j++], $args[$j++]);
                    if($i + 1 < $field_names_count)
                        $sql .= ' ' . trim($field_names[$i+1], '_') . ' ';
                    $i = $i + 2;
                }
            }

            // TODO: better way to map field?
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

    /**
     * finds an object by id, this method may be dropped in the future in favor of the magical find above
     * @param $id
     * @return bool
     */
    public function findById($id){
        if(!isset($this->collection[$id])){
            global $db;

            $sql = "SELECT * FROM ".$this->getMockObject()->getTable()." WHERE ".$this->getMockObject()->getId()." = :id";
            $sql = $db->bindVars($sql, ':id', $id, 'integer');

            $result = $db->Execute($sql);

            if($result->RecordCount())
                $this->collection[$id] = $this->create($result->fields);
        }
        return isset($this->collection[$id]) ? $this->collection[$id] : false;
    }

    /**
     * creates a new object from the array data
     * @param $data
     * @return mixed
     */
    public function create($data){
        return Plugin::get($this->model_service)->create($data);
    }
}