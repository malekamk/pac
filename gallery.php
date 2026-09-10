<?php
require __DIR__ . '/config.php';
$conn = db();
$galleryImages = mysqli_query($conn, "SELECT * FROM gallery_images ORDER BY sort_order ASC, id ASC");
$galleryImages = $galleryImages ? mysqli_fetch_all($galleryImages, MYSQLI_ASSOC) : [];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gallery | PAC Johannesburg Region</title>
<meta name="description" content="Photo gallery of the Pan Africanist Congress of Azania — historic founders, current leadership and the party emblem.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://pacjhb.org.za/gallery">
<meta property="og:type" content="website">
<meta property="og:site_name" content="PAC Johannesburg Region">
<meta property="og:title" content="Gallery | PAC Johannesburg Region">
<meta property="og:description" content="Photo gallery of the Pan Africanist Congress of Azania — historic founders, current leadership and the party emblem.">
<meta property="og:url" content="https://pacjhb.org.za/gallery">
<meta property="og:image" content="https://pacjhb.org.za/assets/img/founding-members-1957.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Gallery | PAC Johannesburg Region">
<meta name="twitter:description" content="Photo gallery of the Pan Africanist Congress of Azania — historic founders, current leadership and the party emblem.">
<meta name="twitter:image" content="https://pacjhb.org.za/assets/img/founding-members-1957.jpg">
<link rel="icon" href="assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" type="image/png">
<link rel="stylesheet" href="css/style.css">
</head>
<body data-page="gallery">

<?php include 'partials/header.php'; ?>

<main>
  <section class="page-hero">
    <div class="container">
      <p class="breadcrumb"><a href="/">Home</a> / Gallery</p>
      <h1>Gallery</h1>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="gallery-grid">
        <?php foreach ($galleryImages as $img): ?>
        <?php if ($img['display_mode'] === 'pattern'): ?>
        <div class="gallery-item pattern"><img src="<?= htmlspecialchars($img['image']) ?>" alt="<?= htmlspecialchars($img['caption'] ?? 'PAC emblem') ?>" style="width:140px;height:auto;"></div>
        <?php else: ?>
        <div class="gallery-item">
          <img src="<?= htmlspecialchars($img['image']) ?>" alt="<?= htmlspecialchars($img['caption'] ?? '') ?>"<?= $img['display_mode'] === 'contain' ? ' style="background:#fff;object-fit:contain;"' : '' ?>>
          <?php if ($img['caption']): ?><div class="cap"><?= htmlspecialchars($img['caption']) ?></div><?php endif; ?>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php if (!$galleryImages): ?><p class="form-note">Photos will be added here soon.</p><?php endif; ?>
      </div>
    </div>
  </section>
</main>

<?php include 'partials/footer.php'; ?>
<script src="js/include.js"></script>
<script src="js/main.js"></script>
</body>
</html>
