<?php 
  require_once "Database.php";

  class Reservation {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    public function addReservation() {}

    public function updateReservation() {}

    public function deleteReservation() {}
  }
?>

