<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/functions.php';

/**
 * Admin Header (dashboard)
 * - Bảo vệ trang admin: yêu cầu đăng nhập
 * - Đọc thông tin user từ session
 * - Hiển thị menu theo vai trò
 * - Tìm kiếm nhanh toàn hệ thống
 * - Hiển thị badge cảnh báo (ví dụ: sản phẩm sắp hết hàng)
 */

// Start session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Bảo vệ admin: bắt buộc đăng nhập
if (empty($_SESSION['user'])) {
    // chuyển về trang login + giữ URL quay lại
    $returnUrl = urlencode($_SERVER['REQUEST_URI'] ?? 'index.php?page=dashboard');
    header('Location: login.php?return=' . $returnUrl);
    exit;
}

$user = $_SESSION['user'];
$userName = $user['name'] ?? 'Admin';
$userRole = strtolower($user['role'] ?? 'admin'); // 'admin' | 'staff' | 'viewer' ...

/** Tính active cho menu */
$p = $_GET['page'] ?? 'dashboard';

/** Tính số cảnh báo: ví dụ sản phẩm sắp hết hàng (stock <= 0) */
$alertCount = 0;
try {
    $pdo = get_pdo();
    if ($pdo) {
        $sql = "
            SELECT COUNT(*) FROM (
                SELECT sp.ma_san_pham, COALESCE(SUM(ct.so_luong), 0) AS stock
                FROM san_pham sp
                LEFT JOIN chi_tiet_san_pham ct ON ct.ma_san_pham = sp.ma_san_pham
                GROUP BY sp.ma_san_pham
                HAVING stock <= 0
            ) t
        ";
        $alertCount = (int)$pdo->query($sql)->fetchColumn();
    }
} catch (Throwable $e) {
    // im lặng, giữ alertCount = 0
}

// Helper kiểm tra quyền
function can($roleNeeded, $userRole) {
    // Thứ tự quyền: admin > staff > viewer
    $rank = ['viewer' => 1, 'staff' => 2, 'admin' => 3];
    $need = $rank[$roleNeeded] ?? 1;
    $have = $rank[strtolower($userRole)] ?? 1;
    return $have >= $need;
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Admin – Fashion</title>
  <!-- Bootstrap 4.5.2 -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <!-- Font Awesome (optional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  <link rel="stylesheet" href="assets/css/styles.css"/>
  <style>
    body { display:flex; min-height:100vh; }
    .sidebar {
      width: 240px;
      background: #222;
      color: #fff;
    }
    .sidebar a { display:block; padding:10px 16px; color:#ddd; text-decoration:none; border-radius:6px; margin:4px 8px; }
    .sidebar a.active, .sidebar a:hover { background:#343a40; color:#fff; }
    .content { flex:1; background:#f7f7f7; }
    .topbar { background:#fff; border-bottom:1px solid #e8e8e8; }
  </style>
</head>
<body>
  <aside class="sidebar p-2">
    <h5 class="px-3 pt-3 text-white">Admin</h5>
    <nav class="mt-2">
      <a class="<?php echo active('dashboard', $p); ?>" href="index.php?page=dashboard"><i class="fas fa-tachometer-alt mr-2"></i>Tổng quan</a>
      <?php if (can('staff', $userRole)): ?>
        <a class="<?php echo active('products', $p); ?>" href="index.php?page=products"><i class="fas fa-box-open mr-2"></i>Sản phẩm</a>
        <a class="<?php echo active('categories', $p); ?>" href="index.php?page=categories"><i class="fas fa-tags mr-2"></i>Danh mục</a>
      <?php endif; ?>

      <?php if (can('admin', $userRole)): ?>
        <a class="<?php echo active('customers', $p); ?>" href="index.php?page=customers"><i class="fas fa-user-friends mr-2"></i>Khách hàng</a>
        <a class="<?php echo active('orders', $p); ?>" href="index.php?page=orders"><i class="fas fa-receipt mr-2"></i>Đơn hàng</a>
        <a class="<?php echo active('settings', $p); ?>" href="index.php?page=settings"><i class="fas fa-cog mr-2"></i>Cấu hình</a>
      <?php endif; ?>

      <a href="logout.php" class="mt-3 text-danger"><i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất</a>
    </nav>
  </aside>

  <main class="content">
    <div class="topbar py-2 px-3 d-flex align-items-center justify-content-between">
      <form class="form-inline" method="get" action="index.php">
        <input type="hidden" name="page" value="search"/>
        <input name="q" class="form-control" placeholder="Tìm nhanh (Sản phẩm, khách, đơn)" value="<?php echo h($_GET['q'] ?? ''); ?>"/>
        <button class="btn btn-primary ml-2">Tìm</button>
      </form>

      <div class="d-flex align-items-center">
        <?php if ($alertCount > 0): ?>
          <a href="index.php?page=products&stock=out" class="badge badge-danger" title="Sản phẩm hết hàng">
            <?php echo (int)$alertCount; ?>
          </a>
        <?php else: ?>
          <span class="badge badge-secondary" title="Không có cảnh báo">0</span>
        <?php endif; ?>
        <div class="ml-3 text-right">
          <div class="small text-muted">Xin chào</div>
          <strong><?php echo h($userName); ?> (<?php echo h($userRole); ?>)</strong>
        </div>
      </div>
    </div>

    <div class="container-fluid py-3">
