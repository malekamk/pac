<?php
require __DIR__ . '/_auth.php';
$pageTitle = 'My Profile';
$conn = db();

$stmt = mysqli_prepare($conn, "SELECT * FROM admins WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['admin_id']);
mysqli_stmt_execute($stmt);
$me = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'update_profile') {
    $name = trim($_POST['name'] ?? '');
    $position = trim($_POST['position'] ?? '') ?: null;
    $uploaded = handle_upload('profile_image');

    if ($uploaded) {
      $stmt = mysqli_prepare($conn, "UPDATE admins SET name=?, position=?, profile_image=? WHERE id=?");
      mysqli_stmt_bind_param($stmt, 'sssi', $name, $position, $uploaded, $_SESSION['admin_id']);
    } else {
      $stmt = mysqli_prepare($conn, "UPDATE admins SET name=?, position=? WHERE id=?");
      mysqli_stmt_bind_param($stmt, 'ssi', $name, $position, $_SESSION['admin_id']);
    }
    mysqli_stmt_execute($stmt);
    $_SESSION['admin_name'] = $name;
    if ($uploaded) $_SESSION['admin_image'] = $uploaded;
    $_SESSION['flash'] = 'Profile updated.';
    header('Location: profile');
    exit;
  }

  if ($action === 'change_password') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (!password_verify($current, $me['password_hash'])) {
      $error = 'Your current password is incorrect.';
    } elseif (strlen($new) < 8) {
      $error = 'New password must be at least 8 characters.';
    } elseif ($new !== $confirm) {
      $error = 'New password and confirmation do not match.';
    } else {
      $hash = password_hash($new, PASSWORD_DEFAULT);
      $stmt = mysqli_prepare($conn, "UPDATE admins SET password_hash=? WHERE id=?");
      mysqli_stmt_bind_param($stmt, 'si', $hash, $_SESSION['admin_id']);
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'Password changed.';
      header('Location: profile');
      exit;
    }
  }
}

include __DIR__ . '/_chrome_top.php';
?>
<h1>My Profile</h1>
<p class="subtitle">Update how you appear to the team, and manage your own login.</p>

<?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="panel">
  <h2>Profile Details</h2>
  <form class="stack" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="update_profile">
    <?php if ($me['profile_image']): ?><img class="thumb" style="width:72px;height:72px;" src="../<?= htmlspecialchars($me['profile_image']) ?>" alt=""><?php endif; ?>
    <div class="field">
      <label for="profile_image">Profile photo</label>
      <input id="profile_image" name="profile_image" type="file" accept=".jpg,.jpeg,.png,.webp">
    </div>
    <div class="row-2">
      <div class="field">
        <label for="name">Name</label>
        <input id="name" name="name" required value="<?= htmlspecialchars($me['name']) ?>">
      </div>
      <div class="field">
        <label for="position">Role / Position</label>
        <input id="position" name="position" placeholder="e.g. Branch Secretary" value="<?= htmlspecialchars($me['position'] ?? '') ?>">
      </div>
    </div>
    <div class="field">
      <label>Email</label>
      <input value="<?= htmlspecialchars($me['email']) ?>" disabled style="opacity:.6;">
    </div>
    <div><button class="btn" type="submit">Save Profile</button></div>
  </form>
</div>

<div class="panel">
  <h2>Change Password</h2>
  <form class="stack" method="post">
    <input type="hidden" name="action" value="change_password">
    <div class="field">
      <label for="current_password">Current Password</label>
      <input id="current_password" name="current_password" type="password" required>
    </div>
    <div class="row-2">
      <div class="field">
        <label for="new_password">New Password</label>
        <input id="new_password" name="new_password" type="password" required minlength="8">
      </div>
      <div class="field">
        <label for="confirm_password">Confirm New Password</label>
        <input id="confirm_password" name="confirm_password" type="password" required minlength="8">
      </div>
    </div>
    <div><button class="btn" type="submit">Change Password</button></div>
  </form>
</div>
<?php include __DIR__ . '/_chrome_bottom.php'; ?>
