<?php 
  namespace App\Controllers;

  use Psr\Http\Message\ResponseInterface as Response;

  abstract class Controller {
    protected function jsonResponse($data): Response {
      $response = new \Slim\Psr7\Response();
      $response->getBody()->write(json_encode($data));
      return $response->withHeader('Content-Type', 'application/json')->withStatus($data['status']);
    }
  }
?>