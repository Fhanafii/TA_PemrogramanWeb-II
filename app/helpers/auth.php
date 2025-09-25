<?php
function requireLogin()
{
  // session_start();
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?controller=auth&action=index");
    exit;
  }
}
