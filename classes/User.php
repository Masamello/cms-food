<?php 
  require_once "Database.php";

  class User {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    public function login() {}

    public function addUser() {
      $password = $this->hashPassword("123456");
      $sql = "INSERT INTO user_tb (FirstName, LastName, Password, Phone, Email, Activate, RoleId) 
              VALUES ('Anderson', 'Costa', '$password', '4373857225', 'anderson@gmail.com', 1, 1)";
      
      if($this->db->conn->query($sql) === TRUE) {
        echo "New user created successfully!";
      } else {
        echo "Error: ". $sql . "<br>" . $this->db->conn->error;
      }
      $this->db->conn->close();
    }

    public function updateUser($id) {
      $password = $this->hashPassword("7891011");
      $sql = "UPDATE user_tb 
              SET FirstName='Kaho', 
                  LastName='Uchiyama', 
                  Password='$password',
                  Phone='4444444',
                  Email='kaho@gmail.com'
                  WHERE UserId=$id";
      
      if($this->db->conn->query($sql) === TRUE) {
        echo "User updated successfully!";
      } else {
        echo "Error: ". $sql . "<br>" . $this->db->conn->error;
      }
      $this->db->conn->close();
    }

    public function deleteUser(int $id) {
      $sql = "DELETE FROM user_tb WHERE UserId=$id";

      if($this->db->conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
      } else {
        echo "Error deleting record" . $this->db->conn->error;
      }
      $this->db->conn->close();
    }

    public function logout() {}

    private function hashPassword(string $password): string {
      $options = [
        'cost' => 12
      ];
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);
      return $hashedPassword;
    }
  }
?>