<?php

require_once '../database/database.php';
require_once '../service/userService.php';
require_once '../service/ScoreService.php';
require_once '../model/Response.php';

$database = new Database();
$db = $database->getConnection();

$userService = new UserService($db);
$scoreService = new ScoreService($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action)) {
        if ($data->action === 'update_score') {
            if (
                isset($data->user) &&
                isset($data->win) &&
                isset($data->fail) &&
                isset($data->skip)
            ) {
                $response = $scoreService->updateScore(
                    $data->user,
                    $data->win,
                    $data->fail,
                    $data->skip
                );
                $response->send();
            } else {
                Response::sendResponse(false, "Invalid data", "All fields are required to update the score.");
            }
        }

        if ($data->action === 'get_score') {
            if (
                isset($data->email)
            ) {
                $response = $scoreService->getScoreProfile($data->email);
                $response->send();
            } else {
                Response::sendResponse(false, "Invalid data", "User ID is required to get the user");
            }
        }
    }
}
