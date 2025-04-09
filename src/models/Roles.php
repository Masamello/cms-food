<?php 
  use App\Models\Model;

  class Roles extends Model {

    /**
     * Function to create a new role
     */
    public function addRole($roleName) {
      try {
        
      } catch(\Exception $e) {

      }
    }

    /**
     * Function to update a role, it's just necessary to update the name of the rule.
     */
    public function updateRole(
      int $roleId,
      string $roleName
      ) {
      try {
        $sql = "UPDATE roles_tb
                SET name = '$roleName',
                WHERE RoleId = $roleId";
        if($this->db->query($sql)){
          if($this->db->affected_rows > 0){
            return[
              "success" => true,
              "message" => "Role updated successfully!"
            ];
          }else{
            return [
              "success" => false,
              "message" => "No Role were updated."
            ];
          }
        }        
      } catch(\Exception $e) {
        return [
          "success" => false,
          "message" => "Something went wrong while updating roles. Please try again shortly."
        ];
      } finally {
        $this->db->close();
      }
    }
  }
?>