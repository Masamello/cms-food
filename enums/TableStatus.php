<?php 
  enum TableStatus: string {
    case Available = 'Available';
    case Reserved = 'Reserved';
    case Occupied = 'Occupied';
    case OutOfService = 'Out of Service';
  }
?>