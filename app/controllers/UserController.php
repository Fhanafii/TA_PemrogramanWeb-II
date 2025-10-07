<?php
// require_once __DIR__ . '/../core/Controller.php';
// require_once __DIR__ . '/../models/User.php';

class UserController extends Controller
{
  public function index()
  {
    requireLogin();
    $userModel = new User();
    $users = $userModel->getAll();

    $this->render('user_index', ['users' => $users]);
  }

  public function show()
  {
    requireLogin();
    $id = $_GET['id'] ?? 1;
    $userModel = new User();
    $user = $userModel->getById($id);

    $this->render('user_show', ['user' => $user]);
  }
}
