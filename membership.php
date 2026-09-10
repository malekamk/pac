<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Membership | PAC Johannesburg Region</title>
<meta name="description" content="Join the Pan Africanist Congress of Azania, Johannesburg Region. Serve, Suffer, Sacrifice — become a member today.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://pacjhb.org.za/membership">
<meta property="og:type" content="website">
<meta property="og:site_name" content="PAC Johannesburg Region">
<meta property="og:title" content="Join PAC | PAC Johannesburg Region">
<meta property="og:description" content="Join the Pan Africanist Congress of Azania, Johannesburg Region. Serve, Suffer, Sacrifice — become a member today.">
<meta property="og:url" content="https://pacjhb.org.za/membership">
<meta property="og:image" content="https://pacjhb.org.za/assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Join PAC | PAC Johannesburg Region">
<meta name="twitter:description" content="Join the Pan Africanist Congress of Azania, Johannesburg Region. Serve, Suffer, Sacrifice — become a member today.">
<meta name="twitter:image" content="https://pacjhb.org.za/assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png">
<link rel="icon" href="assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" type="image/png">
<link rel="stylesheet" href="css/style.css">
</head>
<body data-page="membership">

<?php include 'partials/header.php'; ?>

<main>
  <section class="page-hero">
    <div class="container">
      <p class="breadcrumb"><a href="/">Home</a> / Membership</p>
      <h1>Join PAC</h1>
    </div>
  </section>

  <section class="section">
    <div class="container two-col">
      <div>
        <span class="eyebrow">Membership</span>
        <h2>Serve &bull; Suffer &bull; Sacrifice</h2>
        <p>Membership of the Pan Africanist Congress of Azania is open to any South African who subscribes to the PAC&rsquo;s Africanist constitution and is committed to the struggle for land, dignity and economic justice. Complete the form and a Johannesburg Region organiser will contact you to confirm your branch and issue your membership card.</p>
        <ul style="color:var(--gray-300);padding-left:20px;line-height:2;">
          <li>Be a South African citizen aged 18 years or older</li>
          <li>Subscribe to the PAC&rsquo;s constitution and code of conduct</li>
          <li>Attend your local branch&rsquo;s induction and pay the annual membership fee</li>
          <li>Uphold the PAC&rsquo;s colours &mdash; black, green and gold &mdash; and the call: Izwe Lethu!!</li>
        </ul>
        <p class="form-note">Prefer to join in person? Visit the head office at Khotso House, 62 Marshal Street, Johannesburg, or call <a href="tel:+27614815677" style="color:var(--gold);">+27 61 481 5677</a>.</p>
      </div>

      <form class="card-form" data-mailto="admin@pacjhb.org.za" data-subject="PAC Johannesburg — New Membership Application">
        <div class="form-row">
          <div class="field"><label for="fname">First Name</label><input id="fname" name="First Name" required></div>
          <div class="field"><label for="lname">Surname</label><input id="lname" name="Surname" required></div>
        </div>
        <div class="form-row">
          <div class="field"><label for="idnum">ID Number</label><input id="idnum" name="ID Number" required></div>
          <div class="field"><label for="dob">Date of Birth</label><input id="dob" type="date" name="Date of Birth"></div>
        </div>
        <div class="form-row">
          <div class="field"><label for="phone">Phone Number</label><input id="phone" type="tel" name="Phone" required></div>
          <div class="field"><label for="email">Email Address</label><input id="email" type="email" name="Email"></div>
        </div>
        <div class="form-row">
          <div class="field full"><label for="ward">Suburb / Ward</label><input id="ward" name="Suburb or Ward" placeholder="e.g. Soweto, Alexandra, Sandton"></div>
        </div>
        <div class="form-row">
          <div class="field full"><label for="wing">Interested Wing (optional)</label>
            <select id="wing" name="Wing">
              <option value="">General Membership</option>
              <option value="PAYCO">PAYCO &mdash; Youth</option>
              <option value="PAWO">PAWO &mdash; Women</option>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center;">Submit Application &rarr;</button>
        <p class="form-note" data-form-note>Submitting opens your email client to send this application directly to the PAC head office.</p>
      </form>
    </div>
  </section>
</main>

<?php include 'partials/footer.php'; ?>
<script src="js/include.js"></script>
<script src="js/main.js"></script>
</body>
</html>
