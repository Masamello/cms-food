<?php 
  require_once "Model.php";
  class Reservation extends Model {
    
    public function getAllReservations() {
      try {
        $sql = "SELECT r.ReservationId, u.FirstName, u.LastName, t.TableNumber, t.Location, r.PartySize, r.SpecialRequests, r.Status
                FROM reservation_tb AS r
                INNER JOIN user_tb AS u
                ON u.UserId = r.CustomerId
                INNER JOIN table_tb AS t
                ON t.TableId = r.TableId";

        if($result = $this->db->query($sql)) {
          $data = $result->fetch_all(MYSQLI_ASSOC);
          if(count($data) > 0) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
          } else {
            echo "No reservations found.";
          }
        }
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();  
      }
    }

    public function addReservation(
      int $customerId,
      int $tableId,
      string $startTime,
      string $endTime,
      int $partySize,
      string $status,
      string $specialRequests = "No requests",
    ) {
      try {
        /**
         * TODO: 
         * 1 - check if there is a reservation with same date/hour and status is not confirmed/pending.
         * 2 - check if the table selected have sufficient seats available.
         *  */ 
        // $isReservationAvailable = $this->checkReservation($startTime, $endTime, $partySize, $tableId);

        $sql = "INSERT INTO reservation_tb (CustomerId, TableId, StartTime, EndTime, PartySize, SpecialRequests, Status)
                VALUES ($customerId, $tableId, '$startTime', '$endTime', $partySize, '$specialRequests', '$status')";        

        if($this->db->query($sql)) {
          echo "New reservation created successfully!";
        } 
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();
      }
    }

    public function updateReservation(
      int $customerId,
      int $tableId,
      string $startTime,
      string $endTime,
      int $partySize,
      string $status,
      string $specialRequests = "No requests",
      int $reservationId
    ) {
      try {
        /**
         * TODO: 
         * 1 - check if there is a reservation with same date/hour and status is not confirmed/pending.
         * 2 - check if the table selected have sufficient seats available.
         *  */ 
        // $reservation = $this->checkReservation($startTime, $endTime, $partySize, $tableId);

        $sql = "UPDATE reservation_tb
                SET CustomerId=$customerId, 
                    TableId=$tableId, 
                    StartTime='$startTime',
                    EndTime='$endTime',
                    PartySize='$partySize',
                    Status='$status',
                    SpecialRequests='$specialRequests'
                WHERE ReservationId=$reservationId";
        if($this->db->query($sql)) {
          echo "Reservation updated successfully!";
        }
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();
      }
    }

    public function updateReservationStatus(string $status, int $reservationId) {
      try {
        $sql = "UPDATE reservation_tb
                SET Status='$status'
                WHERE ReservationId=$reservationId";
         if($this->db->query($sql)) {
          echo "Reservation status updated successfully!";
        }
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $this->db->close();
      }
    }

    private function checkReservation($startTime, $endTime, $partySize, $tableId): bool {
      try {
        $sql = "SELECT date 
                FROM reservation_tb 
                WHERE (startTime < '$startTime' AND endTime > '$endTime') AND TableId=$tableId";
        if($result = $this->db->query($sql)) {
          $data = $result->fetch_all(MYSQLI_ASSOC);
          if(count($data) > 0) {
            echo "Reservation is not available";
            return false;
          } else {
            echo "Reservation is available";
            return true;
          } 
        }
        return true;
      } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
      }
    }
  }

?>