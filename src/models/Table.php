<?php 
  namespace App\Models;

  use App\Utils\Audit;
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

    public function registerTable($data) {
      try {
        $sql = "INSERT INTO table_tb (TableNumber, Capacity, Location, Status)
                VALUES ('$data[tableNumber]', $data[capacity], '$data[location]', '$data[status]')";
        
        if($this->db->query($sql)) {
          $recordId = $this->db->insert_id;
          $audit = new Audit();
          $audit->logCreate($recordId, $data, "table_tb", "insert");
          return ["message" => "New table created successfully!", "status" => 200];
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(),  "status" => 500];
      } finally {
        $this->db->close();
      }
    }

    public function getTableById(int $tableId) {
      try {
        $sql = "SELECT TableNumber, Capacity, Location, Status 
                FROM table_tb
                WHERE TableId=$tableId";
        
        if($result = $this->db->query($sql)) {
          $data = $result->fetch_all(MYSQLI_ASSOC);
          if(count($data) > 0) {
            return ["data" => $data, "status" => 200];
          } else {
            return ["data" => "No table found", "status" => 200];
          }
        }
      } catch(\Exception $e) {
        return ["success" => false, "message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();  
      }
    }

    public function updateTable($data, int $tableId) {
      try {
        $sql = "UPDATE table_tb
                SET TableNumber='$data[tableNumber]', 
                  Capacity='$data[capacity]', 
                  Location='$data[location]',
                  Status='$data[status]'
                WHERE TableId=$tableId";
        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            $audit = new Audit();
            $audit->logCreate($tableId, $data, "table_tb", "update");
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

    public function updateTableStatus($data, int $id) {
      try {
        $sql = "UPDATE table_tb
                SET Status='$data[status]'
                WHERE TableId=$id";

        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            $audit = new Audit();
            $audit->logCreate($id, $data, "table_tb", "update");
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

    public function deleteTable(int $id) {
      try {
        $sql = "DELETE FROM table_tb WHERE TableId=$id";
        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            $audit = new Audit();
            $audit->logCreate($id, null, "table_tb", "delete");
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