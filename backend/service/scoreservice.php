<?php

require_once '../model/WinningData.php';
require_once '../model/Response.php';

class ScoreService
{
    private $winningData;

    public function __construct($db)
    {
        $this->winningData = new WinningData($db);
    }

    public function updateScore($user, $win, $fail, $skip)
    {
        $this->winningData->user = $user;
        $this->winningData->win = $win;
        $this->winningData->fail = $fail;
        $this->winningData->skip = $skip;
        $this->winningData->last_play = (new DateTime())->format('Y-m-d H:i:s');

        $updatedData = $this->winningData->update();

        if ($updatedData) {
            return new Response(true, "Score updated successfully.", $updatedData);
        } else {
            return new Response(false, "Failed to update score.", null);
        }
    }

    public function getScoreProfile($email)
    {
        $this->winningData->user = $email;
        $userData = $this->winningData->getScoreProfile();
        if ($userData) {
            return new Response(true, "User data retrieved successfully.", $userData);
        } else {
            return new Response(false, "Failed to retrieve user data.", null);
        }
    }
}
