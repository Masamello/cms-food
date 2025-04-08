<?php
  require "./models/User.php";
  require "./models/Table.php";
  require "./models/Reservation.php";
  require "./models/Roles.php";
  require "./enums/UserStatus.php";
  require "./enums/TableStatus.php";
  require "./enums/ReservationStatus.php";

  $role = new Roles();

  // session_start();

  // echo $_SESSION['userFullName'];

  // $reservation = new Reservation;

  // $reservation->getAllReservations();

  // $data = [
  //   "customerId" => 12,
  //   "tableId" => 1,
  //   "startTime" => "2025-04-07 08:00:00",
  //   "endTime" => "2025-04-07 09:00:00",
  //   "partySize" => 6,
  //   "specialRequests" => "No spicy food and only vegetables.",
  //   "status" => ReservationStatus::Confirmed->value
  // ];

  // $reservation->addReservation(
  //   $data['customerId'],
  //   $data['tableId'],
  //   $data['startTime'],
  //   $data['endTime'],
  //   $data['partySize'],
  //   $data['status'],
  //   $data['specialRequests'],
  // );

  // $reservation->updateReservation(
  //   $data['customerId'],
  //   $data['tableId'],
  //   $data['startTime'],
  //   $data['endTime'],
  //   $data['partySize'],
  //   $data['status'],
  //   $data['specialRequests'],
  //   7
  // );

  // $reservation->updateReservationStatus(ReservationStatus::Cancelled->value, 7);

  // $table = new Table;
  
  // $table->getAllTables();

  // $data = [
  //   "tableNumber" => "C5",
  //   "capacity" => 8,
  //   "location" => "Deck",
  //   "status" => TableStatus::OutOfService->value,
  // ];

  // $table->addTable(
  //   $data['tableNumber'], 
  //   $data['capacity'], 
  //   $data['location'], 
  //   $data['status']
  // );

  // $table->updateTable(
  //   $data['tableNumber'], 
  //   $data['capacity'], 
  //   $data['location'], 
  //   $data['status'],
  //   5
  // );

  // $table->deleteTable(2);

  // $user = new User();
  // $user->login("anderson@gmail.com", "12345");

  // $user->getAllUsers();
  
  // $data = [
  //   "firstName" => "Anderson",
  //   "lastName" => "Santos",
  //   "password" => "12345",
  //   "phone" => "4373857225",
  //   "email" => "anderson@gmail.com",
  //   "roleId" => 1
  // ];

  // $user->addUser(
  //   $data["firstName"], 
  //   $data['lastName'], 
  //   $data["password"], 
  //   $data["phone"], 
  //   $data["email"], 
  //   $data["roleId"],
  // );

  // $user->updateUser(
  //   $data["firstName"], 
  //   $data['lastName'], 
  //   $data["password"], 
  //   $data["phone"], 
  //   $data["email"], 
  //   $data["roleId"],
  //   13
  // );

  // $user->setUserStatus(UserStatus::Disabled->value, 17);
?>
