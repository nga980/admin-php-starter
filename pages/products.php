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
    if (isset($_GET['category']) && $_GET['category'] !== '') $params['category'] = (int)$_GET['category'];
    if (isset($_GET['size']) && $_GET['size'] !== '') $params['size'] = $_GET['size'];
    if (isset($_GET['color']) && $_GET['color'] !== '') $params['color'] = $_GET['color'];

    header('Location: index.php?' . http_build_query($params));
    exit;
}

// Lấy tham số tìm kiếm & trang hiện tại
$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$page  = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$perPage = 15;
$offset  = ($page - 1) * $perPage;


$category = isset($_GET['category']) && $_GET['category'] !== '' ? (int)$_GET['category'] : null;
$size     = isset($_GET['size']) ? trim($_GET['size']) : '';
$color    = isset($_GET['color']) ? trim($_GET['color']) : '';

$dm_options   = function_exists('dm_get_categories') ? dm_get_categories() : [];
$size_options = function_exists('dm_get_sizes') ? dm_get_sizes() : [];
$color_options= function_exists('dm_get_colors') ? dm_get_colors() : [];
// Tổng số bản ghi (để tính tổng trang)
$total = dm_count_products_filtered($query, $category, $size, $color);
$totalPages = max(1, (int)ceil($total / $perPage));

// Lấy dữ liệu trang hiện tại (đã filter theo query)
$products = dm_get_products_filtered($perPage, $offset, $query, $category, $size, $color);
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

<form method="get" class="mb-3">
  <input type="hidden" name="page" value="products">
  <div class="row g-2 align-items-center">
    <div class="col-auto">
      <select name="category" class="form-select" onchange="this.form.submit()">
        <option value="">-- Tất cả danh mục --</option>
        <?php foreach ($dm_options as $dm): ?>
          <option value="<?php echo (int)$dm['ma_danh_muc']; ?>" <?php echo ($category === (int)$dm['ma_danh_muc']) ? 'selected' : '' ?>>
            <?php echo h($dm['ten_danh_muc']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <select name="size" class="form-select" onchange="this.form.submit()">
        <option value="">-- Tất cả kích thước --</option>
        <?php foreach ($size_options as $sz): ?>
          <option value="<?php echo h($sz); ?>" <?php echo ($size === $sz) ? 'selected' : '' ?>>
            <?php echo h($sz); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <select name="color" class="form-select" onchange="this.form.submit()">
        <option value="">-- Tất cả màu sắc --</option>
        <?php foreach ($color_options as $cl): ?>
          <option value="<?php echo h($cl); ?>" <?php echo ($color === $cl) ? 'selected' : '' ?>>
            <?php echo h($cl); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <?php if ($query !== '' || $category || $size !== '' || $color !== ''): ?>
        <a class="btn btn-outline-secondary" href="index.php?page=products">Xoá bộ lọc</a>
      <?php endif; ?>
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
function build_page_url($p, $query = '', $category = null, $size = '', $color = '') {
    $params = ['page' => 'products', 'p' => (int)$p];
    if ($query !== '') $params['q'] = $query;
    if (!empty($category)) $params['category'] = (int)$category;
    if ($size !== '') $params['size'] = $size;
    if ($color !== '') $params['color'] = $color;
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
      <a class="page-link" href="<?php echo $page > 1 ? h(build_page_url($page - 1, $query, $category, $size, $color)) : '#' ?>" tabindex="-1">«</a>
    </li>

    <?php if ($start > 1): ?>
      <li class="page-item"><a class="page-link" href="<?php echo h(build_page_url(1, $query, $category, $size, $color)); ?>">1</a></li>
      <?php if ($start > 2): ?>
        <li class="page-item disabled"><span class="page-link">…</span></li>
      <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
      <li class="page-item <?php echo $i === $page ? 'active' : '' ?>">
        <a class="page-link" href="<?php echo h(build_page_url($i, $query, $category, $size, $color)); ?>"><?php echo $i; ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($end < $totalPages): ?>
      <?php if ($end < $totalPages - 1): ?>
        <li class="page-item disabled"><span class="page-link">…</span></li>
      <?php endif; ?>
      <li class="page-item"><a class="page-link" href="<?php echo h(build_page_url($totalPages, $query, $category, $size, $color)); ?>"><?php echo $totalPages; ?></a></li>
    <?php endif; ?>

    <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : '' ?>">
      <a class="page-link" href="<?php echo $page < $totalPages ? h(build_page_url($page + 1, $query, $category, $size, $color)) : '#' ?>">»</a>
    </li>
  </ul>
</nav>
