<?php
// require_once __DIR__ . '/../core/Controller.php';
// require_once __DIR__ . '/../core/Database.php';
// require_once __DIR__ . '/../helpers/auth.php';

class HomeController extends Controller
{
  // public function index()
  // {
  //   $pdo = (new Database())->getConnection();
  //   requireLogin(); // 🔒 wajib login untuk akses home

  //   if (isset($_GET['user'])) {
  //     $this->render('home', ['title' => 'Halaman Utama', 'user' => $_GET['user']]);
  //   } else {
  //     $this->render('home', ['title' => 'Halaman Utama']);
  //   }
  // }

  public function index()
  {
    requireLogin();

    $model = new DashboardModel();

    $data = [
      'totalUsers'        => $model->getTotalUsers(),
      'checkedInToday'    => $model->getCheckedInToday(),
      'notCheckedInToday' => $model->getNotCheckedInToday(),
      'totalDepartments'  => $model->getTotalDepartements(),
      'totalPositions'    => $model->getTotalPositions(),
      'totalSchedules'    => $model->getTotalSchedules(),
      'activeSchedule'    => $model->getActiveSchedule(),
    ];

    $this->render('home', [
      'title' => '🏠 Dashboard',
      'data'  => $data
    ]);
  }
}
