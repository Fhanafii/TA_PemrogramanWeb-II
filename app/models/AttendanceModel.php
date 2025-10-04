<?php
// app/Models/AttendanceModel.php
// require_once __DIR__ . '/../../db/Database.php';

class AttendanceModel
{
  private $db;
  public function __construct()
  {
    $database = new Database();
    $this->db = $database->getConnection();
  }

  // Cek apakah ada attendance tipe tertentu hari ini
  public function existsTodayType($user_id, $type)
  {
    $start = date('Y-m-d 00:00:00');
    $end = date('Y-m-d 23:59:59');
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM attendance WHERE user_id = :uid AND type = :type AND created_at BETWEEN :start AND :end");
    $stmt->execute([':uid' => $user_id, ':type' => $type, ':start' => $start, ':end' => $end]);
    return $stmt->fetchColumn() > 0;
  }

  public function create($user_id, $type, $scanned_token, $photo_path = null, $lat = null, $lon = null, $ip = null)
  {
    $stmt = $this->db->prepare("INSERT INTO attendance (user_id, type, scanned_token, photo_path, lat, lon, ip_address) VALUES (:uid, :type, :tok, :photo, :lat, :lon, :ip)");
    $stmt->execute([
      ':uid' => $user_id,
      ':type' => $type,
      ':tok' => $scanned_token,
      ':photo' => $photo_path,
      ':lat' => $lat,
      ':lon' => $lon,
      ':ip' => $ip
    ]);
    return $this->db->lastInsertId();
  }
}
