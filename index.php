<?php
  session_start();

  use Slim\Factory\AppFactory;
  use Psr\Http\Message\ServerRequestInterface as Request;

  use App\Controllers\LoginController;
  use App\Controllers\UserController;
  use App\Controllers\ReservationController;
  use App\Controllers\TableController;
  
  require __DIR__ . '/vendor/autoload.php';
  
  $app = AppFactory::create();

  // Middleware to protect routes to ensure user is not authenticated.
  $authMiddleware = function (Request $request, $handler) {
    if (!isset($_SESSION['userInfo'])) {
        $response = new \Slim\Psr7\Response();
        $payload = json_encode(["message"=>"Access denied."]);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(302);
    }
    return $handler->handle($request);
};

  // Login Routes
  $app->post('/login', LoginController::class . ':login');
  $app->post('/logout', LoginController::class . ':logout');

  // User Routes
  $app->get('/users', UserController::class . ':showUsers')->add($authMiddleware);
  $app->post('/user/register', UserController::class . ':registerUser');
  $app->put('/user/{id}', UserController::class . ':updateUser')->add($authMiddleware);
  $app->patch('/user/status/{id}', UserController::class . ':updateUserStatus')->add($authMiddleware);

  // Table Routes
  $app->get('/tables', TableController::class . ':showTables')->add($authMiddleware);
  $app->post('/table/register', TableController::class . ':registerTable')->add($authMiddleware);
  $app->put('/table/{id}', TableController::class . ':updateTable')->add($authMiddleware);
  $app->patch('/table/status/{id}', TableController::class . ':updateTableStatus')->add($authMiddleware);
  $app->delete('/table/{id}', TableController::class . ':deleteTable')->add($authMiddleware);

  // Reservation Routes
  $app->get('/reservations', ReservationController::class . ':showReservations')->add($authMiddleware);
  $app->post('/reservation/register', ReservationController::class . ':registerReservation')->add($authMiddleware);
  $app->put('/reservation/{id}', ReservationController::class . ':updateReservation')->add($authMiddleware);
  $app->patch('/reservation/status/{id}', ReservationController::class . ':updateReservationStatus')->add($authMiddleware);
  
  $app->run();
?>