<?php
require __DIR__ . '/../config.php';
session_start();

if (empty($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}
