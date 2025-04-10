<?php 
  namespace App\Models;

  use App\Models\Model;
  use Exception;

  class User extends Model {

    public function login(string $email, string $password) {
      try {
        $sql = "SELECT UserId, CONCAT_WS(' ', FirstName, LastName) AS FullName, Password
                FROM user_tb
                WHERE Email='$email' AND Activate = 1";
        if($result = $this->db->query($sql)) {
          $data = $result->fetch_assoc();
          if($data && password_verify($password, $data['Password'])) {
            if(session_status() === PHP_SESSION_NONE) {
              session_start();
            }
            $_SESSION['userInfo'] = $data;
            return ["message" => "User authenticated.", "status" => 200];
          } else {
            throw new Exception("Login failed.", 405);
          }
        } else {
          throw new Exception("Login failed.", 405);
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => $e->getCode()];
      } finally {
        $this->db->close();
      }
    }

    public function getAllUsers() {
      try {
        $sql = "SELECT u.userId, u.FirstName, u.LastName, u.Phone, u.Email, u.Activate, r.RoleName
                FROM user_tb AS u 
                INNER JOIN roles_tb AS r
                WHERE r.RoleId = u.RoleId";
        if($result = $this->db->query($sql)) {
          $data = $result->fetch_all(MYSQLI_ASSOC);
          if(count($data) > 0) {
            return ["data" => $data, "status" => 200];
          } else {
            return ["data" => "No users found", "status" => 200];
          }
        }
      } catch(\Exception $e) {
        return [
          
          "message" => $e->getMessage(),
          "status" => 500
        ];
      } finally {
        $this->db->close();
      }
    }

    public function registerUser(
      string $firstName,
      string $lastName,
      string $password, 
      string $phone,
      string $email, 
      int $roleId
    ) {
      try {
        $password = $this->createHashPassword($password);
        $sql = "INSERT INTO user_tb (FirstName, LastName, Password, Phone, Email, RoleId, Activate) 
                VALUES ('$firstName', '$lastName', '$password', '$phone', '$email', $roleId, 1)";
        if($this->db->query($sql)) {
          return ["message" => "New user created successfully!", "status" => 200];
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => 500];
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
          $password = $this->createHashPassword($password);
          $sql = "UPDATE user_tb 
                  SET FirstName='$firstName', 
                      LastName='$lastName', 
                      Password='$password',
                      Phone='$phone',
                      Email='$email',
                      RoleId=$roleId
                  WHERE UserId=$userId";
          if($this->db->query($sql)) {
            if($this->db->affected_rows > 0) {
              return ["message" => "User updated successfully!", "status" => 200];
            } else {
              return ["message" => "No user were updated.", "status" => 200];
            }
          } 
        } catch(\Exception $e) {
          return ["message" => $e->getMessage(), "status" => 500];
        } finally {
          $this->db->close();
        }
    }

    public function updateUserStatus(int $status, int $id) {
      try {
        $sql = "UPDATE user_tb
                SET Activate=$status
                WHERE UserId=$id";
        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            return ["message" => "User status updated successfully!", "status" => 200];
          } else {
            return ["message" => "No status user were updated.", "status" => 200];
          }
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();
      }
    }

    private function createHashPassword(string $password): string {
      $options = [
        'cost' => 12
      ];
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);
      return $hashedPassword;
    }
 }
?>