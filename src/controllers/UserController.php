<?php
  namespace App\Controllers;

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use App\Models\User;

  class UserController {
    private $user;

    public function __construct() {
      $this->user = new User();
    }

    public function showUsers(Request $request, Response $response, array $args): Response {
      $users = $this->user->getAllUsers();
      $statusCode = $users['success'] ? 200 : 500;
      $payload = json_encode($users);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }

    public function registerUser(Request $request, Response $response, array $args): Response {
      $data = $request->getParsedBody();

      $newUser = $this->user->registerUser(
        $data['firstName'],
        $data['lastName'],
        $data['password'],
        $data['phone'],
        $data['email'],
        $data['roleId'],
      );

      $statusCode = $newUser['success'] ? 200 : 500;
      $payload = json_encode($newUser);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }

    public function updateUser(Request $request, Response $response, array $args): Response {
      $userId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateUser = $this->user->updateUser(
        $data['firstName'],
        $data['lastName'],
        $data['password'],
        $data['phone'],
        $data['email'],
        $data['roleId'],
        $userId
      );

      $statusCode = $updateUser['success'] ? 200 : 500;
      $payload = json_encode($updateUser);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }
    
    public function updateUserStatus(Request $request, Response $response, array $args): Response {
      $userId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateStatus = $this->user->updateUserStatus($data['status'], $userId);

      $statusCode = $updateStatus['success'] ? 200 : 500;
      $payload = json_encode($updateStatus);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    } 
  }
?>