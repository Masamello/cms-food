<?php
  namespace App\Controllers;

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use App\Controllers\Controller;
  use App\Models\User;

  class UserController extends Controller {
    private $user;

    public function __construct() {
      $this->user = new User();
    }

    public function showUsers(): Response {
      $users = $this->user->getAllUsers();
      return $this->jsonResponse($users);
    }

    public function registerUser(Request $request): Response {
      $data = $request->getParsedBody();
      $newUser = $this->user->registerUser($data);
      return $this->jsonResponse($newUser);
    }

    public function updateUser(Request $request, Response $response, array $args): Response {
      $userId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateUser = $this->user->updateUser($data, $userId);
      return $this->jsonResponse($updateUser);
    }
    
    public function updateUserStatus(Request $request, Response $response, array $args): Response {
      $userId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateStatus = $this->user->updateUserStatus($data, $userId);
      return $this->jsonResponse($updateStatus);
    } 
  }
?>