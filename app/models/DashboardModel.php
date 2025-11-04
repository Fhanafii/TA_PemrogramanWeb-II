<?php
class DashboardModel
{
  private $db;

  public function __construct()
  {
    $database = new Database();
    $this->db = $database->getConnection();
  }

  // Total pegawai
  public function getTotalUsers()
  {
    $stmt = $this->db->query("SELECT COUNT(*) FROM users");
    return $stmt->fetchColumn();
  }

  // Total departemen
  public function getTotalDepartements()
  {
    $stmt = $this->db->query("SELECT COUNT(*) FROM departements");
    return $stmt->fetchColumn();
  }

  // Total posisi
  public function getTotalPositions()
  {
    $stmt = $this->db->query("SELECT COUNT(*) FROM positions");
    return $stmt->fetchColumn();
  }

  // Total schedule
  public function getTotalSchedules()
  {
    $stmt = $this->db->query("SELECT COUNT(*) FROM schedules");
    return $stmt->fetchColumn();
  }

  // Jadwal aktif (bulan & tahun sekarang)
  public function getActiveSchedule()
  {
    $month = date('n');
    $year = date('Y');
    $stmt = $this->db->prepare("SELECT * FROM schedules WHERE month = :month AND year = :year LIMIT 1");
    $stmt->execute([':month' => $month, ':year' => $year]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Pegawai yang sudah check-in hari ini
  public function getCheckedInToday()
  {
    $today = date('Y-m-d');
    $stmt = $this->db->prepare("SELECT COUNT(DISTINCT user_id) FROM attendance WHERE type = 'in' AND DATE(created_at) = :today");
    $stmt->execute([':today' => $today]);
    return $stmt->fetchColumn();
  }

  // Pegawai yang belum check-in hari ini
  public function getNotCheckedInToday()
  {
    $today = date('Y-m-d');
    $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM users 
            WHERE id NOT IN (
                SELECT DISTINCT user_id 
                FROM attendance 
                WHERE type = 'in' AND DATE(created_at) = :today
            )
        ");
    $stmt->execute([':today' => $today]);
    return $stmt->fetchColumn();
  }
}
