<?php
// Simple auth guard for demo
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
