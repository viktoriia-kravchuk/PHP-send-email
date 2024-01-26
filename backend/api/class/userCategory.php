<?php
class UserCategory
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET Categories Users
        
    public function getUsersByCategories($categoryIds)
    {
        if (!is_array($categoryIds)) {
            $categoryIds = array($categoryIds);
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
        $sqlQuery = GET_USERS_BY_CATEGORIES_QUERY;
        $sqlQuery = str_replace(':placeholders', $placeholders, $sqlQuery);
        $stmt = $this->conn->prepare($sqlQuery);

        foreach ($categoryIds as $key => $categoryId) {
            $stmt->bindValue(($key + 1), $categoryId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt;
    }
}
?>