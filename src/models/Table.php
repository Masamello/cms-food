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
            return ["success" => true, "data" => $data];
          } else {
            return ["success" => true, "data" => "No tables found"];
          }
        }
      } catch(\Exception $e) {
        return [
          "success" => false, 
          "message" => "Something went wrong while fetching your data. Please try again shortly."
        ];
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
          return [
            "success" => true,
            "message" => "New table created successfully!"
          ];
        }
      } catch(\Exception $e) {
        return [
          "success" => false, 
          "message" => "Something went wrong while registering new table. Please try again shortly."
        ];
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
            return [
              "success" => true,
              "message" => "Table updated successfully!"
            ];
          } else {
            return [
              "success" => false,
              "message" => "No table were updated."
            ];
          }
        } 
      } catch(\Exception $e) {
        return [
          "success" => false, 
          "message" => "Something went wrong while updating table. Please try again shortly."
        ];
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
            return [
              "success" => true,
              "message" => "Table status updated successfully!"
            ];
          } else {
            return [
              "success" => false,
              "message" => "No table were updated."
            ];
          }
        }
      } catch(\Exception $e) {
        return [
          "success" => false, 
          "message" => "Something went wrong while updating status table. Please try again shortly."
        ];
      } finally {
        $this->db->close();
      }
    }

    public function deleteTable(int $tableId) {
      try {
        $sql = "DELETE FROM table_tb WHERE TableId=$tableId";
        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            return [
              "success" => true,
              "message" => "Table deleted successfully!"
            ];
          } else {
            return [
              "success" => false,
              "message" => "No table were deleted."
            ];
          }
        }
      } catch(\Exception $e) {
        return [
          "success" => false, 
          "message" => "Something went wrong while deleting table. Please try again shortly."
        ];
      } finally {
        $this->db->close();
      }
    }
  }   
?>