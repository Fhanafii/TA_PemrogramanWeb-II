<?php
// require_once __DIR__ . '/../core/Controller.php';
// require_once __DIR__ . '/../core/Database.php';
// require_once __DIR__ . '/../helpers/auth.php';

class HomeController extends Controller
{
  public function index()
  {
    $pdo = (new Database())->getConnection();
    requireLogin(); // 🔒 wajib login untuk akses home

    if (isset($_GET['user'])) {
      $this->render('home', ['title' => 'Halaman Utama', 'user' => $_GET['user']]);
    } else {
      $this->render('home', ['title' => 'Halaman Utama']);
    }
  }
}
