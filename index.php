<?php
require __DIR__ . '/config.php';
$conn = db();
$latestAnnouncement = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM announcements ORDER BY published_at DESC, id DESC LIMIT 1"));
$homeEvents = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM events ORDER BY event_date ASC LIMIT 3"), MYSQLI_ASSOC);
$candidateCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM candidates"))['c'];
$upcomingCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM events WHERE event_date >= CURDATE()"))['c'];
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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Pan Africanist Congress of Azania — Johannesburg Region",
  "alternateName": "PAC Johannesburg",
  "url": "https://pacjhb.org.za/",
  "logo": "https://pacjhb.org.za/assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png",
  "sameAs": ["https://www.pacofazania.org.za/", "https://www.facebook.com/MyPAConline/", "https://x.com/mypaconline"],
  "address": {"@type": "PostalAddress", "streetAddress": "Khotso House, 7th Floor, Office 725–731, 62 Marshal Street", "addressLocality": "Johannesburg", "addressRegion": "Gauteng", "addressCountry": "ZA"},
  "email": "admin@pacofazania.org.za",
  "telephone": "+27614815677"
}
</script>
</head>
<body data-page="home">

<?php include 'partials/header.php'; ?>

<main>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-media"><img src="assets/img/pac-crowd-flag-banner.jpg" alt="PAC supporters at a rally, flag raised"></div>
    <div class="hero-content">
      <div class="hero-eyebrow">Pan Africanist Congress of Azania — Johannesburg Region</div>
      <h1>A Region of Organisation,<br>Service and Community.</h1>
      <p class="hero-tagline">Serve &bull; Suffer &bull; Sacrifice — building land, dignity and accountable local government for Johannesburg ahead of the 4 November 2026 elections.</p>
      <div class="hero-ctas">
        <a href="about" class="btn btn-gold">Explore the Region &rarr;</a>
        <a href="membership" class="btn btn-outline">Membership &rarr;</a>
      </div>
      <div class="hero-footnote">
        <span class="yr">1959</span>
        <span>The Movement&rsquo;s Roots — Orlando, Soweto</span>
      </div>
    </div>
  </section>

  <!-- INTRODUCTION -->
  <section class="section">
    <div class="container">
      <div class="split">
        <div class="lead-col">
          <span class="label">Who We Are</span>
          <h2>The struggle continues<br>in Johannesburg.</h2>
          <p class="lede">The Pan Africanist Congress of Azania was founded on 6 April 1959 at the Orlando Community Hall in Soweto by Robert Mangaliso Sobukwe, breaking from the ANC over its conviction that the land and its wealth belong to the African people.</p>
          <p>The PAC led the 1960 Anti-Pass Campaign, was banned after the Sharpeville massacre, waged the armed struggle through APLA in exile, and returned to legal politics in 1990. In Johannesburg, the Region carries that history forward today — organising communities around land restoration, dignity and dependable local governance, with Thami ka Plaatjie standing as the PAC&rsquo;s candidate for Executive Mayor of Johannesburg.</p>
          <a href="about" class="view-all">Read the full history &rarr;</a>
        </div>
        <div class="split-media">
          <img src="assets/img/sobukwe-leballo.jpg" alt="Robert Sobukwe with Potlako Leballo, before 21 March 1960">
          <p class="cap">Robert Sobukwe (left) with Potlako Leballo, before the 21 March 1960 Anti-Pass Campaign. Public domain, via Wikimedia Commons.</p>
        </div>
      </div>

      <div class="stat-row">
        <div class="stat"><div class="num">1959</div><div class="lbl">Founded</div></div>
        <div class="stat"><div class="num">04 Nov</div><div class="lbl">2026 Election Day</div></div>
        <div class="stat"><div class="num"><?= (int) $candidateCount ?></div><div class="lbl">Ward Candidates</div></div>
        <div class="stat"><div class="num"><?= (int) $upcomingCount ?></div><div class="lbl">Upcoming Events</div></div>
      </div>
    </div>
  </section>

  <!-- HISTORY TIMELINE -->
  <section class="section-tight section-raised">
    <div class="container">
      <div class="section-head">
        <div class="heading">
          <span class="label on-light">History</span>
          <h2>Six decades of struggle.</h2>
        </div>
      </div>
      <div class="timeline">
        <div class="timeline-item">
          <div class="timeline-year">1959</div>
          <div><h4>PAC Founded</h4><p>Launched at Orlando Community Hall, Soweto, under founding president Robert Mangaliso Sobukwe, on an Africanist platform of &ldquo;Africa for the Africans.&rdquo;</p></div>
        </div>
        <div class="timeline-item">
          <div class="timeline-year">1960</div>
          <div><h4>Anti-Pass Campaign &amp; Sharpeville</h4><p>The PAC launches the Anti-Pass Campaign. In Sharpeville, police open fire on unarmed protesters, killing 69 people.</p></div>
        </div>
        <div class="timeline-item">
          <div class="timeline-year">1961</div>
          <div><h4>Banned</h4><p>The apartheid government bans the PAC. Sobukwe and Leballo are arrested; thousands of members are detained or forced into exile.</p></div>
        </div>
        <div class="timeline-item">
          <div class="timeline-year">1976&ndash;1990</div>
          <div><h4>Liberation Era</h4><p>The Azanian People&rsquo;s Liberation Army continues the armed struggle from exile; the PAC is unbanned in 1990 as apartheid negotiations begin.</p></div>
        </div>
        <div class="timeline-item">
          <div class="timeline-year">1994</div>
          <div><h4>Democratic Transition</h4><p>In South Africa&rsquo;s first democratic election, the PAC wins 5 seats in the National Assembly.</p></div>
        </div>
        <div class="timeline-item">
          <div class="timeline-year">2026</div>
          <div><h4>Present Day</h4><p>Thami ka Plaatjie stands as the PAC&rsquo;s candidate for Executive Mayor of Johannesburg in the 4 November Local Government Elections.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- LATEST NEWS -->
  <section class="section">
    <div class="container">
      <div class="section-head">
        <div class="heading">
          <span class="label on-light">Newsroom</span>
          <h2>Latest from the Region.</h2>
        </div>
        <a href="news" class="view-all">All News &amp; Statements &rarr;</a>
      </div>
      <div class="news-editorial">
        <article class="news-featured">
          <?php if ($latestAnnouncement && $latestAnnouncement['image']): ?>
          <img src="<?= htmlspecialchars($latestAnnouncement['image']) ?>" alt="<?= htmlspecialchars($latestAnnouncement['title']) ?>">
          <?php endif; ?>
          <div class="meta-row"><span class="cat"><?= htmlspecialchars($latestAnnouncement['tag'] ?? 'Statement') ?></span><span class="dot"></span><span><?= $latestAnnouncement && $latestAnnouncement['published_at'] ? htmlspecialchars(date('d M Y', strtotime($latestAnnouncement['published_at']))) : '' ?></span></div>
          <h3><?= htmlspecialchars($latestAnnouncement['title'] ?? 'PAC Announces Thami ka Plaatjie as Johannesburg Mayoral Candidate') ?></h3>
          <p><?= $latestAnnouncement && $latestAnnouncement['body'] ? htmlspecialchars($latestAnnouncement['body']) : 'At a media briefing, the PAC confirmed former ANC member and historian Thami ka Plaatjie as its candidate for Executive Mayor of Johannesburg.' ?></p>
          <a href="news" class="view-all">Read More &rarr;</a>
        </article>
        <div class="news-list">
          <div class="news-list-item">
            <img src="assets/img/founding-members-1957.jpg" alt="">
            <div>
              <div class="meta-row"><span class="cat">Statement</span><span class="dot"></span><span>2026</span></div>
              <h4>Ending Maladministration Is Key Focus Ahead of 2026 Local Elections</h4>
            </div>
          </div>
          <div class="news-list-item">
            <img src="assets/img/nyhontso-sabc.png" alt="">
            <div>
              <div class="meta-row"><span class="cat">News</span><span class="dot"></span><span>Dec 2025</span></div>
              <h4>Mzwanele Nyhontso Re-elected PAC President Unopposed</h4>
            </div>
          </div>
          <div class="news-list-item">
            <img src="assets/img/sobukwe-leballo.jpg" alt="">
            <div>
              <div class="meta-row"><span class="cat">News</span><span class="dot"></span><span>2026</span></div>
              <h4>PAYCO Puts Youth at the Centre of Election Mobilisation</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- UPCOMING EVENTS -->
  <section class="section-tight section-raised">
    <div class="container">
      <div class="section-head">
        <div class="heading">
          <span class="label on-light">Calendar</span>
          <h2>Upcoming Events.</h2>
        </div>
        <a href="events" class="view-all">Full Calendar &rarr;</a>
      </div>
      <div class="events-index">
        <?php foreach ($homeEvents as $row): ?>
        <div class="event-row">
          <div class="event-date">
            <span class="d"><?= htmlspecialchars(date('d', strtotime($row['event_date']))) ?></span>
            <span class="m"><?= htmlspecialchars(date('M', strtotime($row['event_date']))) ?></span>
          </div>
          <div>
            <h4><?= htmlspecialchars($row['title']) ?></h4>
            <div class="event-meta">
              <?= htmlspecialchars($row['event_time'] ?? '') ?>
              <?= ($row['event_time'] && $row['venue']) ? ' — ' : '' ?>
              <?= htmlspecialchars($row['venue'] ?? '') ?>
            </div>
          </div>
          <a href="events" class="view-all">Details &rarr;</a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- PROGRAMMES -->
  <section class="section">
    <div class="container">
      <div class="section-head">
        <div class="heading">
          <span class="label on-light">Programmes</span>
          <h2>Turning organisation into community action.</h2>
        </div>
        <a href="programmes" class="view-all">All Programmes &rarr;</a>
      </div>
      <div class="numbered-grid">
        <div class="numbered-item">
          <span class="num">01</span>
          <h4>Land Restoration Campaign</h4>
          <p>Advancing the PAC&rsquo;s founding demand — Izwe Lethu, Our Land — through community land audits and advocacy for African ownership of Johannesburg&rsquo;s economy.</p>
        </div>
        <div class="numbered-item">
          <span class="num">02</span>
          <h4>Clean, Accountable Councils</h4>
          <p>Thami ka Plaatjie&rsquo;s mayoral campaign programme to end maladministration and restore dependable water, electricity, roads and refuse services.</p>
        </div>
        <div class="numbered-item">
          <span class="num">03</span>
          <h4>Pan Africanist Youth Congress</h4>
          <p>Placing young people at the centre of community mobilisation — skills, jobs and political education for the next generation.</p>
        </div>
        <div class="numbered-item">
          <span class="num">04</span>
          <h4>Pan Africanist Women&rsquo;s Organisation</h4>
          <p>Organising women in Johannesburg&rsquo;s branches around safety, economic empowerment and leadership representation.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- MEMBERSHIP CTA -->
  <section class="cta-band">
    <div class="cta-band-inner">
      <div>
        <h2>Be part of the organisation.</h2>
        <p>Your future is in your hands. Join PAC Johannesburg today.</p>
      </div>
      <a href="membership" class="btn btn-gold">Join PAC &rarr;</a>
    </div>
  </section>

</main>

<?php include 'partials/footer.php'; ?>

<script src="js/include.js"></script>
<script src="js/main.js"></script>
</body>
</html>
