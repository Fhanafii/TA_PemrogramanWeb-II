<?php
// require_once __DIR__ . '/../core/Controller.php';
// require_once __DIR__ . '/../models/User.php';

class UserController extends Controller
{
  public function index()
  {
    $userModel = new User();
    $users = $userModel->getAll();

    $this->render('user_index', ['users' => $users]);
  }

  public function show()
  {
    $id = $_GET['id'] ?? 1;
    $userModel = new User();
    $user = $userModel->getById($id);

    $this->render('user_show', ['user' => $user]);
  }
}
