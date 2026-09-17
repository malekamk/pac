<?php
require __DIR__ . '/_auth.php';
$pageTitle = 'Hero Carousel';
$conn = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'delete') {
    $stmt = mysqli_prepare($conn, "DELETE FROM hero_slides WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
    mysqli_stmt_execute($stmt);
    $_SESSION['flash'] = 'Slide removed.';
  } else {
    $alt_text = trim($_POST['alt_text'] ?? '') ?: null;
    $sort_order = (int) ($_POST['sort_order'] ?? 0);
    $uploaded = handle_upload('image');

    if ($action === 'create') {
      if (!$uploaded) {
        $_SESSION['flash'] = 'Please choose a photo to upload.';
      } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO hero_slides (image, alt_text, sort_order) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssi', $uploaded, $alt_text, $sort_order);
        mysqli_stmt_execute($stmt);
        $_SESSION['flash'] = 'Slide added.';
      }
    } elseif ($action === 'update') {
      $id = (int) $_POST['id'];
      if ($uploaded) {
        $stmt = mysqli_prepare($conn, "UPDATE hero_slides SET image=?, alt_text=?, sort_order=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssii', $uploaded, $alt_text, $sort_order, $id);
      } else {
        $stmt = mysqli_prepare($conn, "UPDATE hero_slides SET alt_text=?, sort_order=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sii', $alt_text, $sort_order, $id);
      }
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'Slide updated.';
    }
  }
  header('Location: /admin/hero');
  exit;
}

$editRow = null;
if (isset($_GET['edit'])) {
  $stmt = mysqli_prepare($conn, "SELECT * FROM hero_slides WHERE id = ?");
  mysqli_stmt_bind_param($stmt, 'i', $_GET['edit']);
  mysqli_stmt_execute($stmt);
  $editRow = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$rows = mysqli_query($conn, "SELECT * FROM hero_slides ORDER BY sort_order ASC, id ASC");
$allRows = mysqli_fetch_all($rows, MYSQLI_ASSOC);
$totalCount = count($allRows);

$addLabel = 'Add Slide';
$addModalId = 'heroModal';
$liveUrl = '/';
include __DIR__ . '/_chrome_top.php';
?>
<h1>Hero Carousel</h1>
<p class="subtitle">These photos rotate in the homepage hero banner, ordered by the sort number below (lowest first). Add more than one to get a carousel.</p>

<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Total Slides</span><span class="kpi-icon"><?= admin_icon('image') ?></span></div>
    <div class="kpi-value"><?= $totalCount ?></div>
    <div class="kpi-caption">In the homepage carousel</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Carousel</span><span class="kpi-icon"><?= admin_icon('grid') ?></span></div>
    <div class="kpi-value" style="font-size:1.1rem;"><?= $totalCount > 1 ? 'Rotating' : 'Static' ?></div>
    <div class="kpi-caption"><?= $totalCount > 1 ? 'Arrows and dots shown' : 'Add another slide to rotate' ?></div>
  </div>
</div>

<div class="data-card">
  <div class="data-toolbar">
    <div class="data-search"><?= admin_icon('search') ?><input type="text" placeholder="Search slides..." disabled></div>
    <div class="data-toolbar-actions">
      <button type="button" class="pill-btn" disabled><?= admin_icon('filter') ?> Filter</button>
      <button type="button" class="pill-btn" disabled><?= admin_icon('download') ?> Export</button>
    </div>
  </div>
  <table class="list">
    <tr><th></th><th></th><th>Alt text</th><th>Sort</th><th></th></tr>
    <?php foreach ($allRows as $row): ?>
    <tr>
      <td><input type="checkbox"></td>
      <td><?php if ($row['image']): ?><img class="thumb-hero" src="/<?= htmlspecialchars($row['image']) ?>" alt=""><?php endif; ?></td>
      <td><?= htmlspecialchars($row['alt_text'] ?? '') ?></td>
      <td><?= (int) $row['sort_order'] ?></td>
      <td class="actions">
        <a href="/admin/hero?edit=<?= (int) $row['id'] ?>" aria-label="Edit"><?= admin_icon('pencil') ?></a>
        <form method="post" onsubmit="return confirm('Remove this slide?');" style="display:inline;">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
          <button type="submit" class="delete" aria-label="Delete"><?= admin_icon('trash') ?></button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
  <div class="data-footer">
    <span class="count">Showing all <?= $totalCount ?> slide<?= $totalCount === 1 ? '' : 's' ?></span>
    <div class="pagination">
      <span><?= admin_icon('chevron-left') ?></span>
      <span class="active">1</span>
      <span><?= admin_icon('chevron-right') ?></span>
    </div>
  </div>
</div>

<dialog id="heroModal" class="modal">
  <div class="modal-head">
    <h2><?= $editRow ? 'Edit Slide' : 'Add Slide' ?></h2>
    <button type="button" class="modal-close" onclick="document.getElementById('heroModal').close()" aria-label="Close">&times;</button>
  </div>
  <form class="stack" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $editRow ? 'update' : 'create' ?>">
    <?php if ($editRow): ?><input type="hidden" name="id" value="<?= (int) $editRow['id'] ?>"><?php endif; ?>

    <div class="field">
      <label for="image">Photo</label>
      <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp"<?= $editRow ? '' : ' required' ?>>
      <?php if (!empty($editRow['image'])): ?><img class="thumb-hero" src="/<?= htmlspecialchars($editRow['image']) ?>" alt=""><?php endif; ?>
    </div>
    <div class="field">
      <label for="alt_text">Alt text (describe the photo)</label>
      <input id="alt_text" name="alt_text" value="<?= htmlspecialchars($editRow['alt_text'] ?? '') ?>">
    </div>
    <div class="field">
      <label for="sort_order">Sort order</label>
      <input id="sort_order" name="sort_order" type="number" value="<?= (int) ($editRow['sort_order'] ?? 0) ?>">
    </div>

    <div style="display:flex;gap:10px;">
      <button class="btn" type="submit"><?= $editRow ? 'Save Changes' : 'Add Slide' ?></button>
      <button type="button" class="btn secondary" onclick="window.location.href='/admin/hero'">Cancel</button>
    </div>
  </form>
</dialog>

<?php if ($editRow): ?>
<script>document.getElementById('heroModal').showModal();</script>
<?php endif; ?>

<?php include __DIR__ . '/_chrome_bottom.php'; ?>
