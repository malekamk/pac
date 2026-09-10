<?php
require __DIR__ . '/config.php';
$conn = db();
$events = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date ASC");
$events = $events ? mysqli_fetch_all($events, MYSQLI_ASSOC) : [];
$featured = null;
foreach ($events as $e) { if ($e['featured']) { $featured = $e; break; } }
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Events | PAC Johannesburg Region</title>
<meta name="description" content="Upcoming PAC Johannesburg Region events and campaign activities ahead of the 4 November 2026 Local Government Elections.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://pacjhb.org.za/events.php">
<meta property="og:type" content="website">
<meta property="og:site_name" content="PAC Johannesburg Region">
<meta property="og:title" content="Events | PAC Johannesburg Region">
<meta property="og:description" content="Upcoming PAC Johannesburg Region events and campaign activities ahead of the 4 November 2026 Local Government Elections.">
<meta property="og:url" content="https://pacjhb.org.za/events.php">
<meta property="og:image" content="https://pacjhb.org.za/assets/img/thami.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Events | PAC Johannesburg Region">
<meta name="twitter:description" content="Upcoming PAC Johannesburg Region events and campaign activities ahead of the 4 November 2026 Local Government Elections.">
<meta name="twitter:image" content="https://pacjhb.org.za/assets/img/thami.jpg">
<link rel="icon" href="assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" type="image/png">
<link rel="stylesheet" href="css/style.css">
</head>
<body data-page="events">

<?php include 'partials/header.php'; ?>

<main>
  <section class="page-hero">
    <div class="container">
      <p class="breadcrumb"><a href="index.php">Home</a> / Events</p>
      <h1>Events</h1>
      <p style="margin-top:14px;color:var(--gold);font-weight:700;" data-election-countdown></p>
    </div>
  </section>

  <section class="section">
    <div class="container" style="max-width:820px;">

      <?php if ($featured): ?>
      <div class="featured-event">
        <?php if ($featured['image']): ?><img src="<?= htmlspecialchars($featured['image']) ?>" alt="<?= htmlspecialchars($featured['title']) ?>"><?php endif; ?>
        <div>
          <span class="tag">Featured Event</span>
          <h2 style="margin-bottom:6px;"><?= htmlspecialchars($featured['title']) ?></h2>
          <?php if ($featured['description']): ?><p><?= nl2br(htmlspecialchars($featured['description'])) ?></p><?php endif; ?>
          <p><strong>Date:</strong> <?= htmlspecialchars(date('j F Y', strtotime($featured['event_date']))) ?>
          <?php if ($featured['event_time']): ?> &middot; <strong>Time:</strong> <?= htmlspecialchars($featured['event_time']) ?><?php endif; ?><br>
          <?php if ($featured['venue']): ?><strong>Venue:</strong> <?= htmlspecialchars($featured['venue']) ?><?php endif; ?></p>
        </div>
      </div>
      <?php endif; ?>

      <p class="form-note" style="margin-bottom:24px;">Regional programme dates below are indicative campaign-calendar entries for the Johannesburg Region; confirm venue and time changes with the head office before attending.</p>
      <div class="events-list">
        <?php foreach ($events as $row): ?>
        <div class="event-row">
          <div class="date-badge">
            <div class="d"><?= htmlspecialchars(date('d', strtotime($row['event_date']))) ?></div>
            <div class="m"><?= htmlspecialchars(date('M', strtotime($row['event_date']))) ?></div>
          </div>
          <div class="event-info">
            <h4><?= htmlspecialchars($row['title']) ?></h4>
            <span class="when">
              <?= htmlspecialchars($row['event_time'] ?? '') ?>
              <?= ($row['event_time'] && $row['venue']) ? ' &middot; ' : '' ?>
              <?= htmlspecialchars($row['venue'] ?? '') ?>
            </span>
          </div>
        </div>
        <?php endforeach; ?>
        <?php if (!$events): ?><p class="form-note">No events scheduled right now — check back soon.</p><?php endif; ?>
      </div>
    </div>
  </section>

  <section class="join-banner">
    <div class="container join-inner">
      <div><h2>Become Part of the Movement</h2><p>Your future is in your hands. Join PAC Johannesburg today.</p></div>
      <a href="membership.php" class="btn btn-gold">Join PAC Today &rarr;</a>
    </div>
  </section>
</main>

<?php include 'partials/footer.php'; ?>
<script src="js/include.js"></script>
<script src="js/main.js"></script>
</body>
</html>
