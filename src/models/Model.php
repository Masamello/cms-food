<?php 
  namespace App\Models;

  use App\Config\Database;

  // require_once "./config/Database.php";
  
  class Model {
    public Object $db;

    public function __construct() {
      $this->db = (new Database)->connect();
    }
  }
?>