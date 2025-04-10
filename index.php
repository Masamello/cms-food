<?php

ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use App\controllers\UserController;
use App\Models\Roles;

require __DIR__ . '/vendor/autoload.php';
// 
$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write("Hello world!");
  return $response;
});

// User Routes
$app->get('/users', UserController::class . ':showUsers');
$app->post('/user/register', UserController::class . ':registerUser');
$app->put('/user/{id}', UserController::class . ':updateUser');
$app->patch('/user/status/{id}', UserController::class . ':updateUserStatus');

// Table Routes
$role = new Roles();
$role->addRole("test");
$app->run();

// use App\Models\Reservation;
// use App\Models\Roles;

// require "./models/Reservation.php";
// require "./models/Roles.php";
// require "./enums/TableStatus.php";
// require "./enums/ReservationStatus.php";

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
