<?php 

// MySQL class

class mySql {
    private $hostname;
    private $username;
    private $password;
    private $database;

    protected function connect() {
        $this->servername = "localhost";
        $this->username = "u928739372_abam";
        $this->password = "kazkoksai";
        $this->database = "u928739372_abam";

        $conn = new mysqli($this->servername, $this->username, $this->password,  $this->database);
        return $conn;
    }
}

?>