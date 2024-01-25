<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json;");
    
    include_once '../config/database.php';
    include_once '../class/category.php';

    $database = new DB();
    $db = $database->getConnection();

    $categories = new Category($db);

    $stmt = $categories->getCategories();
    $categoriesCount = $stmt->rowCount();

    if($categoriesCount > 0){
        
        $categoriesArr = array();
       
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name
            );

            array_push($categoriesArr, $e);
        }
        echo json_encode($categoriesArr);
    }
    else{
        echo json_encode();
    }

?>