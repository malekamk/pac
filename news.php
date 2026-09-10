<?php
require __DIR__ . '/config.php';
$conn = db();
$newsItems = mysqli_query($conn, "SELECT * FROM announcements ORDER BY published_at DESC, id DESC");
$newsItems = $newsItems ? mysqli_fetch_all($newsItems, MYSQLI_ASSOC) : [];
$featuredNews = $newsItems[0] ?? null;
$secondaryNews = array_slice($newsItems, 1, 3);
$restNews = array_slice($newsItems, 4);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>News &amp; Statements | PAC Johannesburg Region</title>
<meta name="description" content="Latest news, statements and press releases from the Pan Africanist Congress of Azania, Johannesburg Region — including Thami ka Plaatjie's mayoral candidacy and the 2026 Local Government Elections campaign.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://pacjhb.org.za/news">
<meta property="og:type" content="website">
<meta property="og:site_name" content="PAC Johannesburg Region">
<meta property="og:title" content="News &amp; Statements | PAC Johannesburg Region">
<meta property="og:description" content="Latest news, statements and press releases from the Pan Africanist Congress of Azania, Johannesburg Region.">
<meta property="og:url" content="https://pacjhb.org.za/news">
<meta property="og:image" content="https://pacjhb.org.za/assets/img/apa-pooe.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="News &amp; Statements | PAC Johannesburg Region">
<meta name="twitter:description" content="Latest news, statements and press releases from the Pan Africanist Congress of Azania, Johannesburg Region.">
<meta name="twitter:image" content="https://pacjhb.org.za/assets/img/apa-pooe.jpg">
<link rel="icon" href="assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" type="image/png">
<link rel="stylesheet" href="css/style.css">
</head>
<body data-page="news">

<?php include 'partials/header.php'; ?>

<main>
  <section class="page-hero">
    <div class="container">
      <p class="breadcrumb"><a href="/">Home</a> / News &amp; Statements</p>
      <h1>News &amp; Statements</h1>
    </div>
  </section>

  <?php if ($featuredNews): ?>
  <section class="section section-tight">
    <div class="container">
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

  <?php if ($restNews): ?>
  <section class="section">
    <div class="container">
      <div class="section-head">
        <span class="dot"></span>
        <h2>More News</h2>
        <span class="rule"></span>
      </div>
      <div class="news-grid">
        <?php foreach ($restNews as $item): ?>
        <article class="card news-card">
          <?php if ($item['image']): ?><div class="thumb"><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>"></div><?php endif; ?>
          <div class="body">
            <div class="meta"><?= htmlspecialchars($item['tag']) ?><?= $item['published_at'] ? ' &middot; ' . htmlspecialchars(date('d M Y', strtotime($item['published_at']))) : '' ?></div>
            <h3><?= htmlspecialchars($item['title']) ?></h3>
            <?php if ($item['body']): ?><p><?= htmlspecialchars(mb_strimwidth($item['body'], 0, 160, '…')) ?></p><?php endif; ?>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if (!$newsItems): ?>
  <section class="section">
    <div class="container">
      <p class="form-note">No news items yet — check back soon.</p>
    </div>
  </section>
  <?php endif; ?>
</main>

<?php include 'partials/footer.php'; ?>
<script src="js/include.js"></script>
<script src="js/main.js"></script>
</body>
</html>
