<?php
require __DIR__ . '/_auth.php';
$pageTitle = 'Events';
$conn = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'delete') {
    $stmt = mysqli_prepare($conn, "DELETE FROM events WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $_POST['id']);
    mysqli_stmt_execute($stmt);
    $_SESSION['flash'] = 'Event deleted.';
  } else {
    $title = trim($_POST['title'] ?? '');
    $event_date = $_POST['event_date'] ?? '';
    $event_time = trim($_POST['event_time'] ?? '') ?: null;
    $venue = trim($_POST['venue'] ?? '') ?: null;
    $description = trim($_POST['description'] ?? '') ?: null;
    $featured = isset($_POST['featured']) ? 1 : 0;
    $uploaded = handle_upload('image');

    if ($action === 'create') {
      $stmt = mysqli_prepare($conn, "INSERT INTO events (title, event_date, event_time, venue, description, image, featured) VALUES (?, ?, ?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, 'ssssssi', $title, $event_date, $event_time, $venue, $description, $uploaded, $featured);
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'Event added.';
    } elseif ($action === 'update') {
      $id = (int) $_POST['id'];
      if ($uploaded) {
        $stmt = mysqli_prepare($conn, "UPDATE events SET title=?, event_date=?, event_time=?, venue=?, description=?, image=?, featured=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssssssii', $title, $event_date, $event_time, $venue, $description, $uploaded, $featured, $id);
      } else {
        $stmt = mysqli_prepare($conn, "UPDATE events SET title=?, event_date=?, event_time=?, venue=?, description=?, featured=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sssssii', $title, $event_date, $event_time, $venue, $description, $featured, $id);
      }
      mysqli_stmt_execute($stmt);
      $_SESSION['flash'] = 'Event updated.';
    }
  }
  header('Location: events.php');
  exit;
}

$editRow = null;
if (isset($_GET['edit'])) {
  $stmt = mysqli_prepare($conn, "SELECT * FROM events WHERE id = ?");
  mysqli_stmt_bind_param($stmt, 'i', $_GET['edit']);
  mysqli_stmt_execute($stmt);
  $editRow = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$rows = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date ASC");

include __DIR__ . '/_chrome_top.php';
?>
<h1>Events</h1>
<p class="subtitle">Shown on the public Events page and homepage, ordered by date.</p>

<div class="panel">
  <div class="panel-head">
    <h2>All Events</h2>
    <button type="button" class="btn" onclick="document.getElementById('eventModal').showModal()">+ Add Event</button>
  </div>
  <table class="list">
    <tr><th></th><th>Title</th><th>Date</th><th>Venue</th><th></th></tr>
    <?php while ($row = mysqli_fetch_assoc($rows)): ?>
    <tr>
      <td><?php if ($row['image']): ?><img class="thumb" src="../<?= htmlspecialchars($row['image']) ?>" alt=""><?php endif; ?></td>
      <td><?= htmlspecialchars($row['title']) ?> <?php if ($row['featured']): ?><span class="badge">Featured</span><?php endif; ?></td>
      <td><?= htmlspecialchars(date('d M Y', strtotime($row['event_date']))) ?></td>
      <td><?= htmlspecialchars($row['venue'] ?? '') ?></td>
      <td class="actions">
        <a href="events.php?edit=<?= (int) $row['id'] ?>">Edit</a>
        <form method="post" onsubmit="return confirm('Delete this event?');" style="display:inline;">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
          <button type="submit" class="delete" style="background:none;border:none;padding:0;font:inherit;cursor:pointer;">Delete</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

<dialog id="eventModal" class="modal">
  <div class="modal-head">
    <h2><?= $editRow ? 'Edit Event' : 'Add Event' ?></h2>
    <button type="button" class="modal-close" onclick="document.getElementById('eventModal').close()" aria-label="Close">&times;</button>
  </div>
  <form class="stack" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $editRow ? 'update' : 'create' ?>">
    <?php if ($editRow): ?><input type="hidden" name="id" value="<?= (int) $editRow['id'] ?>"><?php endif; ?>

    <div class="field">
      <label for="title">Title</label>
      <input id="title" name="title" required value="<?= htmlspecialchars($editRow['title'] ?? '') ?>">
    </div>
    <div class="row-2">
      <div class="field">
        <label for="event_date">Date</label>
        <input id="event_date" name="event_date" type="date" required value="<?= htmlspecialchars($editRow['event_date'] ?? '') ?>">
      </div>
      <div class="field">
        <label for="event_time">Time (optional)</label>
        <input id="event_time" name="event_time" placeholder="e.g. 10:00 – 13:00" value="<?= htmlspecialchars($editRow['event_time'] ?? '') ?>">
      </div>
    </div>
    <div class="field">
      <label for="venue">Venue</label>
      <input id="venue" name="venue" value="<?= htmlspecialchars($editRow['venue'] ?? '') ?>">
    </div>
    <div class="field">
      <label for="description">Description (optional — shown for featured events)</label>
      <textarea id="description" name="description"><?= htmlspecialchars($editRow['description'] ?? '') ?></textarea>
    </div>
    <div class="field">
      <label for="image">Cover image (optional)</label>
      <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp">
      <?php if (!empty($editRow['image'])): ?><img class="thumb" src="../<?= htmlspecialchars($editRow['image']) ?>" alt=""><?php endif; ?>
    </div>
    <div class="field" style="flex-direction:row;align-items:center;gap:8px;">
      <input id="featured" name="featured" type="checkbox" style="width:auto;" <?= !empty($editRow['featured']) ? 'checked' : '' ?>>
      <label for="featured" style="margin:0;">Feature this event (large card at top of Events page)</label>
    </div>

    <div style="display:flex;gap:10px;">
      <button class="btn" type="submit"><?= $editRow ? 'Save Changes' : 'Add Event' ?></button>
      <button type="button" class="btn secondary" onclick="window.location.href='events.php'">Cancel</button>
    </div>
  </form>
</dialog>

<?php if ($editRow): ?>
<script>document.getElementById('eventModal').showModal();</script>
<?php endif; ?>

<?php include __DIR__ . '/_chrome_bottom.php'; ?>
