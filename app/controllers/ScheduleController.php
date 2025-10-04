<?php
// app/Controllers/ScheduleController.php
// require_once __DIR__ . '/../Models/ScheduleModel.php';
// require_once __DIR__ . '/../Models/ScheduleDayModel.php';

class ScheduleController extends Controller
{
  private $scheduleModel;
  private $dayModel;
  public function __construct()
  {
    $this->scheduleModel = new ScheduleModel();
    $this->dayModel = new ScheduleDayModel();
  }

  // list schedules
  public function index()
  {
    // $schedules = $this->scheduleModel->all();
    $schedules = $this->scheduleModel->getAllSchedules();
    // include __DIR__ . '/../../app/Views/schedules/index.php';
    $this->render('display_scadjule', ['title' => '📅 Daftar Jadwal Pegawai', 'schedules' => $schedules]);
  }

  // show create form; handle POST create
  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = $_POST['name'] ?? '';
      $year = intval($_POST['year'] ?? date('Y'));
      $month = intval($_POST['month'] ?? date('n'));
      $note = $_POST['note'] ?? null;
      $default_checkin = $_POST['default_checkin'] ?? '08:00:00';
      $default_checkout = $_POST['default_checkout'] ?? '16:00:00';
      $created_by = $_SESSION['user_id'] ?? null;

      // check unique year-month
      if ($this->scheduleModel->findByYearMonth($year, $month)) {
        $_SESSION['flash'] = "Schedule untuk $year-$month sudah ada.";
        header('Location: ?controller=schedule&action=index');
        exit;
      }

      $id = $this->scheduleModel->create($name, $year, $month, $created_by, $note, $default_checkin, $default_checkout);
      $_SESSION['flash'] = "Schedule berhasil dibuat.";
      header('Location: ?controller=schedule&action=edit&id=' . $id);
      exit;
    }
    // include __DIR__ . '/../../app/Views/schedules/create.php';
    $this->render('create', ['title' => 'Buat Schedule']);
  }

  // edit schedule metadata + list days to edit
  public function edit()
  {
    $id = intval($_GET['id'] ?? 0);
    $schedule = $this->scheduleModel->find($id);
    if (!$schedule) {
      http_response_code(404);
      echo "Not found";
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // update metadata
      $this->scheduleModel->update($id, [
        'name' => $_POST['name'] ?? $schedule['name'],
        'note' => $_POST['note'] ?? $schedule['note'],
        'default_checkin' => $_POST['default_checkin'] ?? $schedule['default_checkin'],
        'default_checkout' => $_POST['default_checkout'] ?? $schedule['default_checkout']
      ]);
      $_SESSION['flash'] = "Schedule updated.";
      header('Location: ?controller=schedule&action=edit&id=' . $id);
      exit;
    }

    $days = $this->dayModel->getBySchedule($id);
    // include __DIR__ . '/../../app/Views/schedules/edit.php';
    $this->render('edit', ['title' => 'Edit Schedule: ' . htmlspecialchars($schedule['name'] ?? ''), 'days' => $days, 'schedule' => $schedule]);
  }

  // update single day (ajax)
  public function updateDay()
  {
    // expects POST id, status, note, checkin_time, checkout_time
    $id = intval($_POST['id'] ?? 0);
    $data = [
      'status' => $_POST['status'] ?? null,
      'note' => $_POST['note'] ?? null,
      'checkin_time' => $_POST['checkin_time'] ?? null,
      'checkout_time' => $_POST['checkout_time'] ?? null,
    ];
    $this->dayModel->updateDay($id, $data);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok']);
  }

  public function delete()
  {
    $id = intval($_GET['id'] ?? 0);
    $this->scheduleModel->delete($id);
    $_SESSION['flash'] = "Schedule dihapus.";
    header('Location: ?controller=schedule&action=index');
    exit;
  }

  // optional: mark multiple dates as off (e.g., from calendar import)
  public function setOffDatesFromArray($schedule_id, array $dates)
  {
    $this->dayModel->setOffDates($schedule_id, $dates);
  }
}
