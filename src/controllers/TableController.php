<?php 
  namespace App\Controllers;

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use App\Models\Table;

  class TableController {
    private $table;

    public function __construct() {
      $this->table = new Table();
    }

    public function showTables(Request $request, Response $response, array $args): Response {
      $tables = $this->table->getAllTables();
      $statusCode = $tables['success'] ? 200 : 500;
      $payload = json_encode($tables);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }

    public function registerTable(Request $request, Response $response, array $args): Response {
      $body = $request->getBody();
      $data = json_decode($body, true);

      $newTable = $this->table->registerTable(
        $data['tableNumber'],
        $data['capacity'],
        $data['location'],
        $data['status'],
      );

      $statusCode = $newTable['success'] ? 200 : 500;
      $payload = json_encode($newTable);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
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

      $statusCode = $updateTable['success'] ? 200 : 500;
      $payload = json_encode($updateTable);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }

    public function updateTableStatus(Request $request, Response $response, array $args): Response {
      $tableId = $args['id'];
      $body = $request->getBody();
      $data = json_decode($body, true);

      $updateStatus = $this->table->updateTableStatus($data['status'], $tableId);

      $statusCode = $updateStatus['success'] ? 200 : 500;
      $payload = json_encode($updateStatus);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    } 

    public function deleteTable(Request $request, Response $response, array $args): Response {
      $tableId = (int) $args['id'];

      $deleteStatus = $this->table->deleteTable(($tableId));

      $statusCode = $deleteStatus['success'] ? 200 : 500;
      $payload = json_encode($deleteStatus);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
  }

?>