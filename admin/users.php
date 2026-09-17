<?php
require __DIR__ . '/_auth.php';
$pageTitle = 'Users';
$conn = db();
$amAdmin = is_admin();

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
  if (!$amAdmin) {
    $_SESSION['flash'] = 'Only admins can manage users.';
    header('Location: /admin/users');
    exit;
  }

  $action = $_POST['action'] ?? '';

  if ($action === 'delete') {
    $id = (int) $_POST['id'];
    if ($id === (int) $_SESSION['admin_id']) {
      $_SESSION['flash'] = "You can't delete your own account while logged in.";
    } elseif (count_rows($conn, 'admins') <= 1) {
      $_SESSION['flash'] = 'At least one account must remain.';
    } else {
      $stmt = mysqli_prepare($conn, "DELETE FROM admins WHERE id = ?");
      mysqli_stmt_bind_param($stmt, 'i', $id);
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'User removed.';
    }
  } elseif ($action === 'create') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $position = trim($_POST['position'] ?? '') ?: null;
    $role = ($_POST['role'] ?? 'member') === 'admin' ? 'admin' : 'member';
    $password = trim($_POST['password'] ?? '') ?: random_password();
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO admins (name, email, password_hash, role, position) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $hash, $role, $position);
    if (mysqli_stmt_execute($stmt)) {
      $_SESSION['flash'] = "User created. Login: $email / $password — copy this now, it won't be shown again.";
    } else {
      $_SESSION['flash'] = 'Could not create user — that email may already be in use.';
    }
  } elseif ($action === 'set_role') {
    $id = (int) $_POST['id'];
    $role = $_POST['role'] === 'admin' ? 'admin' : 'member';
    if ($id === (int) $_SESSION['admin_id'] && $role !== 'admin') {
      $_SESSION['flash'] = "You can't demote your own account while logged in.";
    } else {
      $stmt = mysqli_prepare($conn, "UPDATE admins SET role=? WHERE id=?");
      mysqli_stmt_bind_param($stmt, 'si', $role, $id);
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'Role updated.';
    }
  }
  header('Location: /admin/users');
  exit;
}

$rows = mysqli_query($conn, "SELECT id, name, email, role, position, profile_image, created_at FROM admins ORDER BY id ASC");
$allRows = mysqli_fetch_all($rows, MYSQLI_ASSOC);
$totalCount = count($allRows);
$adminCount = 0;
foreach ($allRows as $r) { if ($r['role'] === 'admin') $adminCount++; }
$memberCount = $totalCount - $adminCount;

if ($amAdmin) {
  $addLabel = 'Add User';
  $addModalId = 'userModal';
}
include __DIR__ . '/_chrome_top.php';
?>
<h1>Users</h1>
<p class="subtitle">
  <?= $amAdmin
    ? "Accounts that can log into this admin panel. No public sign-up — you create every account here and hand the login to them directly."
    : "The PAC Johannesburg team. Only admins can add, edit or remove accounts." ?>
</p>

<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Total Users</span><span class="kpi-icon"><?= admin_icon('users') ?></span></div>
    <div class="kpi-value"><?= $totalCount ?></div>
    <div class="kpi-caption">Can log into this panel</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Admins</span><span class="kpi-icon"><?= admin_icon('user-circle') ?></span></div>
    <div class="kpi-value"><?= $adminCount ?></div>
    <div class="kpi-caption">Can manage users</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Members</span><span class="kpi-icon"><?= admin_icon('users') ?></span></div>
    <div class="kpi-value"><?= $memberCount ?></div>
    <div class="kpi-caption">Can edit site content</div>
  </div>
</div>

<div class="data-card">
  <div class="data-toolbar">
    <div class="data-search"><?= admin_icon('search') ?><input type="text" placeholder="Search users..." disabled></div>
    <div class="data-toolbar-actions">
      <button type="button" class="pill-btn" disabled><?= admin_icon('filter') ?> Filter</button>
      <button type="button" class="pill-btn" disabled><?= admin_icon('download') ?> Export</button>
    </div>
  </div>
  <table class="list">
    <tr><th></th><th>Name</th><th>Position</th><th>Email</th><th>Permission</th><?php if ($amAdmin): ?><th></th><?php endif; ?></tr>
    <?php foreach ($allRows as $row): ?>
    <tr>
      <td class="type-cell">
        <?php if ($row['profile_image']): ?>
          <img class="thumb" style="border-radius:50%;" src="/<?= htmlspecialchars($row['profile_image']) ?>" alt="">
        <?php else: ?>
          <span class="tb-avatar-fallback"><?= htmlspecialchars(strtoupper(substr($row['name'], 0, 1))) ?></span>
        <?php endif; ?>
      </td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['position'] ?? '') ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td>
        <?php if ($amAdmin): ?>
        <form method="post" style="display:inline;">
          <input type="hidden" name="action" value="set_role">
          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
          <select name="role" onchange="this.form.submit()" style="padding:6px 8px;border-radius:8px;border:1px solid var(--border);font-size:.82rem;font-family:inherit;">
            <option value="member" <?= $row['role'] === 'member' ? 'selected' : '' ?>>Member</option>
            <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
          </select>
        </form>
        <?php else: ?>
          <span class="badge badge-green"><?= htmlspecialchars(ucfirst($row['role'])) ?></span>
        <?php endif; ?>
      </td>
      <?php if ($amAdmin): ?>
      <td class="actions">
        <form method="post" onsubmit="return confirm('Remove this user?');" style="display:inline;">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
          <button type="submit" class="delete" aria-label="Delete"><?= admin_icon('trash') ?></button>
        </form>
      </td>
      <?php endif; ?>
    </tr>
    <?php endforeach; ?>
  </table>
  <div class="data-footer">
    <span class="count">Showing all <?= $totalCount ?> user<?= $totalCount === 1 ? '' : 's' ?></span>
    <div class="pagination">
      <span><?= admin_icon('chevron-left') ?></span>
      <span class="active">1</span>
      <span><?= admin_icon('chevron-right') ?></span>
    </div>
  </div>
</div>

<?php if ($amAdmin): ?>
<dialog id="userModal" class="modal">
  <div class="modal-head">
    <h2>Add User</h2>
    <button type="button" class="modal-close" onclick="document.getElementById('userModal').close()" aria-label="Close">&times;</button>
  </div>
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
    <div class="row-2">
      <div class="field">
        <label for="position">Role / Position</label>
        <input id="position" name="position" placeholder="e.g. Branch Secretary">
      </div>
      <div class="field">
        <label for="role">Permission Level</label>
        <select id="role" name="role">
          <option value="member">Member (can edit site content)</option>
          <option value="admin">Admin (can also manage users)</option>
        </select>
      </div>
    </div>
    <div class="field">
      <label for="password">Password (leave blank to auto-generate one)</label>
      <input id="password" name="password" type="text">
    </div>
    <div style="display:flex;gap:10px;">
      <button class="btn" type="submit">Create User</button>
      <button type="button" class="btn secondary" onclick="document.getElementById('userModal').close()">Cancel</button>
    </div>
  </form>
</dialog>
<?php endif; ?>

<?php include __DIR__ . '/_chrome_bottom.php'; ?>
