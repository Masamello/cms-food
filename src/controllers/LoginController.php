<?php 
  namespace App\Controllers;

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use App\Controllers\Controller;
  use App\Models\User;

  class LoginController extends Controller {
    private $user;

    public function __construct() {
      $this->user = new User();
    }

    public function login(Request $request): Response {
      $body = $request->getBody();
      $data = json_decode($body, true);

      $login = $this->user->login($data['email'], $data['password']);
      return $this->jsonResponse($login);
    }

    public function logout(): Response {
      session_unset();
      session_destroy();
      return $this->jsonResponse(["message" => "User session ended.", "status" => 302]);
    }
  }

?>