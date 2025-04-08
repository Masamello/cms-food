<?php 
  require_once "Model.php";
  class Table extends Model {

    public function getAllTables() {
      try {
        $sql = "SELECT * FROM table_tb";
        if($result = $this->db->query($sql)) {
          $data = $result->fetch_all(MYSQLI_ASSOC);
          if(count($data) > 0) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
          } else {
            echo "No tables found.";
          }
        }
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();  
      }
    }

    public function addTable(
      string $tableNumber,
      int $capacity,
      string $location,
      string $status
    ) {
      try {
        $sql = "INSERT INTO table_tb (TableNumber, Capacity, Location, Status)
                VALUES ('$tableNumber', $capacity, '$location', '$status')";
        
        if($this->db->query($sql)) {
          echo "New table created successfully!";
        } 
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();
      }
    }

    public function updateTable(
      string $tableNumber,
      int $capacity,
      string $location,
      string $status,
      int $tableId
    ) {
      try {
        $sql = "UPDATE table_tb
                SET TableNumber='$tableNumber', 
                  Capacity='$capacity', 
                  Location='$location',
                  Status='$status'
                WHERE TableId=$tableId";
        if($this->db->query($sql)) {
          echo "Table updated successfully!";
        }
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();
      }
    }

    public function deleteTable(int $tableId) {
      try {
        $sql = "DELETE FROM table_tb WHERE TableId=$tableId";
        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            echo "Table deleted successfully!";
          } else {
            echo "No table found to be deleted.";
          }
        }
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();
      }
    }
  }   
?>