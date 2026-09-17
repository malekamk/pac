<?php
require __DIR__ . '/_auth.php';
$pageTitle = 'Dashboard';
$conn = db();

function count_rows($conn, $table) {
  $res = mysqli_query($conn, "SELECT COUNT(*) AS c FROM `$table`");
  return (int) mysqli_fetch_assoc($res)['c'];
}

$eventsCount = count_rows($conn, 'events');
$announcementsCount = count_rows($conn, 'announcements');
$candidatesCount = count_rows($conn, 'candidates');
$usersCount = count_rows($conn, 'admins');
$galleryCount = count_rows($conn, 'gallery_images');

$nextEvent = mysqli_fetch_assoc(mysqli_query($conn,
  "SELECT title, event_date FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 1"));
$latestAnnouncement = mysqli_fetch_assoc(mysqli_query($conn,
  "SELECT title FROM announcements ORDER BY published_at DESC, id DESC LIMIT 1"));
$latestCandidate = mysqli_fetch_assoc(mysqli_query($conn,
  "SELECT name, ward FROM candidates ORDER BY id DESC LIMIT 1"));

$activity = mysqli_query($conn, "
  (SELECT 'Event' AS kind, title AS label, created_at FROM events)
  UNION ALL
  (SELECT 'Announcement' AS kind, title AS label, created_at FROM announcements)
  UNION ALL
  (SELECT 'Candidate' AS kind, CONCAT(name, IF(ward IS NOT NULL, CONCAT(' — Ward ', ward), '')) AS label, created_at FROM candidates)
  UNION ALL
  (SELECT 'Team' AS kind, CONCAT(name, ' joined') AS label, created_at FROM admins)
  ORDER BY created_at DESC LIMIT 6
");

include __DIR__ . '/_chrome_top.php';
?>
<section class="hero-panel">
  <img class="hero-panel-emblem" src="/assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" alt="">
  <div class="hero-panel-content">
    <span class="hero-panel-eyebrow">Johannesburg Region &middot; Command Centre</span>
    <h1>Welcome back, <?= htmlspecialchars(explode(' ', $_SESSION['admin_name'])[0]) ?></h1>
    <p><?= htmlspecialchars($_SESSION['admin_name']) ?><?= !empty($_SESSION['admin_role']) ? ' &middot; ' . htmlspecialchars(ucfirst($_SESSION['admin_role'])) : '' ?> — everything you publish here goes live on pacjhb.org.za immediately.</p>
    <p class="hero-panel-countdown" data-election-countdown>Loading election countdown&hellip;</p>
  </div>
</section>

<div class="quick-actions" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:22px;">
  <a href="/admin/events" class="pill-btn primary"><?= admin_icon('plus') ?> Add Event</a>
  <a href="/admin/announcements" class="pill-btn primary"><?= admin_icon('plus') ?> Add Announcement</a>
  <a href="/admin/candidates" class="pill-btn primary"><?= admin_icon('plus') ?> Add Candidate</a>
  <a href="/admin/users" class="pill-btn"><?= admin_icon('plus') ?> Add Team Member</a>
</div>

<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Events</span><span class="kpi-icon"><?= admin_icon('calendar') ?></span></div>
    <div class="kpi-value"><?= $eventsCount ?></div>
    <div class="kpi-caption"><?= $nextEvent ? 'Next: ' . htmlspecialchars($nextEvent['title']) . ' — ' . htmlspecialchars(date('d M', strtotime($nextEvent['event_date']))) : 'Nothing scheduled' ?></div>
    <a href="/admin/events" style="display:block;margin-top:8px;font-size:.78rem;font-weight:700;">Manage &rarr;</a>
  </div>
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Announcements</span><span class="kpi-icon"><?= admin_icon('megaphone') ?></span></div>
    <div class="kpi-value"><?= $announcementsCount ?></div>
    <div class="kpi-caption"><?= $latestAnnouncement ? 'Latest: ' . htmlspecialchars($latestAnnouncement['title']) : 'None yet' ?></div>
    <a href="/admin/announcements" style="display:block;margin-top:8px;font-size:.78rem;font-weight:700;">Manage &rarr;</a>
  </div>
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Ward Candidates</span><span class="kpi-icon"><?= admin_icon('users') ?></span></div>
    <div class="kpi-value"><?= $candidatesCount ?></div>
    <div class="kpi-caption"><?= $latestCandidate ? 'Newest: ' . htmlspecialchars($latestCandidate['name']) . ($latestCandidate['ward'] ? ' (Ward ' . htmlspecialchars($latestCandidate['ward']) . ')' : '') : 'None yet' ?></div>
    <a href="/admin/candidates" style="display:block;margin-top:8px;font-size:.78rem;font-weight:700;">Manage &rarr;</a>
  </div>
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Gallery Photos</span><span class="kpi-icon"><?= admin_icon('images') ?></span></div>
    <div class="kpi-value"><?= $galleryCount ?></div>
    <div class="kpi-caption">Shown on the Gallery page</div>
    <a href="/admin/gallery" style="display:block;margin-top:8px;font-size:.78rem;font-weight:700;">Manage &rarr;</a>
  </div>
  <div class="kpi-card">
    <div class="kpi-top"><span class="kpi-label">Team Accounts</span><span class="kpi-icon"><?= admin_icon('user-circle') ?></span></div>
    <div class="kpi-value"><?= $usersCount ?></div>
    <div class="kpi-caption">People who can log in here</div>
    <a href="/admin/users" style="display:block;margin-top:8px;font-size:.78rem;font-weight:700;">Manage &rarr;</a>
  </div>
</div>

<div class="panel">
  <h2>Recent Activity</h2>
  <ul class="activity-feed">
    <?php while ($row = mysqli_fetch_assoc($activity)): ?>
    <li>
      <span class="activity-kind activity-kind-<?= strtolower($row['kind']) ?>"><?= htmlspecialchars($row['kind']) ?></span>
      <span class="activity-label"><?= htmlspecialchars($row['label']) ?></span>
      <span class="activity-time"><?= htmlspecialchars(date('d M, H:i', strtotime($row['created_at']))) ?></span>
    </li>
    <?php endwhile; ?>
  </ul>
</div>

<div class="panel">
  <h2>What changes where</h2>
  <p class="subtitle" style="margin-bottom:0;">
    Events you add here appear on the public <strong>Events</strong> page and the homepage's Upcoming Events list, ordered by date.<br>
    Announcements appear in the homepage Announcements banner and the News page (most recent first).<br>
    Candidates appear on the public <strong>Candidates</strong> page and the homepage ward candidates strip.
  </p>
</div>
<?php include __DIR__ . '/_chrome_bottom.php'; ?>
<script>
(function(){
  var el = document.querySelector('[data-election-countdown]');
  if (!el) return;
  var target = new Date('2026-11-04T07:00:00+02:00').getTime();
  function render(){
    var diff = target - Date.now();
    if (diff <= 0) { el.textContent = 'Election day is here — go vote!'; return; }
    var days = Math.floor(diff / (1000*60*60*24));
    el.textContent = days + ' days to the 2026 Local Government Elections';
  }
  render();
  setInterval(render, 60000);
})();
</script>
