<?php

class Response
{
    private $status;
    private $message;
    private $description;

    public function __construct($status, $message, $description = '')
    {
        $this->status = $status;
        $this->message = $message;
        $this->description = $description;
    }

    public function getResponse()
    {
        return [
            "status" => $this->status,
            "message" => $this->message,
            "description" => $this->description
        ];
    }

    public function send()
    {
        // Ensure the response is in JSON format
        header('Content-Type: application/json');
        echo json_encode($this->getResponse());
        exit;
    }

    // Static method to quickly send responses
    public static function sendResponse($status, $message, $description = '')
    {
        $response = new self($status, $message, $description);
        $response->send();
    }
}
