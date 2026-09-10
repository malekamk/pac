<?php
require __DIR__ . '/_auth.php';
$pageTitle = 'Gallery';
$conn = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'delete') {
    $stmt = mysqli_prepare($conn, "DELETE FROM gallery_images WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
    mysqli_stmt_execute($stmt);
    $_SESSION['flash'] = 'Photo removed.';
  } else {
    $caption = trim($_POST['caption'] ?? '') ?: null;
    $display_mode = in_array($_POST['display_mode'] ?? '', ['cover', 'contain', 'pattern'], true) ? $_POST['display_mode'] : 'cover';
    $sort_order = (int) ($_POST['sort_order'] ?? 0);
    $uploaded = handle_upload('image');

    if ($action === 'create') {
      if (!$uploaded) {
        $_SESSION['flash'] = 'Please choose a photo to upload.';
      } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO gallery_images (image, caption, display_mode, sort_order) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sssi', $uploaded, $caption, $display_mode, $sort_order);
        mysqli_stmt_execute($stmt);
        $_SESSION['flash'] = 'Photo added.';
      }
    } elseif ($action === 'update') {
      $id = (int) $_POST['id'];
      if ($uploaded) {
        $stmt = mysqli_prepare($conn, "UPDATE gallery_images SET image=?, caption=?, display_mode=?, sort_order=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sssii', $uploaded, $caption, $display_mode, $sort_order, $id);
      } else {
        $stmt = mysqli_prepare($conn, "UPDATE gallery_images SET caption=?, display_mode=?, sort_order=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssii', $caption, $display_mode, $sort_order, $id);
      }
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'Photo updated.';
    }
  }
  header('Location: gallery');
  exit;
}

$editRow = null;
if (isset($_GET['edit'])) {
  $stmt = mysqli_prepare($conn, "SELECT * FROM gallery_images WHERE id = ?");
  mysqli_stmt_bind_param($stmt, 'i', $_GET['edit']);
  mysqli_stmt_execute($stmt);
  $editRow = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$rows = mysqli_query($conn, "SELECT * FROM gallery_images ORDER BY sort_order ASC, id ASC");

include __DIR__ . '/_chrome_top.php';
?>
<h1>Gallery</h1>
<p class="subtitle">Shown on the public Gallery page, ordered by the sort number below (lowest first).</p>

<div class="panel">
  <div class="panel-head">
    <h2>All Photos</h2>
    <button type="button" class="btn" onclick="document.getElementById('galleryModal').showModal()">+ Add Photo</button>
  </div>
  <table class="list">
    <tr><th></th><th>Caption</th><th>Display</th><th>Sort</th><th></th></tr>
    <?php while ($row = mysqli_fetch_assoc($rows)): ?>
    <tr>
      <td><?php if ($row['image']): ?><img class="thumb" src="../<?= htmlspecialchars($row['image']) ?>" alt=""><?php endif; ?></td>
      <td><?= htmlspecialchars($row['caption'] ?? '') ?></td>
      <td><span class="badge"><?= htmlspecialchars($row['display_mode']) ?></span></td>
      <td><?= (int) $row['sort_order'] ?></td>
      <td class="actions">
        <a href="gallery?edit=<?= (int) $row['id'] ?>">Edit</a>
        <form method="post" onsubmit="return confirm('Remove this photo?');" style="display:inline;">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
          <button type="submit" class="delete" style="background:none;border:none;padding:0;font:inherit;cursor:pointer;">Delete</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

<dialog id="galleryModal" class="modal">
  <div class="modal-head">
    <h2><?= $editRow ? 'Edit Photo' : 'Add Photo' ?></h2>
    <button type="button" class="modal-close" onclick="document.getElementById('galleryModal').close()" aria-label="Close">&times;</button>
  </div>
  <form class="stack" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $editRow ? 'update' : 'create' ?>">
    <?php if ($editRow): ?><input type="hidden" name="id" value="<?= (int) $editRow['id'] ?>"><?php endif; ?>

    <div class="field">
      <label for="image">Photo</label>
      <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp"<?= $editRow ? '' : ' required' ?>>
      <?php if (!empty($editRow['image'])): ?><img class="thumb" src="../<?= htmlspecialchars($editRow['image']) ?>" alt=""><?php endif; ?>
    </div>
    <div class="field">
      <label for="caption">Caption</label>
      <input id="caption" name="caption" value="<?= htmlspecialchars($editRow['caption'] ?? '') ?>">
    </div>
    <div class="row-2">
      <div class="field">
        <label for="display_mode">Display</label>
        <select id="display_mode" name="display_mode">
          <?php $mode = $editRow['display_mode'] ?? 'cover'; ?>
          <option value="cover" <?= $mode === 'cover' ? 'selected' : '' ?>>Cover (fills the tile)</option>
          <option value="contain" <?= $mode === 'contain' ? 'selected' : '' ?>>Contain (whole image, light background)</option>
          <option value="pattern" <?= $mode === 'pattern' ? 'selected' : '' ?>>Pattern (small emblem on patterned tile)</option>
        </select>
      </div>
      <div class="field">
        <label for="sort_order">Sort order</label>
        <input id="sort_order" name="sort_order" type="number" value="<?= (int) ($editRow['sort_order'] ?? 0) ?>">
      </div>
    </div>

    <div style="display:flex;gap:10px;">
      <button class="btn" type="submit"><?= $editRow ? 'Save Changes' : 'Add Photo' ?></button>
      <button type="button" class="btn secondary" onclick="window.location.href='gallery'">Cancel</button>
    </div>
  </form>
</dialog>

<?php if ($editRow): ?>
<script>document.getElementById('galleryModal').showModal();</script>
<?php endif; ?>

<?php include __DIR__ . '/_chrome_bottom.php'; ?>
