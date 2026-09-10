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
  header('Location: hero');
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

include __DIR__ . '/_chrome_top.php';
?>
<h1>Hero Carousel</h1>
<p class="subtitle">These photos rotate in the homepage hero banner, ordered by the sort number below (lowest first). Add more than one to get a carousel.</p>

<div class="panel">
  <div class="panel-head">
    <h2>All Slides</h2>
    <button type="button" class="btn" onclick="document.getElementById('heroModal').showModal()">+ Add Slide</button>
  </div>
  <table class="list">
    <tr><th></th><th>Alt text</th><th>Sort</th><th></th></tr>
    <?php while ($row = mysqli_fetch_assoc($rows)): ?>
    <tr>
      <td><?php if ($row['image']): ?><img class="thumb" src="../<?= htmlspecialchars($row['image']) ?>" alt=""><?php endif; ?></td>
      <td><?= htmlspecialchars($row['alt_text'] ?? '') ?></td>
      <td><?= (int) $row['sort_order'] ?></td>
      <td class="actions">
        <a href="hero?edit=<?= (int) $row['id'] ?>">Edit</a>
        <form method="post" onsubmit="return confirm('Remove this slide?');" style="display:inline;">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
          <button type="submit" class="delete" style="background:none;border:none;padding:0;font:inherit;cursor:pointer;">Delete</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
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
      <?php if (!empty($editRow['image'])): ?><img class="thumb" src="../<?= htmlspecialchars($editRow['image']) ?>" alt=""><?php endif; ?>
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
      <button type="button" class="btn secondary" onclick="window.location.href='hero'">Cancel</button>
    </div>
  </form>
</dialog>

<?php if ($editRow): ?>
<script>document.getElementById('heroModal').showModal();</script>
<?php endif; ?>

<?php include __DIR__ . '/_chrome_bottom.php'; ?>
