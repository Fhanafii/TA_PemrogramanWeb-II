<?php
// echo __DIR__;
// die;
// require_once __DIR__ . '/../helpers/loadEnv.php';

class Database
{
  private $host = "localhost";
  private $dbname = "presensi";
  private $username = "root";
  private $password = "";
  private $conn;

  public function __construct()
  {
    // Load environment variables
    loadEnv(__DIR__ . '/../../.env');

    // Override default values with environment variables if they exist
    $this->host = getenv('DB_HOST') ?: $this->host;
    $this->dbname = getenv('DB_NAME') ?: $this->dbname;
    $this->username = getenv('DB_USER') ?: $this->username;
    $this->password = getenv('DB_PASS') ?: $this->password;

    // Override default values with environment variables if they exist
    // $this->host = $_ENV['DB_HOST'] ?: $this->host;
    // $this->dbname = $_ENV['DB_NAME'] ?: $this->dbname;
    // $this->username = $_ENV['DB_USER'] ?: $this->username;
    // $this->password = $_ENV['DB_PASS'] ?: $this->password;
  }

  public function getConnection()
  {
    if ($this->conn == null) {
      try {
        $this->conn = new PDO(
          "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
          $this->username,
          $this->password
        );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        die("Database connection error: " . $e->getMessage());
      }
    }
    return $this->conn;
  }
}
