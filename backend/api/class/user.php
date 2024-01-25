<?php
class User
{
    private $conn;

    private $dbTable = "users";
    private $user_category = "user_category";

    public $id;
    public $first_name;
    public $last_name;
    public $email;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET Users
    public function getAllUsers()
    {
        $sqlQuery = "SELECT id, first_name, last_name, email FROM " . $this->dbTable;
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // GET Category Users
        
    public function getUsersByCategories($categoryIds)
    {
        if (!is_array($categoryIds)) {
            $categoryIds = array($categoryIds);
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));

        $sqlQuery = "SELECT {$this->dbTable}.*
                     FROM {$this->dbTable}
                     JOIN {$this->user_category} ON {$this->dbTable}.id = {$this->user_category}.user_id
                     WHERE {$this->user_category}.category_id IN ($placeholders)
                     GROUP BY {$this->dbTable}.id";

        $stmt = $this->conn->prepare($sqlQuery);

        foreach ($categoryIds as $key => $categoryId) {
            $stmt->bindValue(($key + 1), $categoryId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt;
    }
}
?>