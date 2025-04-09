<?php 
  enum TableStatus: string {
    case Available = 'Available';
    case Reserved = 'Reserved';
    case OutOfService = 'Out of Service';
  }
?>