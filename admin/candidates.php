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
  header('Location: /admin/candidates');
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
$allRows = mysqli_fetch_all($rows, MYSQLI_ASSOC);

$totalCount = count($allRows);
$wards = [];
$withPhotoCount = 0;
foreach ($allRows as $r) {
  if ($r['ward']) $wards[$r['ward']] = true;
  if ($r['image']) $withPhotoCount++;
}
$wardCount = count($wards);

$addLabel = 'Add Candidate';
$addModalId = 'candidateModal';
$liveUrl = '/candidates';
include __DIR__ . '/_chrome_top.php';
?>
<h1>Candidates</h1>
<p class="subtitle">Shown on the public Candidates page and the homepage ward candidates strip.</p>

<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Total Candidates</span><span class="kpi-icon"><?= admin_icon('users') ?></span></div>
    <div class="kpi-value"><?= $totalCount ?></div>
    <div class="kpi-caption">Standing under PAC</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Wards Covered</span><span class="kpi-icon"><?= admin_icon('flag') ?></span></div>
    <div class="kpi-value"><?= $wardCount ?></div>
    <div class="kpi-caption">Distinct wards</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">With Photos</span><span class="kpi-icon"><?= admin_icon('image') ?></span></div>
    <div class="kpi-value"><?= $withPhotoCount ?></div>
    <div class="kpi-caption">Have a campaign photo</div>
  </div>
</div>

<div class="data-card">
  <div class="data-toolbar">
    <div class="data-search"><?= admin_icon('search') ?><input type="text" placeholder="Search candidates..." disabled></div>
    <div class="data-toolbar-actions">
      <button type="button" class="pill-btn" disabled><?= admin_icon('filter') ?> Filter</button>
      <button type="button" class="pill-btn" disabled><?= admin_icon('download') ?> Export</button>
    </div>
  </div>
  <table class="list">
    <tr><th></th><th></th><th>Name</th><th>Ward</th><th>Role</th><th></th></tr>
    <?php foreach ($allRows as $row): ?>
    <tr>
      <td><input type="checkbox"></td>
      <td><?php if ($row['image']): ?><img class="thumb" src="/<?= htmlspecialchars($row['image']) ?>" alt=""><?php endif; ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?php if ($row['ward']): ?><span class="badge badge-green">Ward <?= htmlspecialchars($row['ward']) ?></span><?php endif; ?></td>
      <td><?= htmlspecialchars($row['role']) ?></td>
      <td class="actions">
        <a href="/admin/candidates?edit=<?= (int) $row['id'] ?>" aria-label="Edit"><?= admin_icon('pencil') ?></a>
        <form method="post" onsubmit="return confirm('Remove this candidate?');" style="display:inline;">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
          <button type="submit" class="delete" aria-label="Delete"><?= admin_icon('trash') ?></button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
  <div class="data-footer">
    <span class="count">Showing all <?= $totalCount ?> candidate<?= $totalCount === 1 ? '' : 's' ?></span>
    <div class="pagination">
      <span><?= admin_icon('chevron-left') ?></span>
      <span class="active">1</span>
      <span><?= admin_icon('chevron-right') ?></span>
    </div>
  </div>
</div>

<dialog id="candidateModal" class="modal">
  <div class="modal-head">
    <h2><?= $editRow ? 'Edit Candidate' : 'Add Candidate' ?></h2>
    <button type="button" class="modal-close" onclick="document.getElementById('candidateModal').close()" aria-label="Close">&times;</button>
  </div>
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
      <?php if (!empty($editRow['image'])): ?><img class="thumb" src="/<?= htmlspecialchars($editRow['image']) ?>" alt=""><?php endif; ?>
    </div>

    <div style="display:flex;gap:10px;">
      <button class="btn" type="submit"><?= $editRow ? 'Save Changes' : 'Add Candidate' ?></button>
      <button type="button" class="btn secondary" onclick="window.location.href='/admin/candidates'">Cancel</button>
    </div>
  </form>
</dialog>

<?php if ($editRow): ?>
<script>document.getElementById('candidateModal').showModal();</script>
<?php endif; ?>

<?php include __DIR__ . '/_chrome_bottom.php'; ?>
