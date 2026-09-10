<?php
require __DIR__ . '/config.php';
$conn = db();
$latestAnnouncement = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM announcements ORDER BY published_at DESC, id DESC LIMIT 1"));
$homeCandidates = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM candidates ORDER BY id ASC LIMIT 3"), MYSQLI_ASSOC);
$homeEvents = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM events ORDER BY event_date ASC LIMIT 4"), MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PAC Johannesburg Region | Pan Africanist Congress of Azania</title>
<meta name="description" content="Official site of the Pan Africanist Congress of Azania, Johannesburg Region. Serve, Suffer, Sacrifice — land, dignity and economic justice for Azania.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://pacjhb.org.za/">
<meta property="og:type" content="website">
<meta property="og:site_name" content="PAC Johannesburg Region">
<meta property="og:locale" content="en_ZA">
<meta property="og:title" content="PAC Johannesburg Region | Pan Africanist Congress of Azania">
<meta property="og:description" content="Serve, Suffer, Sacrifice — land, dignity and economic justice for Azania. PAC Johannesburg Region, contesting the 2026 Local Government Elections.">
<meta property="og:url" content="https://pacjhb.org.za/">
<meta property="og:image" content="https://pacjhb.org.za/assets/img/pac-crowd-flag-banner.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="PAC Johannesburg Region | Pan Africanist Congress of Azania">
<meta name="twitter:description" content="Serve, Suffer, Sacrifice — land, dignity and economic justice for Azania.">
<meta name="twitter:image" content="https://pacjhb.org.za/assets/img/pac-crowd-flag-banner.jpg">
<link rel="icon" href="assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" type="image/png">
<link rel="stylesheet" href="css/style.css">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Pan Africanist Congress of Azania — Johannesburg Region",
  "alternateName": "PAC Johannesburg",
  "url": "https://pacjhb.org.za/",
  "logo": "https://pacjhb.org.za/assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png",
  "sameAs": [
    "https://www.pacofazania.org.za/",
    "https://www.facebook.com/MyPAConline/",
    "https://x.com/mypaconline"
  ],
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Khotso House, 7th Floor, Office 725–731, 62 Marshal Street",
    "addressLocality": "Johannesburg",
    "addressRegion": "Gauteng",
    "addressCountry": "ZA"
  },
  "email": "admin@pacofazania.org.za",
  "telephone": "+27614815677"
}
</script>
</head>
<body data-page="home">

<?php include 'partials/header.php'; ?>

