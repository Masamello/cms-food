<?php 
  namespace App\Controllers;

  use App\Models\User;

  // require_once "./models/User.php";

  class LoginController {
    private $user;

    public function __construct() {
      $this->user = new User();
    }

    public function login() {
      if($_POST['email'] && $_POST['password']) {
        $this->user->login($_POST['email'], $_POST['password']);
      }
    }

    public function logout() {
      session_destroy();
    }
  }

?>