<?php
  require "./webConfig.php";
  class Database {
    public $conn;

    public function __construct() {
      try {
        $this->conn = new mysqli(DB_SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if($this->conn->connect_error) {
          die("Connection failied: " . $this->conn->connect_error);
        }
      } catch(Exception $e) {
        die("Caught exception: " . $e->getMessage());
      } 
    }
  }
?>