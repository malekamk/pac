<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ward Candidates | PAC Johannesburg Region</title>
<meta name="description" content="Meet the Pan Africanist Congress's ward councillor candidates for the 4 November 2026 Johannesburg Local Government Elections.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://pacjhb.org.za/candidates">
<meta property="og:type" content="website">
<meta property="og:site_name" content="PAC Johannesburg Region">
<meta property="og:title" content="Ward Candidates | PAC Johannesburg Region">
<meta property="og:description" content="Meet the Pan Africanist Congress's ward councillor candidates for the 4 November 2026 Johannesburg Local Government Elections.">
<meta property="og:url" content="https://pacjhb.org.za/candidates">
<meta property="og:image" content="https://pacjhb.org.za/assets/img/candidate-tsholo-molatlou.jpeg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Ward Candidates | PAC Johannesburg Region">
<meta name="twitter:description" content="Meet the Pan Africanist Congress's ward councillor candidates for the 4 November 2026 Johannesburg Local Government Elections.">
<meta name="twitter:image" content="https://pacjhb.org.za/assets/img/candidate-tsholo-molatlou.jpeg">
<link rel="icon" href="assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" type="image/png">
<link rel="stylesheet" href="css/style.css">
</head>
<body data-page="candidates">

<?php
require __DIR__ . '/config.php';
$conn = db();
$candidates = mysqli_query($conn, "SELECT * FROM candidates ORDER BY id ASC");
$candidates = $candidates ? mysqli_fetch_all($candidates, MYSQLI_ASSOC) : [];
?>

<?php include 'partials/header.php'; ?>

<main>
  <section class="page-hero">
    <div class="container">
      <p class="breadcrumb"><a href="/">Home</a> / Candidates</p>
      <h1>Ward Candidates</h1>
      <p style="margin-top:14px;color:var(--gold);font-weight:700;" data-election-countdown></p>
    </div>
  </section>

  <section class="section">
    <div class="container" style="max-width:820px;">
      <span class="eyebrow">2026 Local Government Elections</span>
      <h2>Councillor Candidates &mdash; Johannesburg</h2>
      <p>Alongside Thami ka Plaatjie&rsquo;s campaign for Executive Mayor, the PAC is fielding ward councillor candidates across Johannesburg for the 4 November 2026 Local Government Elections. Meet the candidates standing under the PAC banner &mdash; Unity, Dignity, Liberation.</p>
    </div>
  </section>

  <section class="section section-tight">
    <div class="container">
      <div class="candidates-grid">
        <?php foreach ($candidates as $c): ?>
        <article class="candidate-card">
          <?php if ($c['image']): ?><img class="poster" src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>, PAC Councillor Candidate for Ward <?= htmlspecialchars($c['ward']) ?>"><?php endif; ?>
          <div class="cap">
            <?php if ($c['ward']): ?><div class="ward">Ward <?= htmlspecialchars($c['ward']) ?></div><?php endif; ?>
            <h3><?= htmlspecialchars($c['name']) ?></h3>
            <p style="margin:0;font-size:.85rem;"><?= htmlspecialchars($c['role']) ?></p>
          </div>
        </article>
        <?php endforeach; ?>
        <?php if (!$candidates): ?><p class="form-note">Candidates will be listed here as they're confirmed.</p><?php endif; ?>
      </div>
      <p class="form-note" style="margin-top:24px;">More ward candidates are confirmed on an ongoing basis as the Region&rsquo;s election structures finalise the full slate. Contact the head office to confirm the candidate standing in your ward.</p>

      <div class="featured-event" style="margin-top:36px;">
        <img src="assets/img/pac-women-mobilisation.jpeg" alt="PAC supporter pledging her vote for the 4 November 2026 elections">
        <div>
          <span class="tag">Mobilisation</span>
          <h2 style="margin-bottom:6px;">I Will Be Voting for PAC on 4 November</h2>
          <p>Noble daughter of the soil. Train the woman, train the nation. To liberate Azania &mdash; for Azania, by Azania, for all Azanians.</p>
          <p class="form-note">If this is one of our ward candidates rather than a general campaign supporter, let the head office know her name and ward so she can be added to the list above.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="join-banner">
    <div class="container join-inner">
      <div><h2>Vote PAC on 4 November</h2><p>Let&rsquo;s fix our municipality together. Unity. Dignity. Liberation.</p></div>
      <a href="membership" class="btn btn-gold">Join PAC Today &rarr;</a>
    </div>
  </section>
</main>

<?php include 'partials/footer.php'; ?>
<script src="js/include.js"></script>
<script src="js/main.js"></script>
</body>
</html>
