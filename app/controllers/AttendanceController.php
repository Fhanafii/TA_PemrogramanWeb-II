<?php

class AttendanceController extends Controller
{

  public function index()
  {
    if (empty($_SESSION['user_id'])) {
      header('Location: index.php?controller=auth&action=login');
      exit;
    }

    $userId = $_SESSION['user_id'];
    $scheduleId = $_GET['schedule_id'] ?? null;

    if (!$scheduleId) {
      // echo "Schedule ID tidak ditemukan.";
      // exit;
      $scheduleId = 1;
    }

    $attendanceModel = new AttendanceModel();
    $attendanceDays = $attendanceModel->getUserAttendanceBySchedule($userId, $scheduleId);

    // require __DIR__ . '/../../app/Views/list_atendance.php';
    $this->render('list_atendance', ['title' => '📋 Daftar Absensi Bulanan', 'attendanceDays' => $attendanceDays]);
  }
}
