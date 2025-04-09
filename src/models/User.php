<?php 
  namespace App\Models;

  use App\Models\Model;

  class User extends Model {

    public function login($email, $password) {
      try {
        $sql = "SELECT UserId, CONCAT_WS(' ', FirstName, LastName) AS FullName, Password
                FROM user_tb
                WHERE Email='$email'";
        if($result = $this->db->query($sql)) {
          $data = $result->fetch_assoc();
          if(count($data) > 0 && password_verify($password, $data['Password'])) {
            if(session_status() === PHP_SESSION_NONE) {
              session_start();
            }
            $_SESSION['userId'] = $data['UserId'];
            $_SESSION['userFullName'] = $data['FullName'];
            $_SESSION['logged'] = true;
          } else {
            echo "Provided email or login wrong.";
          }
        }
      } catch(\Exception $e) {
        echo "Error: " . $e->getMessage();
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
          "error" => $e->getMessage(),
          "message" => "Something went wrong while fetching your data. Please try again shortly."
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
          "error" => $e->getMessage(),
          "message" => "Something went wrong while registering new user. Please try again shortly."
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
                "message" => "User not found!"
              ];
            }
          } 
        } catch(\Exception $e) {
          return [
            "success" => false, 
            "error" => $e->getMessage(),
            "message" => "Something went wrong while updating user. Please try again shortly."
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
              "message" => "User not found or status is the same as requested!"
            ];
          }
        }
      } catch(\Exception $e) {
        return [
          "success" => false, 
          "error" => $e->getMessage(),
          "message" => "Something went wrong while updating status user. Please try again shortly."
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