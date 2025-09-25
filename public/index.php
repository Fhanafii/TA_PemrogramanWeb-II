<?php
require_once __DIR__ . '/../app/core/Router.php';

// auto login kalau ada cookie remember_me
// tryAutoLoginFromCookie();

// Jalankan router
$router = new Router();
$router->handleRequest();
