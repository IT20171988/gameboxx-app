<?php
session_start();
require_once '../database/database.php';
require_once '../service/userService.php';
require_once '../model/Response.php';

$database = new Database();
$db = $database->getConnection();

$userService = new UserService($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action)) {
        if ($data->action === 'register') {
            // Ensure all fields are provided
            if (!empty($data->full_name) && !empty($data->email) && !empty($data->telephone) && !empty($data->password)) {
                $response = $userService->createUser(
                    $data->full_name,
                    $data->email,
                    $data->telephone,
                    $data->password
                );
                // Send the response
                $response->send();
            } else {
                // Send error response when data is incomplete
                Response::sendResponse(false, "Incomplete data", "Try again, all fields are required.");
            }
        }

        if ($data->action === 'login') {
            if (!empty($data->email) && !empty($data->password)) {

                $response = $userService->loginUser($data->email, $data->password);
                $_SESSION["loginstatus"] = "logged";
                $response->send();
            } else {
                Response::sendResponse(false, "Incomplete data", "Email and password are required for login.");
            }
        }

        if ($data->action === 'logout') {
            session_unset();
            session_destroy();
            echo json_encode(['status' => 'success', 'message' => 'Logged out successfully']);
            exit();
        }

        if ($data->action === 'forgotpassword') {
            if (!empty($data->email) && !empty($data->password)) {
                $response = $userService->passwordReset($data->email, $data->password);
                $response->send();
            } else {
                Response::sendResponse(false, "Incomplete data", "Email and password are required for login.");
            }
        }
    }
}
