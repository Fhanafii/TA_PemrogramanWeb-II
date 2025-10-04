<!DOCTYPE html>
<html>

<head>
  <title><?= $title ?></title>
</head>

<body>
  <h1><?= $title ?></h1>

  <form method="POST" action="index.php?controller=Auth&action=login">
    <label>Email:</label><br>
    <input type="email" name="email" required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
    <input type="checkbox" name="remember_me"><br>
  </form>
</body>

</html>