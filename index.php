<?php
  require "./models/User.php";
  require "./models/Table.php";
  require "./enums/UserStatus.php";
  require "./enums/TableStatus.php";

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

  // $user->getAllUsers();
  
  // $data = [
  //   "firstName" => "Renata",
  //   "lastName" => "Almeida",
  //   "password" => "11111111",
  //   "phone" => "5789420002",
  //   "email" => "renata@gmail.com",
  //   "roleId" => 2
  // ];

  // $user->createUser(
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
