<?php 
  enum ReservationStatus: string {
    case Pending = 'Pending';
    case Confirmed = 'Confirmed';
    case Cancelled = 'Cancelled';
  }
?>