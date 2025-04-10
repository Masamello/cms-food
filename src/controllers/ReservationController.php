<?php 
  namespace App\Controllers;

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use App\Controllers\Controller;
  use App\Models\Reservation;

  class ReservationController extends Controller {
    private $reservation;

    public function __construct() {
      $this->reservation = new Reservation();
    }

    public function showReservations(): Response {
      $reservations = $this->reservation->getAllReservations();
      return $this->jsonResponse($reservations);
    }

    public function getReservationById(Request $request, Response $response, array $args): Response {
      $reservationId = $args['id'];
      $reservation = $this->reservation->getReservationById($reservationId);
      return $this->jsonResponse($reservation);
    }

    public function registerReservation(Request $request): Response {
      $body = $request->getBody();
      $data = json_decode($body, true);

      $reservation = $this->reservation->registerReservation($data);
      return $this->jsonResponse($reservation);
    }

    public function updateReservation(Request $request, Response $response, array $args): Response {
      $reservationId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateReservation = $this->reservation->updateReservation($data, $reservationId);
      return $this->jsonResponse($updateReservation);
    }

    public function updateReservationStatus(Request $request, Response $response, array $args): Response {
      $reservationId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateStatus = $this->reservation->updateReservationStatus($data, $reservationId);
      return $this->jsonResponse($updateStatus);
    }
  }

?>