<?php 
  namespace App\Controllers;

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use App\Controllers\Controller;
  use App\Models\Role;

  class RoleController extends Controller {
    private $role;

    public function __construct() {
      $this->role = new Role();
    }

    public function showRoles(): Response {
      $roles = $this->role->getAllRoles();
      return $this->jsonResponse($roles);
    }

    public function getRoleById(Request $request, Response $response, array $args): Response {
      $roleId = $args['id'];
      $role = $this->role->getRoleById($roleId);
      return $this->jsonResponse($role);
    }

    public function registerRole(Request $request): Response {
      $body = $request->getBody();
      $data = json_decode($body, true);

      $newRole = $this->role->registerRole($data['roleName']);
      return $this->jsonResponse($newRole);
    }

    public function updateRole(Request $request, Response $response, array $args): Response {
      $roleId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateRole = $this->role->updateRole(
        $data['roleName'],
        $roleId
      );
      return $this->jsonResponse($updateRole);
    }
  }
?>