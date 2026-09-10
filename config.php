<?php
function load_env($path) {
  if (!file_exists($path)) return;
  foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
    [$key, $value] = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value);
    if (getenv($key) === false) {
      putenv("$key=$value");
    }
  }
}
load_env(__DIR__ . '/.env');

function db() {
  static $conn = null;
  if ($conn !== null) return $conn;
  $conn = mysqli_connect(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_NAME'),
    (int) (getenv('DB_PORT') ?: 3306)
  );
  if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
  }
  mysqli_set_charset($conn, 'utf8mb4');
  return $conn;
}

// Handles an optional <input type="file">, returns the stored relative path or null.
function handle_upload($field) {
  if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
    return null;
  }
  $allowed = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
  $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
  if (!isset($allowed[$ext])) return null;

  $destDir = __DIR__ . '/assets/img/uploads/';
  if (!is_dir($destDir)) mkdir($destDir, 0755, true);

  $filename = uniqid('img_', true) . '.' . $ext;
  if (!move_uploaded_file($_FILES[$field]['tmp_name'], $destDir . $filename)) {
    return null;
  }
  return 'assets/img/uploads/' . $filename;
}
