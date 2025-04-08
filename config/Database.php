<?php
  require "./webConfig.php";

  class Database {

    public function connect() {
      try {
        $conn = new mysqli(DB_SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
      } catch(Exception $e) {
        die("Caught exception: " . $e->getMessage());
      } 
    }
  }
?>