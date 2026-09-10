<?php
require __DIR__ . '/_auth.php';
$pageTitle = 'Announcements';
$conn = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'delete') {
    $stmt = mysqli_prepare($conn, "DELETE FROM announcements WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
    mysqli_stmt_execute($stmt);
    $_SESSION['flash'] = 'Announcement deleted.';
  } else {
    $tag = trim($_POST['tag'] ?? '') ?: 'Announcement';
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '') ?: null;
    $published_at = $_POST['published_at'] ?? date('Y-m-d');
    $uploaded = handle_upload('image');

    if ($action === 'create') {
      $stmt = mysqli_prepare($conn, "INSERT INTO announcements (tag, title, body, image, published_at) VALUES (?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, 'sssss', $tag, $title, $body, $uploaded, $published_at);
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'Announcement added.';
    } elseif ($action === 'update') {
      $id = (int) $_POST['id'];
      if ($uploaded) {
        $stmt = mysqli_prepare($conn, "UPDATE announcements SET tag=?, title=?, body=?, image=?, published_at=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sssssi', $tag, $title, $body, $uploaded, $published_at, $id);
      } else {
        $stmt = mysqli_prepare($conn, "UPDATE announcements SET tag=?, title=?, body=?, published_at=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssssi', $tag, $title, $body, $published_at, $id);
      }
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'Announcement updated.';
    }
  }
  header('Location: announcements.php');
  exit;
}

$editRow = null;
if (isset($_GET['edit'])) {
  $stmt = mysqli_prepare($conn, "SELECT * FROM announcements WHERE id = ?");
  mysqli_stmt_bind_param($stmt, 'i', $_GET['edit']);
  mysqli_stmt_execute($stmt);
  $editRow = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$rows = mysqli_query($conn, "SELECT * FROM announcements ORDER BY published_at DESC, id DESC");

include __DIR__ . '/_chrome_top.php';
?>
<h1>Announcements</h1>
<p class="subtitle">The most recent one shows in the homepage Announcements banner.</p>

<div class="panel">
  <div class="panel-head">
    <h2>All Announcements</h2>
    <button type="button" class="btn" onclick="document.getElementById('announcementModal').showModal()">+ Add Announcement</button>
  </div>
  <table class="list">
    <tr><th></th><th>Title</th><th>Tag</th><th>Date</th><th></th></tr>
    <?php while ($row = mysqli_fetch_assoc($rows)): ?>
    <tr>
      <td><?php if ($row['image']): ?><img class="thumb" src="../<?= htmlspecialchars($row['image']) ?>" alt=""><?php endif; ?></td>
      <td><?= htmlspecialchars($row['title']) ?></td>
      <td><span class="badge"><?= htmlspecialchars($row['tag']) ?></span></td>
      <td><?= htmlspecialchars($row['published_at'] ? date('d M Y', strtotime($row['published_at'])) : '') ?></td>
      <td class="actions">
        <a href="announcements.php?edit=<?= (int) $row['id'] ?>">Edit</a>
        <form method="post" onsubmit="return confirm('Delete this announcement?');" style="display:inline;">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
          <button type="submit" class="delete" style="background:none;border:none;padding:0;font:inherit;cursor:pointer;">Delete</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

<dialog id="announcementModal" class="modal">
  <div class="modal-head">
    <h2><?= $editRow ? 'Edit Announcement' : 'Add Announcement' ?></h2>
    <button type="button" class="modal-close" onclick="document.getElementById('announcementModal').close()" aria-label="Close">&times;</button>
  </div>
  <form class="stack" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $editRow ? 'update' : 'create' ?>">
    <?php if ($editRow): ?><input type="hidden" name="id" value="<?= (int) $editRow['id'] ?>"><?php endif; ?>

    <div class="row-2">
      <div class="field">
        <label for="tag">Tag</label>
        <input id="tag" name="tag" placeholder="e.g. Interview Alert" value="<?= htmlspecialchars($editRow['tag'] ?? 'Announcement') ?>">
      </div>
      <div class="field">
        <label for="published_at">Date</label>
        <input id="published_at" name="published_at" type="date" value="<?= htmlspecialchars($editRow['published_at'] ?? date('Y-m-d')) ?>">
      </div>
    </div>
    <div class="field">
      <label for="title">Title</label>
      <input id="title" name="title" required value="<?= htmlspecialchars($editRow['title'] ?? '') ?>">
    </div>
    <div class="field">
      <label for="body">Body</label>
      <textarea id="body" name="body"><?= htmlspecialchars($editRow['body'] ?? '') ?></textarea>
    </div>
    <div class="field">
      <label for="image">Cover image</label>
      <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp">
      <?php if (!empty($editRow['image'])): ?><img class="thumb" src="../<?= htmlspecialchars($editRow['image']) ?>" alt=""><?php endif; ?>
    </div>

    <div style="display:flex;gap:10px;">
      <button class="btn" type="submit"><?= $editRow ? 'Save Changes' : 'Add Announcement' ?></button>
      <button type="button" class="btn secondary" onclick="window.location.href='announcements.php'">Cancel</button>
    </div>
  </form>
</dialog>

<?php if ($editRow): ?>
<script>document.getElementById('announcementModal').showModal();</script>
<?php endif; ?>

<?php include __DIR__ . '/_chrome_bottom.php'; ?>
