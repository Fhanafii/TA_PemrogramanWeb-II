<?php
// app/Models/UserModel.php
// require_once __DIR__ . '/../../db/Database.php';

class UserModel
{
  private $db;
  public function __construct()
  {
    $database = new Database();
    $this->db = $database->getConnection();
  }

  public function findByNik($nik)
  {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE nik = :nik LIMIT 1");
    $stmt->execute([':nik' => $nik]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function find($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
