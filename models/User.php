<?php 
  require_once "Model.php";
  class User extends Model {

    public function login() {}

    public function getAllUsers() {
      try {
        $sql = "SELECT * FROM user_tb";
        if($result = $this->db->query($sql)) {
          $data = $result->fetch_all(MYSQLI_ASSOC);
          if(count($data) > 0) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
          } else {
            echo "No users found.";
          }
        }
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();
      }
    }

    public function addUser(
      string $firstName, 
      string $lastName, 
      string $password, 
      string $phone, 
      string $email, 
      int $roleId
    ) {
      try {
        $password = $this->hashPassword($password);
        $sql = "INSERT INTO user_tb (FirstName, LastName, Password, Phone, Email, RoleId, Activate) 
                VALUES ('$firstName', '$lastName', '$password', '$phone', '$email', $roleId, 1)";
        if($this->db->query($sql)) {
          echo "New user created successfully!";
        } 
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();
      }
    }

    public function updateUser(
        string $firstName, 
        string $lastName, 
        string $password, 
        string $phone,
        string $email, 
        int $roleId, 
        int $userId,
      ) {
        try {
          $sql = "SELECT Activate FROM user_tb WHERE UserId=$userId";
          if($result = $this->db->query($sql)) {
            $isActivate = $result->fetch_assoc();
            if(isset($isActivate) && $isActivate['Activate']) {
              $password = $this->hashPassword($password);
              $sql = "UPDATE user_tb 
                      SET FirstName='$firstName', 
                          LastName='$lastName', 
                          Password='$password',
                          Phone='$phone',
                          Email='$email',
                          RoleId=$roleId
                      WHERE UserId=$userId";
              if($this->db->query($sql)) {
                echo "User updated successfully!";
              } 
            } else {
              echo "User is not activate.";
            }
          } 
        } catch(Exception $e) {
          echo "Error: " . $e->getMessage();
        } finally {
          $this->db->close();
        }
    }

    public function setUserStatus(int $status, int $id) {
      try {
        $sql = "UPDATE user_tb
        SET Activate=$status
        WHERE UserId=$id";

        if($this->db->query($sql)) {
          echo "User status changed successfully";
        } else {
          echo "Error changing user status" . $this->db->error;
        }
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();
      }
    }

    private function hashPassword(string $password): string {
      $options = [
        'cost' => 12
      ];
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);
      return $hashedPassword;
    }
 }
?>