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

  public function getUserAttendanceBySchedule($userId, $scheduleId)
  {
    $query = "
      SELECT 
          sd.the_date,
          sd.status AS day_status,
          a_in.id AS checkin_id,
          a_out.id AS checkout_id,
          a_in.created_at AS checkin_time,
          a_out.created_at AS checkout_time
      FROM schedule_days sd
      LEFT JOIN attendance a_in 
          ON DATE(a_in.created_at) = sd.the_date 
          AND a_in.user_id = :user_id
          AND a_in.type = 'in'
      LEFT JOIN attendance a_out 
          ON DATE(a_out.created_at) = sd.the_date 
          AND a_out.user_id = :user_id
          AND a_out.type = 'out'
      WHERE sd.schedule_id = :schedule_id
      ORDER BY sd.the_date
    ";

    $stmt = $this->db->prepare($query);
    $stmt->execute([
      ':user_id' => $userId,
      ':schedule_id' => $scheduleId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getLatestScheduleId()
  {
    $stmt = $this->db->query("SELECT id, year, month FROM schedules ORDER BY created_at DESC LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getScheduleByYearMonth($year, $month)
  {
    $stmt = $this->db->prepare("SELECT id, year, month FROM schedules WHERE year = :y AND month = :m");
    $stmt->execute([':y' => $year, ':m' => $month]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
