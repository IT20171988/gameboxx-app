<?php

require_once '../model/user.php';
require_once '../model/WinningData.php';
require_once '../model/Response.php';

class UserService {
    private $conn;
    private $user;
    private $winning;

    public function __construct($db) {
        $this->conn = $db;
        $this->user = new User($db);
        $this->winning = new WinningData($db);
    }

    public function loginUser($email, $password) {
        $this->user->email = $email;
        $this->user->password = $password;
        $result = $this->user->login();

        if ($result['status']) {
            return new Response(true, $result['message'], $result['data']);
        } else {
            return new Response(false, $result['message'], null);
        }
    }

    public function createUser($full_name, $email, $telephone, $password) {
        // Set properties for User model
        $this->user->full_name = $full_name;
        $this->user->email = $email;
        $this->user->telephone = $telephone;
        $this->user->password = $password;

        if ($this->user->create()) {
            $this->winning->user = $email;  
            $this->winning->win = 0;
            $this->winning->fail = 0;
            $this->winning->skip = 0;
            $this->winning->last_play = null; 

            if ($this->winning->create()) {
                return new Response(true, "User created successfully", "User and initial winning data added.");
            } else {
                return new Response(false, "Winning data creation failed", "User was created, but the winning data record was not initialized.");
            }
        } else {
            return new Response(false, "User creation failed", "Unable to create user in the database.");
        }
    }

    public function passwordReset( $email, $password) {
        $this->user->email = $email;
        $this->user->password = $password;
        if ($this->user->passwordReset()) {
            return new Response(true, "User created successfully", "User and initial winning data added.");

        } else {
            return new Response(false, "User creation failed", "Unable to create user in the database.");
        }
    }
}
