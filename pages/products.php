<?php
// Simple product listing page without status column. Displays purchase and selling prices.

// Handle product deletion if 'delete' parameter exists
if (isset($_GET['delete']) && $_GET['delete']) {
    $idToDelete = $_GET['delete'];
    delete_product($idToDelete);

    // Giữ tham số q & p khi quay lại
    $params = ['page' => 'products'];
    if (isset($_GET['q']) && $_GET['q'] !== '') $params['q'] = $_GET['q'];
    if (isset($_GET['p']) && (int)$_GET['p'] > 0) $params['p'] = (int)$_GET['p'];

    header('Location: index.php?' . http_build_query($params));
    exit;
}

// Lấy tham số tìm kiếm & trang hiện tại
$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$page  = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$perPage = 15;
$offset  = ($page - 1) * $perPage;

// Tổng số bản ghi (để tính tổng trang)
$total = get_total_products($query);
$totalPages = max(1, (int)ceil($total / $perPage));

// Lấy dữ liệu trang hiện tại (đã filter theo query)
$products = get_products_paginated($perPage, $offset, $query);
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0">Sản phẩm</h4>
  <div>
    <a href="index.php?page=product_form" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Thêm sản phẩm</a>
  </div>
</div>

<!-- Simple search form -->
<form method="get" class="mb-3">
  <input type="hidden" name="page" value="products" />
  <div class="input-group" style="max-width: 300px;">
    <input type="text" name="q" class="form-control" placeholder="Tìm theo tên hoặc mã" value="<?php echo h($query); ?>" />
    <div class="input-group-append">
      <button type="submit" class="btn btn-outline-secondary">Tìm</button>
    </div>
  </div>
</form>

<div class="card">
  <div class="table-responsive p-3">
    <table class="table table-hover mb-0">
      <thead class="thead-light">
        <tr>
          <th>Ảnh</th>
          <th>Mã</th>
          <th>Tên</th>
          <th>Danh mục</th>
          <th>Biến thể</th>
          <th>Giá nhập</th>
          <th>Giá bán</th>
          <th>Tồn kho</th>
          <th>Ngày cập nhật</th>
          <th class="text-right">Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($products)): ?>
          <tr><td colspan="10" class="text-center text-muted">Không có sản phẩm.</td></tr>
        <?php else: ?>
        <?php foreach ($products as $row): ?>
        <tr>
          <td>
            <?php
              $imgPath = $row['image'];
              $displayPlaceholder = true;
              if (!empty($imgPath)) {
                  if (strpos($imgPath, 'uploads/') === 0) {
                      $fullImgPath = __DIR__ . '/../' . $imgPath;
                      if (file_exists($fullImgPath)) {
                          $displayPlaceholder = false;
                      }
                  } else {
                      $displayPlaceholder = false;
                  }
              }
            ?>
            <?php if (!$displayPlaceholder): ?>
              <img src="<?php echo h($row['image']); ?>" width="48" height="48" class="rounded" />
            <?php else: ?>
              <img src="https://via.placeholder.com/60" width="48" height="48" class="rounded" />
            <?php endif; ?>
          </td>
          <td><?php echo h($row['id']); ?></td>
          <td><?php echo h($row['name']); ?></td>
          <td><?php echo h($row['category']); ?></td>
          <td><?php echo h($row['variants'] ?? 0); ?></td>
          <td><?php echo money($row['purchase']); ?></td>
          <td><?php echo money($row['price']); ?></td>
          <td><?php echo (int)($row['stock'] ?? 0); ?></td>
          <td><?php echo h(date('Y-m-d', strtotime($row['updated_at']))); ?></td>
          <td class="text-right">
            <a href="index.php?page=product_form&id=<?php echo urlencode($row['id']); ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
            <a href="index.php?page=products&delete=<?php echo urlencode($row['id']); ?>&q=<?php echo urlencode($query); ?>&p=<?php echo $page; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá sản phẩm này?');">Xoá</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
// helper tạo URL giữ tham số q & page=products
function build_page_url($p) {
    $params = ['page' => 'products'];
    if (isset($_GET['q']) && $_GET['q'] !== '') $params['q'] = $_GET['q'];
    $params['p'] = $p;
    return 'index.php?' . http_build_query($params);
}

// Tính range hiển thị (cửa sổ 5 trang)
$start = max(1, $page - 2);
$end   = min($totalPages, $page + 2);
if ($end - $start < 4) {
    if ($start == 1) $end = min($totalPages, $start + 4);
    else $start = max(1, $end - 4);
}
?>

<nav aria-label="Pagination" class="mt-3">
  <ul class="pagination mb-0">
    <li class="page-item <?php echo $page <= 1 ? 'disabled' : '' ?>">
      <a class="page-link" href="<?php echo $page > 1 ? h(build_page_url($page - 1)) : '#' ?>" tabindex="-1">«</a>
    </li>

    <?php if ($start > 1): ?>
      <li class="page-item"><a class="page-link" href="<?php echo h(build_page_url(1)); ?>">1</a></li>
      <?php if ($start > 2): ?>
        <li class="page-item disabled"><span class="page-link">…</span></li>
      <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
      <li class="page-item <?php echo $i === $page ? 'active' : '' ?>">
        <a class="page-link" href="<?php echo h(build_page_url($i)); ?>"><?php echo $i; ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($end < $totalPages): ?>
      <?php if ($end < $totalPages - 1): ?>
        <li class="page-item disabled"><span class="page-link">…</span></li>
      <?php endif; ?>
      <li class="page-item"><a class="page-link" href="<?php echo h(build_page_url($totalPages)); ?>"><?php echo $totalPages; ?></a></li>
    <?php endif; ?>

    <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : '' ?>">
      <a class="page-link" href="<?php echo $page < $totalPages ? h(build_page_url($page + 1)) : '#' ?>">»</a>
    </li>
  </ul>
</nav>
