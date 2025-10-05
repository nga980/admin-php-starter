<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
$page = $_GET['page'] ?? 'dashboard';

$allow = ['dashboard','products','product_form','orders','order_view','customers','settings','search'];
if (!in_array($page, $allow)) $page = 'dashboard';

include __DIR__ . '/includes/header.php';
$path = __DIR__ . '/pages/' . $page . '.php';
if (file_exists($path)) include $path; else echo '<div class="alert alert-warning">Trang không tồn tại.</div>';
include __DIR__ . '/includes/footer.php';
