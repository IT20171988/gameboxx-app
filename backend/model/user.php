<?php

class User
{
    private $conn;
    private $table_name = "users";
    public $id;
    public $full_name;
    public $email;
    public $telephone;
    public $password;
    public $timeStamp;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (full_name, email, telephone, password, timeStamp) 
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telephone = htmlspecialchars(strip_tags($this->telephone));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->timeStamp = date('Y-m-d H:i:s');

        $stmt->bind_param("sssss", $this->full_name, $this->email, $this->telephone, $this->password, $this->timeStamp);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login()
    {
        $query = "SELECT id, full_name, email, password FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $id = $full_name = $db_email = $db_password = '';

            $stmt->bind_result($id, $full_name, $db_email, $db_password);
            $stmt->fetch();

            if (password_verify($this->password, $db_password)) {
                return [
                    "status" => true,
                    "message" => "Login successful.",
                    "data" => [
                        "id" => $id,
                        "full_name" => $full_name,
                        "email" => $db_email
                    ]
                ];
            } else {
                return [
                    "status" => false,
                    "message" => "Invalid password."
                ];
            }
        } else {
            return [
                "status" => false,
                "message" => "No user found with this email."
            ];
        }
    }

    public function passwordReset()
    {

        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = "UPDATE " . $this->table_name . " SET password = ? WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $hashedPassword, $this->email);
        return $stmt->execute();
    }
}
