<?php require_once __DIR__ . '/../config.php'; require_once __DIR__ . '/functions.php'; ?>
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
</head>
<body>
  <aside class="sidebar p-2">
    <h5 class="px-3 pt-3 text-white">Admin</h5>
    <nav>
      <?php $p = $_GET['page'] ?? 'dashboard'; ?>
      <a class="<?php echo active('dashboard', $p); ?>" href="index.php?page=dashboard"><i class="fas fa-chart-line mr-2"></i>Dashboard</a>
      <a class="<?php echo active('products', $p); ?>" href="index.php?page=products"><i class="fas fa-tshirt mr-2"></i>Sản phẩm</a>
      <a class="<?php echo active('orders', $p); ?>" href="index.php?page=orders"><i class="fas fa-receipt mr-2"></i>Đơn hàng</a>
      <a class="<?php echo active('customers', $p); ?>" href="index.php?page=customers"><i class="fas fa-user-friends mr-2"></i>Khách hàng</a>
      <a class="<?php echo active('settings', $p); ?>" href="index.php?page=settings"><i class="fas fa-cog mr-2"></i>Cấu hình</a>
      <a href="logout.php" class="mt-3 text-danger"><i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất</a>
    </nav>
  </aside>

  <main class="content">
    <div class="topbar py-2 px-3 d-flex align-items-center justify-content-between">
      <form class="form-inline" method="get" action="index.php">
        <input type="hidden" name="page" value="search"/>
        <input name="q" class="form-control" placeholder="Tìm nhanh (SKU, khách, đơn)"/>
        <button class="btn btn-primary ml-2">Tìm</button>
      </form>
      <div class="d-flex align-items-center">
        <span class="badge badge-danger">3</span>
        <div class="ml-3 text-right">
          <div class="small text-muted">Xin chào</div>
          <strong><?php echo h($_SESSION['user']['name'] ?? 'Admin'); ?></strong>
        </div>
      </div>
    </div>
    <div class="container-fluid py-3">
