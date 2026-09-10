<?php
require __DIR__ . '/../config.php';
session_start();

if (!empty($_SESSION['admin_id'])) {
  header('Location: index');
  exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  $stmt = mysqli_prepare(db(), "SELECT id, name, password_hash, role, profile_image FROM admins WHERE email = ?");
  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $admin = mysqli_fetch_assoc($result);

  if ($admin && password_verify($password, $admin['password_hash'])) {
    session_regenerate_id(true);
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
    $_SESSION['admin_role'] = $admin['role'];
    $_SESSION['admin_image'] = $admin['profile_image'];
    header('Location: index');
    exit;
  }
  $error = 'Incorrect email or password.';
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Log In | PAC Johannesburg Admin</title>
<link rel="icon" href="../assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" type="image/png">
<link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="login-wrap">
    <div class="login-card">
      <img src="../assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" alt="">
      <h1>PAC Johannesburg</h1>
      <p class="subtitle">Admin sign in</p>
      <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
      <form class="stack" method="post">
        <div class="field">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" required autofocus>
        </div>
        <div class="field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" required>
        </div>
        <button class="btn" type="submit">Log In</button>
      </form>
    </div>
    <p class="credit">Built by <a href="https://starapplications.co.za" target="_blank" rel="noopener">StarApplications</a></p>
  </div>
</body>
</html>
