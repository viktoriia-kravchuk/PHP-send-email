<?php
require_once '../constants.php';

    class Category{

        private $conn;
        public $id;
        public $name;
      
        public function __construct($db){
            $this->conn = $db;
        }

        public function getAllCategories(){
            $stmt = $this->conn->prepare(GET_ALL_CATEGORIES_QUERY);
            $stmt->execute();
            return $stmt;
        }
    }
?>