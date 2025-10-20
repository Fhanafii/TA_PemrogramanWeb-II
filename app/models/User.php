<?php
// require_once __DIR__ . '/../core/Database.php';
// require_once __DIR__ . '/../core/Model.php';

class User extends Model
{
  private $conn;
  private $table = "users";

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->getConnection();
  }

  // Ambil semua user
  public function getAll()
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table}");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Ambil user berdasarkan ID
  public function getById($id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Cari user berdasarkan NIK
  public function getByNik($nik)
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE nik = :nik");
    $stmt->bindParam(":nik", $nik);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Insert user baru
  public function create($data)
  {
    $sql = "INSERT INTO {$this->table} (nik, name, email, password, qr_token) 
                VALUES (:nik, :name, :email, :password, :qr_token)";
    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(":nik", $data['nik']);
    $stmt->bindParam(":name", $data['name']);
    $stmt->bindParam(":email", $data['email']);
    $stmt->bindParam(":password", $data['password']);
    // $stmt->bindParam(":role", $data['role']);
    $stmt->bindParam(":qr_token", $data['qr_token']);

    return $stmt->execute();
  }

  public function findByEmail($email)
  {
    // $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    // $stmt = $this->conn->prepare("SELECT id, name, email, FROM users WHERE email = :email LIMIT 1");
    $stmt = $this->conn->prepare("SELECT 
    u.id,
    u.name,
    u.email,
    u.nik,
    u.password,
    p.positions
    FROM users u
    JOIN user_employee ue ON ue.id = u.id
    JOIN positions p ON p.id_positions = ue.id_positions
    WHERE u.email  = :email
    LIMIT 1;
      ");
    $stmt->bindParam(":email", $email);
    $stmt->execute(['email' => $email]);
    // return $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    // return $stmt->execute() ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
  }
}
