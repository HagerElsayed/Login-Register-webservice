<?php

require_once 'Database/databaseModel.php';
header('Content-type: application/json');
header("HTTP/1.1 200 OK");
header("Cache-Control:no-cache");

$db = new DatabaseModel();
$response = array("error" => FALSE);
 
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['mobile'])) {
 
    // receiving the post params
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];

    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($password < '8') {
            $response["error"] = TRUE;
            $response["error_msg"] = "Password must be more than or Equal 8 char";
            echo json_encode($response);
        }
        
   
 
    // check if user is already existed with the same email
    if ($db->isUserExisted($email)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $email;
        echo json_encode($response);
    } else {
       
        // create a new user
        $user = $db->insertUser($name, $email, $mobile, $password);
        $token = array();
        // $token['email'] = $email;
        // echo JWT::encode($token, 'secret_server_key');
        if ($user) {
           
            $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["mobile"] = $user["mobile"];
            // $response["user"]["password"] = $user["password"];
            $response["user"]["created_at"] = $user["created_at"];
           
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
     
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email, password or mobile) is missing!";
    echo json_encode($response);
}
?>