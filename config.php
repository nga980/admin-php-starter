<?php
// ====== Basic Config ======
session_start();

// Base URL (adjust if deploying to subfolder)
$BASE_URL = rtrim(
  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
  . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']),
  '/\\'
);

// Database config (placeholder) — dùng array() thay cho [] để tương thích PHP cũ
$DB = array(
  'dsn'  => 'mysql:host=localhost;dbname=suny_store_product_db;charset=utf8mb4',
  'user' => 'root',
  'pass' => ''
);

// Simple PDO helper
function get_pdo() {
  global $DB;
  try {
    $pdo = new PDO(
      $DB['dsn'],
      $DB['user'],
      $DB['pass'],
      array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      )
    );
    return $pdo;
  } catch (Throwable $e) {
    // Nếu PHP cũ không có Throwable, bắt Exception
    try { } catch (Exception $ex) { }
    return null; // demo
  }
}
