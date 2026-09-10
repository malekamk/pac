<?php
require __DIR__ . '/config.php';
$conn = db();
$heroSlides = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM hero_slides ORDER BY sort_order ASC, id ASC"), MYSQLI_ASSOC);
if (!$heroSlides) {
  $heroSlides = [['image' => 'assets/img/pac-crowd-flag-banner.jpg', 'alt_text' => 'PAC Johannesburg Region']];
}
$newsItems = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM announcements ORDER BY published_at DESC, id DESC LIMIT 4"), MYSQLI_ASSOC);
$featuredNews = $newsItems[0] ?? null;
$secondaryNews = array_slice($newsItems, 1);
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
  "email": "admin@pacjhb.org.za",
  "telephone": "+27614815677"
}
</script>
</head>
<body data-page="home">

<?php include 'partials/header.php'; ?>

<main>
  <section class="hero">
    <div class="container">
      <div class="hero-shell" data-hero-carousel>
        <div class="hero-slides">
          <?php foreach ($heroSlides as $i => $slide): ?>
          <div class="hero-slide<?= $i === 0 ? ' active' : '' ?>" style="background-image:url('<?= htmlspecialchars($slide['image']) ?>')" role="img" aria-label="<?= htmlspecialchars($slide['alt_text'] ?: 'PAC Johannesburg Region') ?>"></div>
          <?php endforeach; ?>
        </div>
        <div class="hero-overlay"></div>
        <?php if (count($heroSlides) > 1): ?>
        <button type="button" class="hero-arrow hero-arrow-prev" data-hero-prev aria-label="Previous slide">&lsaquo;</button>
        <button type="button" class="hero-arrow hero-arrow-next" data-hero-next aria-label="Next slide">&rsaquo;</button>
        <div class="hero-dots">
          <?php foreach ($heroSlides as $i => $slide): ?>
          <button type="button" class="hero-dot<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>" aria-label="Show slide <?= $i + 1 ?>"></button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
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

  <?php if ($featuredNews): ?>
  <section class="section section-tight">
    <div class="container">
      <div class="section-head">
        <span class="dot"></span>
        <h2>Latest News</h2>
        <span class="rule"></span>
        <a href="news" class="pill-btn">View All &rarr;</a>
      </div>
      <div class="feature-split">
        <div class="feature-main">
          <?php if ($featuredNews['image']): ?><div class="thumb"><img src="<?= htmlspecialchars($featuredNews['image']) ?>" alt="<?= htmlspecialchars($featuredNews['title']) ?>"></div><?php endif; ?>
          <div class="feature-main-body">
            <h3><?= htmlspecialchars($featuredNews['title']) ?></h3>
            <?php if ($featuredNews['published_at']): ?><p class="published"><strong>Published:</strong> <span class="value"><?= htmlspecialchars(date('d F Y', strtotime($featuredNews['published_at']))) ?></span></p><?php endif; ?>
            <?php if ($featuredNews['body']): ?><p class="excerpt"><?= htmlspecialchars(mb_strimwidth($featuredNews['body'], 0, 160, '…')) ?></p><?php endif; ?>
            <span class="pill-badge"><?= htmlspecialchars($featuredNews['tag']) ?></span>
          </div>
        </div>
        <?php if ($secondaryNews): ?>
        <div class="feature-list">
          <?php foreach ($secondaryNews as $n): ?>
          <div class="feature-list-row">
            <?php if ($n['image']): ?><div class="thumb"><img src="<?= htmlspecialchars($n['image']) ?>" alt=""></div><?php endif; ?>
            <div>
              <div class="meta"><?= htmlspecialchars($n['tag']) ?><?= $n['published_at'] ? ' &middot; ' . htmlspecialchars(date('d M', strtotime($n['published_at']))) : '' ?></div>
              <h4><?= htmlspecialchars($n['title']) ?></h4>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <section class="section section-tight" style="background:var(--near-black);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="container">
      <div class="section-head">
        <span class="dot"></span>
        <h2>Meet Your Ward Candidates</h2>
        <span class="rule"></span>
        <a href="candidates" class="pill-btn">View All &rarr;</a>
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


  <section class="section">
    <div class="container">
      <div class="section-head">
        <span class="dot"></span>
        <h2>Upcoming Events</h2>
        <span class="rule"></span>
        <a href="events" class="pill-btn">View All &rarr;</a>
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

</main>

<?php include 'partials/footer.php'; ?>

<script src="js/include.js"></script>
<script src="js/main.js"></script>
</body>
</html>
