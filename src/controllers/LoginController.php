<?php 
  namespace App\Controllers;

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use App\Models\User;

  class LoginController {
    private $user;

    public function __construct() {
      $this->user = new User();
    }

    public function login(Request $request, Response $response, array $args): Response {
      $body = $request->getBody();
      $data = json_decode($body, true);

      $login = $this->user->login($data['email'], $data['password']);

      $payload = json_encode($login);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($login['status']);
    }

    public function logout(Request $request, Response $response, array $args): Response {
      session_unset();
      session_destroy();
      $payload = json_encode(["message" => "User session ended."]);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus(302);
    }
  }

?>