<?php

  use App\Controllers\ReservationController;
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;

  use App\Controllers\UserController;
  use App\Controllers\TableController;
  
  require __DIR__ . '/vendor/autoload.php';
  
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
  $app->get('/tables', TableController::class . ':showTables');
  $app->post('/table/register', TableController::class . ':registerTable');
  $app->put('/table/{id}', TableController::class . ':updateTable');
  $app->patch('/table/status/{id}', TableController::class . ':updateTableStatus');
  $app->delete('/table/{id}', TableController::class . ':deleteTable');

  // Reservation Routes
  $app->get('/reservations', ReservationController::class . ':showReservations');
  $app->post('/reservation/register', ReservationController::class . ':registerReservation');
  $app->put('/reservation/{id}', ReservationController::class . ':updateReservation');
  $app->patch('/reservation/status/{id}', ReservationController::class . ':updateReservationStatus');
  
  $app->run();
?>