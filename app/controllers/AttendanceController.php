<?php

class AttendanceController extends Controller
{
  public function index()
  {
    requireLogin();

    if (empty($_SESSION['user_id'])) {
      header('Location: index.php?controller=auth&action=login');
      exit;
    }

    $userId = $_SESSION['user_id'];
    $attendanceModel = new AttendanceModel();

    // Ambil parameter tahun dan bulan (jika ada)
    $year = isset($_GET['year']) ? (int)$_GET['year'] : null;
    $month = isset($_GET['month']) ? (int)$_GET['month'] : null;
    $scheduleId = $_GET['schedule_id'] ?? null;

    // Jika tidak ada schedule_id atau parameter bulan/tahun → ambil schedule terakhir
    if (!$scheduleId) {
      if ($year && $month) {
        $schedule = $attendanceModel->getScheduleByYearMonth($year, $month);
      } else {
        $month = date('n');  // bulan sekarang
        $year  = date('Y');  // tahun sekarang
        $schedule = $attendanceModel->getScheduleByYearMonth($year, $month);
        // $schedule = $attendanceModel->getLatestScheduleId();
      }

      if (!$schedule) {
        die('❌ Belum ada schedule yang dibuat.');
      }

      $scheduleId = $schedule['id'];
      $year = $schedule['year'];
      $month = $schedule['month'];
    } else {
      // Jika schedule_id diberikan langsung, ambil data bulan & tahun
      $stmt = (new Database())->getConnection()->prepare("SELECT year, month FROM schedules WHERE id = :id");
      $stmt->execute([':id' => $scheduleId]);
      $schedule = $stmt->fetch(PDO::FETCH_ASSOC);
      $year = $schedule['year'];
      $month = $schedule['month'];
    }

    // Ambil data attendance
    $attendanceDays = $attendanceModel->getUserAttendanceBySchedule($userId, $scheduleId);

    // Kirim ke view
    $this->render('list_atendance', [
      'title' => '📋 Daftar Absensi Bulanan',
      'attendanceDays' => $attendanceDays,
      'year' => $year,
      'month' => $month
    ]);
  }
}
