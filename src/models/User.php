<?php 
  namespace App\Models;

  use App\Utils\Audit;
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

    public function registerUser($data) {
      try {
        $data['password'] = $this->createHashPassword($data['password']);
        $sql = "INSERT INTO user_tb (FirstName, LastName, Password, Phone, Email, RoleId, Activate) 
                VALUES ('$data[firstName]', '$data[lastName]', '$data[password]', '$data[phone]', '$data[email]', $data[roleId], 1)";
        if($this->db->query($sql)) {
          $recordId = $this->db->insert_id;
          $audit = new Audit();
          $audit->logCreate($recordId, $data, "user_tb", "insert");
          return ["message" => "New user created successfully!", "status" => 200];
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();
      }
    }

    public function updateUser($data, int $userId) {
        try {
          $data['password'] = $this->createHashPassword($data['password']);
          $sql = "UPDATE user_tb 
                  SET FirstName='$data[firstName]', 
                      LastName='$data[lastName]', 
                      Password='$data[password]',
                      Phone='$data[phone]',
                      Email='$data[email]',
                      RoleId=$data[roleId]
                  WHERE UserId=$userId";
          if($this->db->query($sql)) {
            if($this->db->affected_rows > 0) {
              $audit = new Audit();
              $audit->logCreate($userId, $data, "user_tb", "update");
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

    public function updateUserStatus($data, int $id) {
      try {
        $sql = "UPDATE user_tb
                SET Activate=$data[status]
                WHERE UserId=$id";
        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            $audit = new Audit();
              $audit->logCreate($id, $data, "user_tb", "update");
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