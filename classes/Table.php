<?php
  require_once "Database.php";

  class Table {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    public function addTable() {
      $sql = "INSERT INTO table_tb (TableNumber,Capacity,Location,Status) 
              VALUES ('A1',6,'Main_Hall','Available')";
      
      if($this->db->conn->query($sql) === TRUE) {
        echo "New table created successfully!";
      } else {
        echo "Error: ". $sql . "<br>" . $this->db->conn->error;
      }
      $this->db->conn->close();
    }

    public function updateTable() {
      $sql = "UPDATE table_tb 
      SET TableNumber='A2', 
          Capacity=4, 
          Location='Sub_Hall',
          Status='Reserved'
          WHERE TableId = 1";

      if($this->db->conn->query($sql) === TRUE) {
      echo "Table updated successfully!";
      } else {
      echo "Error: ". $sql . "<br>" . $this->db->conn->error;
      }
      $this->db->conn->close();
    }

    public function deleteTable(int $id) {
      $sql = "DELETE FROM table_tb WHERE TableId=$id";

      if($this->db->conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
      } else {
        echo "Error deleting record" . $this->db->conn->error;
      }
      $this->db->conn->close();
    }
  }
?>