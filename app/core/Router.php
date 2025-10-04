<?php
session_start();
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Model.php';

require_once __DIR__ . '/../helpers/token.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/generateToken.php';
require_once __DIR__ . '/../helpers/loadEnv.php';
require_once __DIR__ . '/../helpers/logout.php';

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/ScheduleModel.php';
require_once __DIR__ . '/../models/ScheduleDayModel.php';
class Router
{
  public function handleRequest()
  {
    // cek cookie remember me
    // tryAutoLoginFromCookie();

    // Load environment variables
    loadEnv(__DIR__ . '/../../.env');

    $controllerName = $_GET['controller'] ?? 'home';
    $actionName     = $_GET['action'] ?? 'index';

    $controllerClass = ucfirst($controllerName) . 'Controller';
    $controllerFile  = __DIR__ . '/../controllers/' . $controllerClass . '.php';

    if (file_exists($controllerFile)) {
      require_once $controllerFile;
      $controller = new $controllerClass();

      if (method_exists($controller, $actionName)) {
        $controller->$actionName();
      } else {
        echo "Action <b>$actionName</b> tidak ditemukan.";
      }
    } else {
      echo "Controller <b>$controllerClass</b> tidak ditemukan bro.";
    }
  }
}
