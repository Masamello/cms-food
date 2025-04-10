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
            return ["success" => true, "message" => "User authenticated.", "status" => 200];
          } else {
            throw new Exception("Login failed.", 405);
          }
        } else {
          throw new Exception("Login failed.", 405);
        }
      } catch(\Exception $e) {
        return [
          "success" => false,
          "message" => $e->getMessage(),
          "status" => $e->getCode()
        ];
      } finally {
        $this->db->close();
      }
    }

    public function getAllUsers() {
      try {
        $sql = "SELECT u.userId, u.FirstName, u.LastName, u.Phone, u.Email, u.Activate, r.name AS Role
                FROM user_tb AS u 
                INNER JOIN roles_tb AS r
                WHERE r.RoleId = u.RoleId";
        if($result = $this->db->query($sql)) {
          $data = $result->fetch_all(MYSQLI_ASSOC);
          if(count($data) > 0) {
            return ["success" => true, "data" => $data];
          } else {
            return ["success" => true, "data" => "No users found"];
          }
        }
      } catch(\Exception $e) {
        return [
          "success" => false, 
          "message" => $e->getMessage()
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
          return [
            "success" => true,
            "message" => "New user created successfully!"
          ];
        }
      } catch(\Exception $e) {
        return [
          "success" => false, 
          "message" => $e->getMessage()
        ];
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
              return [
                "success" => true,
                "message" => "User updated successfully!"
              ];
            } else {
              return [
                "success" => false,
                "message" => "No user were updated."
              ];
            }
          } 
        } catch(\Exception $e) {
          return [
            "success" => false, 
            "message" => $e->getMessage()
          ];
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
            return [
              "success" => true,
              "message" => "User status updated successfully!"
            ];
          } else {
            return [
              "success" => false,
              "message" => "No status user were updated."
            ];
          }
        }
      } catch(\Exception $e) {
        return [
          "success" => false, 
          "message" => $e->getMessage()
        ];
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