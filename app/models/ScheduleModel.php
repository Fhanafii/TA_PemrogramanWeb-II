<?php
// app/Models/ScheduleModel.php
// require_once __DIR__ . '/../../db/Database.php';

class ScheduleModel extends Model
{
  // private $db;
  // public function __construct()
  // {
  //   $this->db = (new Database())->getConnection();
  // }

  public function create($name, $year, $month, $created_by = null, $note = null, $default_checkin = '08:00:00', $default_checkout = '16:00:00')
  {
    $this->db->beginTransaction();
    try {
      $stmt = $this->db->prepare("INSERT INTO schedules (name, year, month, created_by, note, default_checkin, default_checkout) VALUES (:name, :year, :month, :created_by, :note, :ci, :co)");
      $stmt->execute([
        ':name' => $name,
        ':year' => $year,
        ':month' => $month,
        ':created_by' => $created_by,
        ':note' => $note,
        ':ci' => $default_checkin,
        ':co' => $default_checkout
      ]);
      $scheduleId = $this->db->lastInsertId();

      // generate days
      $days = (int) (new DateTime("$year-$month-01"))->format('t'); // jumlah hari
      $stmtDay = $this->db->prepare("INSERT INTO schedule_days (schedule_id, the_date, status) VALUES (:sid, :the_date, 'work')");
      for ($d = 1; $d <= $days; $d++) {
        $date = sprintf("%04d-%02d-%02d", $year, $month, $d);
        $stmtDay->execute([':sid' => $scheduleId, ':the_date' => $date]);
      }

      $this->db->commit();
      return $scheduleId;
    } catch (Exception $e) {
      $this->db->rollBack();
      throw $e;
    }
  }

  public function find($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM schedules WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findByYearMonth($year, $month)
  {
    $stmt = $this->db->prepare("SELECT * FROM schedules WHERE year = :y AND month = :m LIMIT 1");
    $stmt->execute([':y' => $year, ':m' => $month]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function all()
  {
    $stmt = $this->db->query("SELECT * FROM schedules ORDER BY year DESC, month DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllSchedules()
  {
    $sql = "SELECT id, month, year, COUNT(*) as days_count
            FROM schedules
            GROUP BY year, month
            ORDER BY year DESC, month DESC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function update($id, $data)
  {
    $fields = [];
    $params = [':id' => $id];
    foreach (['name', 'note', 'default_checkin', 'default_checkout'] as $k) {
      if (isset($data[$k])) {
        $fields[] = "$k = :$k";
        $params[":$k"] = $data[$k];
      }
    }
    if (empty($fields)) return false;
    $sql = "UPDATE schedules SET " . implode(', ', $fields) . " WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute($params);
  }

  public function delete($id)
  {
    $stmt = $this->db->prepare("DELETE FROM schedules WHERE id = :id");
    return $stmt->execute([':id' => $id]);
  }
}
