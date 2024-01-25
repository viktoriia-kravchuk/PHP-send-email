<?php
    class Category{

        private $conn;

        private $dbTable = "`categories`";

        public $id;
        public $name;
      
        public function __construct($db){
            $this->conn = $db;
        }

        public function getCategories(){
            $sqlQuery = "SELECT *
               FROM " . $this->dbTable . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
    }
?>