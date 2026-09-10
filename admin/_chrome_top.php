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
  <a href="index.php" class="admin-brand">
    <img src="../assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" alt="">
    PAC Johannesburg &mdash; Admin
  </a>
  <nav class="admin-nav">
    <a href="index.php">Dashboard</a>
    <a href="events.php">Events</a>
    <a href="announcements.php">Announcements</a>
    <a href="candidates.php">Candidates</a>
    <a href="users.php">Users</a>
    <a href="logout.php" class="logout">Log out</a>
  </nav>
</header>
<main class="admin-main">
<?php if (!empty($_SESSION['flash'])): ?>
  <div class="flash"><?= htmlspecialchars($_SESSION['flash']) ?></div>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
