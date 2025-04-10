<?php 
  namespace App\Models;

  use App\Models\Model;
  
  class Role extends Model {

    public function getAllRoles() {
      try {
        $sql = "SELECT * FROM roles_tb";
        
        if($result = $this->db->query($sql)) {
          $data = $result->fetch_all(MYSQLI_ASSOC);
          if(count($data) > 0) {
            return ["data" => $data, "status" => 200];
          } else {
            return ["data" => "No roles found", "status" => 200];
          }
        }
      } catch(\Exception $e) {
        return ["success" => false, "message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();  
      }
    }

    public function registerRole($roleName) {
     try {
       $sql = "INSERT INTO roles_tb (RoleName)
                 VALUES ('$roleName')";
       if ($this->db->query($sql)) {
        return ["message" => "New role created successfully!", "status" => 200];
       }
     } catch (\Exception $e) {
      return ["message" => $e->getMessage(),  "status" => 500];
     } finally {
       $this->db->close();
     }
   }

   public function updateRole(string $roleName, int $roleId) {
    try {
      $sql = "UPDATE roles_tb
              SET RoleName = '$roleName'
              WHERE RoleId = $roleId";
      if($this->db->query($sql)){
        if($this->db->affected_rows > 0){
          return ["message" => "Role updated successfully!", "status" => 200];
        }else{
          return ["message" => "No role were updated.", "status" => 200];
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