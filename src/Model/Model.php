<?php
namespace VoicesTest;

abstract class Model {
    protected int $id = -1;

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
}