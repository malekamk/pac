<?php
function admin_icon($name) {
  $icons = [
    'grid' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/>',
    'image' => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>',
    'images' => '<path d="M2.5 6.5A2 2 0 0 1 4.5 4.5h9a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-9a2 2 0 0 1-2-2z"/><path d="M7 8.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" fill="currentColor" stroke="none"/><path d="M4 14l3-3 2 2 4-4 2.5 2.5"/><path d="M17.5 6.5H19a1.5 1.5 0 0 1 1.5 1.5v9a2 2 0 0 1-2 2h-9A1.5 1.5 0 0 1 8 17.5"/>',
    'megaphone' => '<path d="M3 11l18-5v12L3 13v-2z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>',
    'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
    'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
    'user-circle' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M6.5 19a5.5 5.5 0 0 1 11 0"/>',
    'log-out' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>',
    'search' => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
    'filter' => '<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>',
    'download' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>',
    'pencil' => '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>',
    'trash' => '<polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>',
    'chevron-left' => '<polyline points="15 18 9 12 15 6"/>',
    'chevron-right' => '<polyline points="9 18 15 12 9 6"/>',
    'bell' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
    'sun' => '<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>',
    'external-link' => '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>',
    'plus' => '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>',
    'flag' => '<path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="3"/>',
    'globe' => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
  ];
  $path = $icons[$name] ?? $icons['grid'];
  return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
}

$__activePage = basename($_SERVER['SCRIPT_NAME'], '.php');
function nav_active($slug) {
  global $__activePage;
  return $__activePage === $slug ? ' active' : '';
}

$__electionDate = new DateTime('2026-11-04');
$__today = new DateTime('today');
$__yearStart = new DateTime('2026-01-01');
$__daysLeft = (int) $__today->diff($__electionDate)->format('%r%a');
$__totalDays = max(1, $__yearStart->diff($__electionDate)->days);
$__elapsedDays = $__yearStart->diff($__today)->days;
$__campaignPercent = min(100, max(0, round($__elapsedDays / $__totalDays * 100)));
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> | PAC Johannesburg Admin</title>
<link rel="icon" href="/assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" type="image/png">
<link rel="stylesheet" href="/admin/admin.css">
</head>
<body>
<div class="admin-shell">
  <aside class="admin-sidebar">
    <a href="/admin/index" class="sb-brand">
      <img src="/assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png" alt="">
      <span>PAC Johannesburg</span>
    </a>

    <a href="/admin/profile" class="sb-user">
      <?php if (!empty($_SESSION['admin_image'])): ?>
        <img class="avatar" src="/<?= htmlspecialchars($_SESSION['admin_image']) ?>" alt="">
      <?php else: ?>
        <span class="avatar-fallback"><?= htmlspecialchars(strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1))) ?></span>
      <?php endif; ?>
      <span class="who">
        <span class="name"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'My Profile') ?></span>
        <span class="role"><?= htmlspecialchars(ucfirst($_SESSION['admin_role'] ?? 'member')) ?></span>
      </span>
    </a>

    <nav class="sb-nav">
      <a href="/admin/index" class="sb-link<?= nav_active('index') ?>"><?= admin_icon('grid') ?> Dashboard</a>
    </nav>

    <div class="sb-nav-label">Content</div>
    <nav class="sb-nav">
      <a href="/admin/hero" class="sb-link<?= nav_active('hero') ?>"><?= admin_icon('image') ?> Hero Carousel</a>
      <a href="/admin/announcements" class="sb-link<?= nav_active('announcements') ?>"><?= admin_icon('megaphone') ?> Announcements</a>
      <a href="/admin/events" class="sb-link<?= nav_active('events') ?>"><?= admin_icon('calendar') ?> Events</a>
      <a href="/admin/candidates" class="sb-link<?= nav_active('candidates') ?>"><?= admin_icon('users') ?> Candidates</a>
      <a href="/admin/gallery" class="sb-link<?= nav_active('gallery') ?>"><?= admin_icon('images') ?> Gallery</a>
    </nav>

    <?php if (is_admin()): ?>
    <div class="sb-nav-label">Team</div>
    <nav class="sb-nav">
      <a href="/admin/users" class="sb-link<?= nav_active('users') ?>"><?= admin_icon('users') ?> Users</a>
    </nav>
    <?php endif; ?>

    <div class="sb-spacer"></div>

    <div class="sb-widget">
      <div class="sb-widget-head">
        <span class="lbl"><?= admin_icon('flag') ?> Election Day</span>
        <span class="n"><?= $__daysLeft >= 0 ? $__daysLeft . 'd' : 'Today' ?></span>
      </div>
      <div class="sb-widget-bar"><div class="sb-widget-bar-fill" style="width:<?= $__campaignPercent ?>%;"></div></div>
      <div class="sb-widget-scale"><span>1 Jan</span><span>4 Nov</span></div>
      <a href="/" target="_blank" rel="noopener" class="sb-widget-btn"><?= admin_icon('external-link') ?> View Live Site</a>
    </div>

    <div class="sb-bottom">
      <a href="/admin/profile" class="sb-link<?= nav_active('profile') ?>"><?= admin_icon('user-circle') ?> Profile</a>
      <a href="/admin/logout" class="sb-link logout"><?= admin_icon('log-out') ?> Log Out</a>
    </div>

    <a href="https://starapplications.co.za" target="_blank" rel="noopener" class="sb-promo">
      <?= admin_icon('globe') ?>
      <span>Want Web &amp; App Services?<br><strong>StarApplications</strong></span>
    </a>
  </aside>

  <div class="admin-area">
    <header class="admin-topbar">
      <h1><?= htmlspecialchars($pageTitle ?? 'Admin') ?></h1>
      <div class="tb-actions">
        <button type="button" class="icon-btn" aria-label="Toggle theme"><?= admin_icon('sun') ?></button>
        <button type="button" class="icon-btn" aria-label="Notifications"><?= admin_icon('bell') ?></button>
        <a href="/admin/profile" aria-label="My Profile">
          <?php if (!empty($_SESSION['admin_image'])): ?>
            <img class="tb-avatar" src="/<?= htmlspecialchars($_SESSION['admin_image']) ?>" alt="">
          <?php else: ?>
            <span class="tb-avatar-fallback"><?= htmlspecialchars(strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1))) ?></span>
          <?php endif; ?>
        </a>
      </div>
    </header>

    <?php if (!empty($addLabel) || !empty($liveUrl)): ?>
    <div class="admin-toolbar">
      <?php if (!empty($addLabel)): ?>
        <button type="button" class="pill-btn primary" onclick="document.getElementById('<?= htmlspecialchars($addModalId) ?>').showModal()"><?= admin_icon('plus') ?> <?= htmlspecialchars($addLabel) ?></button>
      <?php else: ?><span></span><?php endif; ?>
      <?php if (!empty($liveUrl)): ?>
        <a href="<?= htmlspecialchars($liveUrl) ?>" target="_blank" rel="noopener" class="pill-btn"><?= admin_icon('external-link') ?> View Live Page</a>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <main class="admin-main">
    <?php if (!empty($_SESSION['flash'])): ?>
      <div class="flash"><?= htmlspecialchars($_SESSION['flash']) ?></div>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
