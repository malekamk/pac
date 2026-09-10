<?php
require __DIR__ . '/_auth.php';
$pageTitle = 'Dashboard';

function count_rows($conn, $table) {
  $res = mysqli_query($conn, "SELECT COUNT(*) AS c FROM `$table`");
  return (int) mysqli_fetch_assoc($res)['c'];
}
$conn = db();
$eventsCount = count_rows($conn, 'events');
$announcementsCount = count_rows($conn, 'announcements');
$candidatesCount = count_rows($conn, 'candidates');
$usersCount = count_rows($conn, 'admins');

include __DIR__ . '/_chrome_top.php';
?>
<h1>Welcome back, <?= htmlspecialchars($_SESSION['admin_name']) ?></h1>
<p class="subtitle">Manage what shows on the public PAC Johannesburg site.</p>

<div class="stat-row">
  <div class="stat-card">
    <div class="n"><?= $eventsCount ?></div>
    <div class="l">Events</div>
    <a href="events.php">Manage &rarr;</a>
  </div>
  <div class="stat-card">
    <div class="n"><?= $announcementsCount ?></div>
    <div class="l">Announcements</div>
    <a href="announcements.php">Manage &rarr;</a>
  </div>
  <div class="stat-card">
    <div class="n"><?= $candidatesCount ?></div>
    <div class="l">Candidates</div>
    <a href="candidates.php">Manage &rarr;</a>
  </div>
  <div class="stat-card">
    <div class="n"><?= $usersCount ?></div>
    <div class="l">Admin Users</div>
    <a href="users.php">Manage &rarr;</a>
  </div>
</div>

<div class="panel">
  <h2>What changes where</h2>
  <p class="subtitle" style="margin-bottom:0;">
    Events you add here appear on the public <strong>Events</strong> page and the homepage's Upcoming Events list, ordered by date.<br>
    Announcements appear in the homepage Announcements banner (most recent first).<br>
    Candidates appear on the public <strong>Candidates</strong> page and the homepage ward candidates strip.
  </p>
</div>
<?php include __DIR__ . '/_chrome_bottom.php'; ?>
