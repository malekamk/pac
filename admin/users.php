<?php
require __DIR__ . '/_auth.php';
$pageTitle = 'Users';
$conn = db();

function count_rows($conn, $table) {
  $res = mysqli_query($conn, "SELECT COUNT(*) AS c FROM `$table`");
  return (int) mysqli_fetch_assoc($res)['c'];
}

function random_password($length = 10) {
  $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
  $out = '';
  for ($i = 0; $i < $length; $i++) $out .= $chars[random_int(0, strlen($chars) - 1)];
  return $out;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'delete') {
    $id = (int) $_POST['id'];
    if ($id === (int) $_SESSION['admin_id']) {
      $_SESSION['flash'] = "You can't delete your own account while logged in.";
    } elseif (count_rows($conn, 'admins') <= 1) {
      $_SESSION['flash'] = 'At least one admin account must remain.';
    } else {
      $stmt = mysqli_prepare($conn, "DELETE FROM admins WHERE id = ?");
      mysqli_stmt_bind_param($stmt, 'i', $id);
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'User removed.';
    }
  } elseif ($action === 'create') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '') ?: random_password();
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO admins (name, email, password_hash) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $hash);
    if (mysqli_stmt_execute($stmt)) {
      $_SESSION['flash'] = "User created. Login: $email / $password — copy this now, it won't be shown again.";
    } else {
      $_SESSION['flash'] = 'Could not create user — that email may already be in use.';
    }
  }
  header('Location: users.php');
  exit;
}

$rows = mysqli_query($conn, "SELECT id, name, email, created_at FROM admins ORDER BY id ASC");
include __DIR__ . '/_chrome_top.php';
?>
<h1>Users</h1>
<p class="subtitle">Accounts that can log into this admin panel. No public sign-up — you create every account here and hand the login to them directly.</p>

<div class="panel">
  <h2>Add User</h2>
  <form class="stack" method="post">
    <input type="hidden" name="action" value="create">
    <div class="row-2">
      <div class="field">
        <label for="name">Name</label>
        <input id="name" name="name" required>
      </div>
      <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>
      </div>
    </div>
    <div class="field">
      <label for="password">Password (leave blank to auto-generate one)</label>
      <input id="password" name="password" type="text">
    </div>
    <div><button class="btn" type="submit">Create User</button></div>
  </form>
</div>

<div class="panel">
  <h2>All Users</h2>
  <table class="list">
    <tr><th>Name</th><th>Email</th><th>Added</th><th></th></tr>
    <?php while ($row = mysqli_fetch_assoc($rows)): ?>
    <tr>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars(date('d M Y', strtotime($row['created_at']))) ?></td>
      <td class="actions">
        <form method="post" onsubmit="return confirm('Remove this user?');" style="display:inline;">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
          <button type="submit" class="delete" style="background:none;border:none;padding:0;font:inherit;cursor:pointer;">Delete</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
<?php include __DIR__ . '/_chrome_bottom.php'; ?>
