<?php
require_once "Database.php";

class Reservation
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function addReservation()
  {
    $sql = "INSERT INTO reservation_tb (CustomerID, TableId, Date, PartySize, SpecialRequests, Status) 
              VALUES (12,1,'2024-04-03 06:00:00', 5, 'Vegan food','Confirmed')";

    if ($this->db->conn->query($sql) === TRUE) {
      echo "New reservation created successfully!";
    } else {
      echo "Error: " . $sql . "<br>" . $this->db->conn->error;
    }
    $this->db->conn->close();
  }

  public function updateReservation()
  {
    $sql = "UPDATE reservation_tb 
              SET CustomerID=12, 
                  TableId=1, 
                  Date='2024-04-05 07:00:00',
                  PartySize=3,
                  SpecialRequests='Vegan food'
                  Status='Confirmed'
                  WHERE ReservationId=1";

    if ($this->db->conn->query($sql) === TRUE) {
      echo "Reservation updated successfully!";
    } else {
      echo "Error: " . $sql . "<br>" . $this->db->conn->error;
    }
    $this->db->conn->close();
  }

  public function deleteReservation()
  {
    $sql = "DELETE FROM reservation_tb WHERE ReservationId=$id";

    if ($this->db->conn->query($sql) === TRUE) {
      echo "Reservation deleted successfully";
    } else {
      echo "Error deleting reservation" . $this->db->conn->error;
    }
    $this->db->conn->close();
  }
}
