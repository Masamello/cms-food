<?php 
  namespace App\Controllers;

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use App\Controllers\Controller;
  use App\Models\Table;

  class TableController extends Controller {
    private $table;

    public function __construct() {
      $this->table = new Table();
    }

    public function showTables(): Response {
      $tables = $this->table->getAllTables();
      return $this->jsonResponse($tables);
    }

    public function registerTable(Request $request): Response {
      $body = $request->getBody();
      $data = json_decode($body, true);

      $newTable = $this->table->registerTable(
        $data['tableNumber'],
        $data['capacity'],
        $data['location'],
        $data['status'],
      );
      return $this->jsonResponse($newTable);
    }

    public function updateTable(Request $request, Response $response, array $args): Response {
      $tableId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateTable = $this->table->updateTable(
        $data['tableNumber'],
        $data['capacity'],
        $data['location'],
        $data['status'],
        $tableId
      );
      return $this->jsonResponse($updateTable);
    }

    public function updateTableStatus(Request $request, Response $response, array $args): Response {
      $tableId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateStatus = $this->table->updateTableStatus($data['status'], $tableId);
      return $this->jsonResponse($updateStatus);
    } 

    public function deleteTable(Request $request, Response $response, array $args): Response {
      $tableId = (int) $args['id'];

      $deleteStatus = $this->table->deleteTable(($tableId));
      return $this->jsonResponse($deleteStatus);
    }
  }

?>