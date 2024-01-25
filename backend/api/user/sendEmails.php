<?php
header("Content-Type: application/json;");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../class/user.php';

include "../consts.php";

$database = new DB();
$db = $database->getConnection();

$users = new User($db);

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

    http_response_code(200);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    error_log("Received data: " . print_r($data, true));

    if (isset($data->categoryIds, $data->message)) {
        $categoryIds = json_decode($data->categoryIds);
        $message = $data->message;
        $includeName = isset($data->includeName) ? $data->includeName : false;
        $includeLastName = isset($data->includeLastName) ? $data->includeLastName : false;
        $useDefaultMessage = isset($data->useDefaultMessage) ? $data->useDefaultMessage : false;

        $stmt = $users->getUsersByCategories($categoryIds);
        $usersCount = $stmt->rowCount();

        error_log("users count: " . print_r($usersCount, true));

        if ($usersCount > 0) {
            $uniqueEmails = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                if (!isset($uniqueEmails[$email])) {
                    $to = $email;
                    $subject = 'Email subject';

                    $formattedMessage = "";
                    if ($includeName) {
                        $formattedMessage .= "Name: $first_name\n";
                    }
                    if ($includeLastName) {
                        $formattedMessage .= "Last Name: $last_name\n";
                    }
                    if ($useDefaultMessage){
                        $formattedMessage .= DEFAULT_MESSAGE;
                    } else {
                        $formattedMessage .= $message;
                    }

                    $headers = 'From: your-email@example.com' . "\r\n" .
                        'Reply-To: your-email@example.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    // Send the email
                    if (mail($to, $subject, $formattedMessage, $headers)) {
                        error_log("Email sent successfully to: " . $to);
                    } else {
                        error_log("Failed to send email to: " . $to);
                    }

                    // Mark the email as processed
                    $uniqueEmails[$email] = true;
                }
}

            echo json_encode(array("success" => "Emails sent successfully."));
        } else {
            echo json_encode(array("error" => "No users found for the selected categories."));
        }
    } else {
        echo json_encode(array("error" => "Category IDs or message not provided."));
    }
} else {
    echo json_encode(array("error" => "Invalid request method."));
}
?>
