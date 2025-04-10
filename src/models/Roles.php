<?php

namespace App\Models;

use App\Models\Model;
use App\Config\Database;

class Roles extends Model
{

  /**
   * Function to create a new role
   */

  public function addRole($roleName)
  {
    try {
      $sql = "INSERT INTO roles_tb (name)
                VALUES ('$roleName')";
      if ($this->db->query($sql)) {
        return [
          "success" => true,
          "message" => "New role created successfully!"
        ];
      }
    } catch (\Exception $e) {
      return [
        "success" => false,
        "message" => $e->getMessage()
      ];
    } finally {
      $this->db->close();
    }
  }

  /**
   * Function to update a role, it's just necessary to update the name of the rule.
   */
  public function updateRole($roleId, $roleName)
  {
    $array = ["success" => true, "message" => "the role were updated"];
    echo $array["success"];
    try {
    } catch (\Exception $e) {
    }
  }
}
