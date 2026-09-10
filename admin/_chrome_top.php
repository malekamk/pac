<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> | PAC Johannesburg Admin</title>
<link rel="icon" href="../assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" type="image/png">
<link rel="stylesheet" href="admin.css">
</head>
<body>
<header class="admin-header">
  <a href="index" class="admin-brand">
    <img src="../assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" alt="">
    PAC Johannesburg &mdash; Admin
  </a>
  <nav class="admin-nav">
    <a href="index">Dashboard</a>
    <a href="hero">Hero Carousel</a>
    <a href="events">Events</a>
    <a href="announcements">Announcements</a>
    <a href="candidates">Candidates</a>
    <a href="gallery">Gallery</a>
    <a href="users">Users</a>
    <a href="profile" style="display:flex;align-items:center;gap:6px;">
      <?php if (!empty($_SESSION['admin_image'])): ?>
        <img src="../<?= htmlspecialchars($_SESSION['admin_image']) ?>" alt="" style="width:22px;height:22px;border-radius:50%;object-fit:cover;">
      <?php endif; ?>
      <?= htmlspecialchars($_SESSION['admin_name'] ?? 'My Profile') ?>
    </a>
    <a href="logout" class="logout">Log out</a>
  </nav>
</header>
<main class="admin-main">
<?php if (!empty($_SESSION['flash'])): ?>
  <div class="flash"><?= htmlspecialchars($_SESSION['flash']) ?></div>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
