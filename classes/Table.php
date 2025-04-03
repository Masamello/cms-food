<?php
  require_once "Database.php";

  class Table {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    public function addTable() {}

    public function updateTable() {}

    public function deleteTable() {}
  }
?>