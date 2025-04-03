<?php
  class Database {
    private $dbname = "cms_db";
    private $servername = "localhost";
    private $username = "root";
    private $password = "mysql";
    public $conn;

    public function __construct() {
      try {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if($this->conn->connect_error) {
          die("Connection failied: " . $this->conn->connect_error);
        }
      } catch(Exception $e) {
        die("Caught exception: " . $e->getMessage());
      } 
    }
  }
?>