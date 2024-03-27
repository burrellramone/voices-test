<?php
namespace VoicesTest\Model;

use PDO;
use Exception;

//
use VoicesTest\Database;

abstract class Model {
    public int $id = -1;

    public function __construct(){
    }

    /**
     * Gets the id of this instance
     * 
     * @return int The id of this instance of the model
     */
    public function getId():int {
        return $this->id;
    }

    abstract static public function getTableName():string; 

    /**
     * Finds a record of a model by a provided id
     *
     * @param integer $id The id of the record
     * @return Model|NULL An instane of the model if the record was found, NULL otherwise
     */
    public static function findById(int $id):?Model {
        $db = Database::getInstance();
        $instance = null;

        $called_class = get_called_class();
        $table_name = $called_class::getTableName();
        
        $query = "SELECT * FROM `{$table_name}` WHERE id = :record_id";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':record_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $instance = $stmt->fetchObject($called_class);

        if(!$instance){
            return null;
        }

        return $instance;
    }

    public function delete():void {
        $db = Database::getInstance();

        $id = $this->id;
        $class = get_class($this);
        $table_name = $class::getTableName();

        $query = "DELETE FROM `{$table_name}` WHERE id = :id";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}