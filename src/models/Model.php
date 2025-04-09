<?php 
  namespace App\Models;

  use App\Config\Database;
  
  class Model {
    public Object $db;

    public function __construct() {
      $this->db = (new Database)->connect();
    }
  }
?>