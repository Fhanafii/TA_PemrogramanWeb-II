<?php
// app/Models/ScheduleDayModel.php
// require_once __DIR__ . '/../../db/Database.php';

class ScheduleDayModel extends Model
{
  // private $db;
  // public function __construct()
  // {
  //   $this->db = (new Database())->getConnection();
  // }

  public function getBySchedule($schedule_id)
  {
    $stmt = $this->db->prepare("SELECT * FROM schedule_days WHERE schedule_id = :sid ORDER BY the_date ASC");
    $stmt->execute([':sid' => $schedule_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function find($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM schedule_days WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function updateDay($id, $data)
  {
    $fields = [];
    $params = [':id' => $id];
    foreach (['status', 'note', 'checkin_time', 'checkout_time'] as $k) {
      if (array_key_exists($k, $data)) {
        $fields[] = "$k = :$k";
        $params[":$k"] = $data[$k];
      }
    }
    if (empty($fields)) return false;
    $sql = "UPDATE schedule_days SET " . implode(', ', $fields) . " WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute($params);
  }

  public function setOffDates($schedule_id, array $dates)
  {
    // set status = off for given dates (array of 'YYYY-MM-DD')
    $stmt = $this->db->prepare("UPDATE schedule_days SET status = 'off' WHERE schedule_id = :sid AND the_date = :the_date");
    foreach ($dates as $d) {
      $stmt->execute([':sid' => $schedule_id, ':the_date' => $d]);
    }
    return true;
  }

  public function resetAllToWork($schedule_id)
  {
    $stmt = $this->db->prepare("UPDATE schedule_days SET status = 'work', note = NULL, checkin_time = NULL, checkout_time = NULL WHERE schedule_id = :sid");
    return $stmt->execute([':sid' => $schedule_id]);
  }
}
