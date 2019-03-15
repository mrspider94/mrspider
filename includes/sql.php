<?php 

// MySQL class

class mySql {
    private $hostname;
    private $username;
    private $password;
    private $database;

    protected function connect() {
        $this->servername = "";
        $this->username = "";
        $this->password = "";
        $this->database = "";

        $conn = new mysqli($this->servername, $this->username, $this->password,  $this->database);
        return $conn;
    }
}

?>