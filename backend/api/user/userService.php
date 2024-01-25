<?php
header("Content-Type: application/json;");
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../class/user.php';

$database = new DB();
$db = $database->getConnection();

$users = new User($db);

if (isset($_GET['categoryIds'])) {
    $categoryIds = json_decode($_GET['categoryIds']);

    $stmt = $users->getUsersByCategories($categoryIds);
    $usersCount = $stmt->rowCount();

    if ($usersCount > 0) {
        $usersArr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user = array(
                "id" => $id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email
            );

            array_push($usersArr, $user);
        }
        echo json_encode($usersArr);
    } else {
        echo json_encode(array()); 
    }
} else {
    echo json_encode(array("error" => "Category IDs not provided."));
}
?>
