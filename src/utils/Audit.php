<?php 
  namespace App\Utils;

  use App\Config\Database;

  interface AuditInterface {
    public function logCreate($recordId, $data, $tableName, $action);
  }

  class Audit implements AuditInterface {
    private Object $db;

    public function __construct() {
      $this->db = (new Database)->connect();
    }

    public function logCreate($recordId, $data, $tableName, $action) {
      $values = json_encode($data);
      $dateTime = new \DateTime();
      $currentDateTime = $dateTime->format('Y-m-d H:i:s');
      $sql = "INSERT INTO audit_tb (TableName, RecordId, Operation, JsonData, AuditDate)
              VALUES ('$tableName', $recordId, '$action', '$values', '$currentDateTime')";
      $this->db->query($sql);
      $this->db->close();
    }
  }
?>