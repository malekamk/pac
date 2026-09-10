<?php
require __DIR__ . '/_auth.php';
$pageTitle = 'Candidates';
$conn = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'delete') {
    $stmt = mysqli_prepare($conn, "DELETE FROM candidates WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
    mysqli_stmt_execute($stmt);
    $_SESSION['flash'] = 'Candidate removed.';
  } else {
    $name = trim($_POST['name'] ?? '');
    $ward = trim($_POST['ward'] ?? '') ?: null;
    $role = trim($_POST['role'] ?? '') ?: 'Councillor Candidate';
    $uploaded = handle_upload('image');

    if ($action === 'create') {
      $stmt = mysqli_prepare($conn, "INSERT INTO candidates (name, ward, role, image) VALUES (?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, 'ssss', $name, $ward, $role, $uploaded);
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'Candidate added.';
    } elseif ($action === 'update') {
      $id = (int) $_POST['id'];
      if ($uploaded) {
        $stmt = mysqli_prepare($conn, "UPDATE candidates SET name=?, ward=?, role=?, image=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssssi', $name, $ward, $role, $uploaded, $id);
      } else {
        $stmt = mysqli_prepare($conn, "UPDATE candidates SET name=?, ward=?, role=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sssi', $name, $ward, $role, $id);
      }
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'Candidate updated.';
    }
  }
  header('Location: candidates.php');
  exit;
}

$editRow = null;
if (isset($_GET['edit'])) {
  $stmt = mysqli_prepare($conn, "SELECT * FROM candidates WHERE id = ?");
  mysqli_stmt_bind_param($stmt, 'i', $_GET['edit']);
  mysqli_stmt_execute($stmt);
  $editRow = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$rows = mysqli_query($conn, "SELECT * FROM candidates ORDER BY id ASC");

include __DIR__ . '/_chrome_top.php';
?>
<h1>Candidates</h1>
<p class="subtitle">Shown on the public Candidates page and the homepage ward candidates strip.</p>

<div class="panel">
  <h2><?= $editRow ? 'Edit Candidate' : 'Add Candidate' ?></h2>
  <form class="stack" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $editRow ? 'update' : 'create' ?>">
    <?php if ($editRow): ?><input type="hidden" name="id" value="<?= (int) $editRow['id'] ?>"><?php endif; ?>

    <div class="field">
      <label for="name">Name</label>
      <input id="name" name="name" required value="<?= htmlspecialchars($editRow['name'] ?? '') ?>">
    </div>
    <div class="row-2">
      <div class="field">
        <label for="ward">Ward</label>
        <input id="ward" name="ward" placeholder="e.g. 100" value="<?= htmlspecialchars($editRow['ward'] ?? '') ?>">
      </div>
      <div class="field">
        <label for="role">Role</label>
        <input id="role" name="role" value="<?= htmlspecialchars($editRow['role'] ?? 'Councillor Candidate') ?>">
      </div>
    </div>
    <div class="field">
      <label for="image">Campaign poster / photo</label>
      <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp">
      <?php if (!empty($editRow['image'])): ?><img class="thumb" src="../<?= htmlspecialchars($editRow['image']) ?>" alt=""><?php endif; ?>
    </div>

    <div style="display:flex;gap:10px;">
      <button class="btn" type="submit"><?= $editRow ? 'Save Changes' : 'Add Candidate' ?></button>
      <?php if ($editRow): ?><a class="btn secondary" href="candidates.php">Cancel</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="panel">
  <h2>All Candidates</h2>
  <table class="list">
    <tr><th></th><th>Name</th><th>Ward</th><th>Role</th><th></th></tr>
    <?php while ($row = mysqli_fetch_assoc($rows)): ?>
    <tr>
      <td><?php if ($row['image']): ?><img class="thumb" src="../<?= htmlspecialchars($row['image']) ?>" alt=""><?php endif; ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['ward'] ?? '') ?></td>
      <td><?= htmlspecialchars($row['role']) ?></td>
      <td class="actions">
        <a href="candidates.php?edit=<?= (int) $row['id'] ?>">Edit</a>
        <form method="post" onsubmit="return confirm('Remove this candidate?');" style="display:inline;">
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
