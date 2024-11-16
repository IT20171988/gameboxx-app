<?php

class WinningData
{
    private $conn;
    private $table_name = "winning_data";

    public $id;
    public $user;
    public $win;
    public $fail;
    public $skip;
    public $last_play;
    public $timestamp;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (user, win, fail, skip, last_play) 
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('siiis', $this->user, $this->win, $this->fail, $this->skip, $this->last_play);

        if ($stmt->execute()) {
            $this->id = $this->conn->insert_id;
            return true;
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET win = ?, fail = ?, skip = ?, last_play = ? 
                  WHERE user = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('iiiss', $this->win, $this->fail, $this->skip, $this->last_play, $this->user);

        if ($stmt->execute()) {
            $retrieveQuery = "SELECT win, fail, skip, last_play FROM " . $this->table_name . " WHERE user = ?";
            $retrieveStmt = $this->conn->prepare($retrieveQuery);
            $retrieveStmt->bind_param('s', $this->user);
            $retrieveStmt->execute();
            $result = $retrieveStmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            return false;
        } else {
            return false;
        }
    }

    public function getScoreProfile()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $this->user);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($this->id, $this->user, $this->win, $this->fail, $this->skip, $this->last_play, $this->timestamp);
            $stmt->fetch();

            return [
                'id' => $this->id,
                'user' => $this->user,
                'win' => $this->win,
                'fail' => $this->fail,
                'skip' => $this->skip,
                'last_play' => $this->last_play,
                'timestamp' => $this->timestamp
            ];
        } else {
            return null;
        }
    }
}
