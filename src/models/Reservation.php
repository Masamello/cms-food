<?php 
  namespace App\Models;

  use App\Utils\Audit;
  use App\Models\Model;
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
            return ["data" => $data, "status" => 200];
          } else {
            return ["data" => "No reservations found", "status" => 200];
          }
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();  
      }
    }

    public function registerReservation($data) {
      try {
        $sql = "INSERT INTO reservation_tb (CustomerId, TableId, StartTime, EndTime, PartySize, SpecialRequests, Status)
                VALUES ($data[customerId], $data[tableId], '$data[startTime]', '$data[endTime]', $data[partySize], '$data[specialRequests]', '$data[status]')";        

        if($this->db->query($sql)) {
          $recordId = $this->db->insert_id;
          $audit = new Audit();
          $audit->logCreate($recordId, $data, "reservation_tb", "insert");
          return ["message" => "New reservation created successfully!", "status" => 200];
        } 
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();
      }
    }

    public function updateReservation($data, int $reservationId) {
      try {
        $sql = "UPDATE reservation_tb
                SET CustomerId=$data[customerId], 
                    TableId=$data[tableId], 
                    StartTime='$data[startTime]',
                    EndTime='$data[endTime]',
                    PartySize='$data[partySize]',
                    Status='$data[status]',
                    SpecialRequests='$data[specialRequests]'
                WHERE ReservationId=$reservationId";
        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            $audit = new Audit();
            $audit->logCreate($reservationId, $data, "reservation_tb", "update");
            return ["message" => "Reservation updated successfully!", "status" => 200];
          } else {
            return ["message" => "No reservation were updated.", "status" => 200];
          }
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();
      }
    }

    public function updateReservationStatus($data, int $reservationId) {
      try {
        $sql = "UPDATE reservation_tb
                SET Status='$data[status]'
                WHERE ReservationId=$reservationId";
        
        if($this->db->query($sql)) {
          if($this->db->affected_rows > 0) {
            $audit = new Audit();
            $audit->logCreate($reservationId, $data, "reservation_tb", "update");
            return ["message" => "Reservation status updated successfully!", "status" => 200];
          } else {
            return ["message" => "No reservation status were updated.", "status" => 200];
          }
        }
      } catch(\Exception $e) {
        return ["message" => $e->getMessage(), "status" => 500];
      } finally {
        $this->db->close();
      }
    }
  }
?>