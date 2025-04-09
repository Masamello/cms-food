<?php 
  namespace App\Controllers;

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use App\Models\Reservation;

  class ReservationController {
    private $reservation;

    public function __construct() {
      $this->reservation = new Reservation();
    }

    public function showReservations(Request $request, Response $response, array $args): Response {
      $reservations = $this->reservation->getAllReservations();
      $statusCode = $reservations['success'] ? 200 : 500;
      $payload = json_encode($reservations);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }

    public function registerReservation(Request $request, Response $response, array $args): Response {
      $body = $request->getBody();
      $data = json_decode($body, true);

      $reservation = $this->reservation->registerReservation(
        $data['customerId'],
        $data['tableId'],
        $data['startTime'],
        $data['endTime'],
        $data['partySize'],
        $data['status'],
        $data['specialRequests'],
      );

      $statusCode = $reservation['success'] ? 200 : 500;
      $payload = json_encode($reservation);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }

    public function updateReservation(Request $request, Response $response, array $args): Response {
      $reservationId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateReservation = $this->reservation->updateReservation(
        $data['customerId'],
        $data['tableId'],
        $data['startTime'],
        $data['endTime'],
        $data['partySize'],
        $data['status'],
        $data['specialRequests'],
        $reservationId
      );

      $statusCode = $updateReservation['success'] ? 200 : 500;
      $payload = json_encode($updateReservation);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }

    public function updateReservationStatus(Request $request, Response $response, array $args): Response {
      $reservationId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateStatus = $this->reservation->updateReservationStatus($data['status'], $reservationId);

      $statusCode = $updateStatus['success'] ? 200 : 500;
      $payload = json_encode($updateStatus);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }
  }

?>