<main>
  <section class="hero">
    <div class="container hero-inner">
      <h1>Pan Africanist<br>Congress of Azania<span class="accent">Johannesburg Region</span></h1>
      <div class="hero-divider"></div>
      <p class="tagline">Serve &bull; Suffer &bull; Sacrifice</p>
      <div class="hero-ctas">
        <a href="membership.php" class="btn btn-green">Join PAC &rarr;</a>
        <a href="programmes.php" class="btn btn-outline">Our Programmes &rarr;</a>
      </div>
      <p style="margin-top:26px;color:var(--gray-500);font-size:.82rem;letter-spacing:.5px;" data-election-countdown></p>
    </div>
  </section>

  <section class="section">
    <div class="container who-grid">
      <div>
        <span class="eyebrow">Who We Are</span>
        <h2>The PAC Continues<br>the Struggle</h2>
        <p>The Pan Africanist Congress of Azania was founded on 6 April 1959 at the Orlando Community Hall in Soweto by Robert Mangaliso Sobukwe, breaking away from the ANC over its Africanist conviction that the land and its wealth belong to the African people. The PAC led the 1960 Anti-Pass Campaign, was banned after the Sharpeville massacre, waged the armed struggle through APLA in exile, and returned to legal politics in 1990.</p>
        <p>In Johannesburg, our Region carries that history forward &mdash; organising communities around land restoration, dignity, accountability and dependable local governance ahead of the 4 November 2026 Local Government Elections, where Thami ka Plaatjie is the PAC&rsquo;s candidate for Executive Mayor of Johannesburg.</p>
      </div>
      <div class="who-photo">
        <img src="assets/img/sobukwe-leballo.jpg" alt="Robert Sobukwe with Potlako Leballo, before 21 March 1960">
        <div class="cap">Robert Sobukwe (left) with Potlako Leballo, before the 21 March 1960 Anti-Pass Campaign. Public domain / News24.</div>
      </div>
    </div>
  </section>

  <section class="section section-tight">
    <div class="container">
      <?php if ($latestAnnouncement): ?>
      <span class="eyebrow">Announcements</span>
      <div class="announcement-banner">
        <?php if ($latestAnnouncement['image']): ?><img src="<?= htmlspecialchars($latestAnnouncement['image']) ?>" alt="<?= htmlspecialchars($latestAnnouncement['title']) ?>"><?php endif; ?>
        <div>
          <span class="tag"><?= htmlspecialchars($latestAnnouncement['tag']) ?></span>
          <h2><?= htmlspecialchars($latestAnnouncement['title']) ?></h2>
          <?php if ($latestAnnouncement['body']): ?><p><?= nl2br(htmlspecialchars($latestAnnouncement['body'])) ?></p><?php endif; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <section class="section section-tight" style="background:var(--near-black);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="container">
      <div class="section-head">
        <h2>Meet Your Ward Candidates</h2>
        <a href="candidates.php" class="view-all">View All &rarr;</a>
      </div>
      <div class="candidates-grid">
        <?php foreach ($homeCandidates as $c): ?>
        <article class="candidate-card">
          <?php if ($c['image']): ?><img class="poster" src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>, PAC Councillor Candidate for Ward <?= htmlspecialchars($c['ward']) ?>"><?php endif; ?>
          <div class="cap"><?php if ($c['ward']): ?><div class="ward">Ward <?= htmlspecialchars($c['ward']) ?></div><?php endif; ?><h3><?= htmlspecialchars($c['name']) ?></h3></div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section section-tight" style="background:var(--green-950);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="container">
      <div class="section-head">
        <h2>Latest News &amp; Statements</h2>
        <a href="news.php" class="view-all">View All &rarr;</a>
      </div>
      <div class="news-grid">
        <article class="card news-card">
          <div class="thumb"><img src="assets/img/founding-members-1957.jpg" alt="PAC statement"></div>
          <div class="body">
            <span class="meta">03 Aug 2026 &middot; Statement</span>
            <h3>PAC Names Thami ka Plaatjie as Johannesburg Mayoral Candidate</h3>
            <p>The party unveiled the historian and former Secretary-General as its candidate for Executive Mayor, alongside candidates for Ekurhuleni, Emfuleni and Sedibeng.</p>
            <a href="news.php" class="readmore">Read More &rarr;</a>
          </div>
        </article>
        <article class="card news-card">
          <div class="thumb"><img src="assets/img/rsa-1994-pac-map.png" alt="PAC election focus"></div>
          <div class="body">
            <span class="meta">2026 &middot; Statement</span>
            <h3>Ending Maladministration Is Key Focus Ahead of 2026 Elections</h3>
            <p>President Mzwanele Nyhontso says the PAC is mobilising communities as agents of change to end maladministration, poor service delivery and corruption in local councils.</p>
            <a href="news.php" class="readmore">Read More &rarr;</a>
          </div>
        </article>
        <article class="card news-card">
          <div class="thumb"><img src="assets/img/sobukwe-leballo.jpg" alt="PAC youth mobilisation"></div>
          <div class="body">
            <span class="meta">2026 &middot; News</span>
            <h3>PAYCO Leads Ground Mobilisation for the Local Elections</h3>
            <p>The Pan Africanist Youth Congress of Azania places young people at the centre of community mobilisation ahead of registration weekends and the 4 November poll.</p>
            <a href="news.php" class="readmore">Read More &rarr;</a>
          </div>
        </article>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-head">
        <h2>Upcoming Events</h2>
        <a href="events.php" class="view-all">View All &rarr;</a>
      </div>
      <div class="events-list">
        <?php foreach ($homeEvents as $row): ?>
        <div class="event-row">
          <?php if ($row['image']): ?><div class="thumb"><img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>"></div><?php endif; ?>
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
      </div>
    </div>
  </section>

  <section class="section section-tight">
    <div class="container">
      <div class="leadership-panel">
        <div class="leadership-head">
          <span class="eyebrow-green">Our Leadership</span>
          <a href="leadership.php" class="view-all">View All &rarr;</a>
        </div>
        <div class="leaders-row">
          <div class="leader-item">
            <div class="avatar"><img src="assets/img/thami.jpg" alt="Thami ka Plaatjie"></div>
            <div class="info"><h3>Thami ka Plaatjie</h3><div class="role">JHB Mayoral Candidate</div></div>
          </div>
          <div class="leader-item">
            <div class="avatar"><img src="assets/img/nyhontso-sabc.png" alt="Mzwanele Nyhontso"></div>
            <div class="info"><h3>Mzwanele Nyhontso</h3><div class="role">President</div></div>
          </div>
          <div class="leader-item">
            <div class="avatar"><img src="assets/img/apa-pooe.jpg" alt="Ntsiri Apa Pooe"></div>
            <div class="info"><h3>Ntsiri &ldquo;Apa&rdquo; Pooe</h3><div class="role">Secretary-General</div></div>
          </div>
          <div class="leader-item">
            <div class="avatar">JS</div>
            <div class="info"><h3>Jackie Seroke</h3><div class="role">Deputy President</div></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="join-banner">
    <div class="container join-inner">
      <div>
        <h2>Become Part of the Movement</h2>
        <p>Your future is in your hands. Join PAC Johannesburg today.</p>
      </div>
      <a href="membership.php" class="btn btn-gold">Join PAC Today &rarr;</a>
    </div>
  </section>
</main>

<?php include 'partials/footer.php'; ?>

<script src="js/include.js"></script>
<script src="js/main.js"></script>
</body>
</html>
