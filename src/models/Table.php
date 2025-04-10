<?php 
  namespace App\Models;

  use App\Models\Model;
  class Table extends Model {

    public function getAllTables() {
      try {
        $sql = "SELECT * FROM table_tb";
        
        if($result = $this->db->query($sql)) {
          $data = $result->fetch_all(MYSQLI_ASSOC);
          if(count($data) > 0) {
            return ["data" => $data, "status" => 200];
          } else {
            return ["data" => "No tables found", "status" => 200];
          }
        }
      } catch(\Exception $e) {
        return ["success" => false, "message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();  
      }
    }

    public function registerTable(
      string $tableNumber,
      int $capacity,
      string $location,
      string $status
    ) {
      try {
        $sql = "INSERT INTO table_tb (TableNumber, Capacity, Location, Status)
                VALUES ('$tableNumber', $capacity, '$location', '$status')";
        
        if($this->db->query($sql)) {
          return ["message" => "New table created successfully!", "status" => 200];
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(),  "status" => 500];
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
          if($this->db->affected_rows > 0) {
            return ["message" => "Table updated successfully!", "status" => 200];
          } else {
            return ["message" => "No table were updated.", "status" => 500];
          }
        } 
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();
      }
    }

    public function updateTableStatus(string $status, int $id) {
      try {
        $sql = "UPDATE table_tb
                SET Status='$status'
                WHERE TableId=$id";

        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            return ["message" => "Table status updated successfully!", "status" => 200];
          } else {
            return ["message" => "No table were updated.", "status" => 200];
          }
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();
      }
    }

    public function deleteTable(int $tableId) {
      try {
        $sql = "DELETE FROM table_tb WHERE TableId=$tableId";
        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            return ["message" => "Table deleted successfully!", "status" => 200];
          } else {
            return ["message" => "No table were deleted.", "status" => 200];
          }
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();
      }
    }
  }   
?>