 <?php 
  require_once "./config/Database.php";
  
  class Model {
    public Object $db;

    public function __construct() {
      $this->db = (new Database)->connect();
    }
  }
?>