<?php
// Product create/edit page without status toggle and without tag field.
// Supports dynamic variants, multiple image uploads, and separate purchase and selling price fields.

// Get product ID from query string
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array(
        'id'            => $_POST['id'] ?? '',
        'name'          => $_POST['name'] ?? '',
        'description'   => $_POST['description'] ?? '',
        'purchase'      => $_POST['purchase'] ?? 0,
        'price'         => $_POST['price'] ?? 0,
        'category'      => $_POST['category'] ?? '',
        // no tag and no status
        'variant_size'  => $_POST['variant_size'] ?? array(),
        'variant_color' => $_POST['variant_color'] ?? array(),
        'variant_qty'   => $_POST['variant_qty'] ?? array(),
        'main_image'    => $_POST['main_image'] ?? '',
        'delete_image'  => $_POST['delete_image'] ?? array()
    );
    save_product($data);
    header('Location: index.php?page=products');
    exit;
}

// Fetch product data for editing
$product = $id ? get_product($id) : null;

// Fetch category list
$categories = array();
$pdo = get_pdo();
if ($pdo) {
    $stmt = $pdo->query('SELECT ten_danh_muc FROM danh_muc ORDER BY ten_danh_muc');
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Fetch existing variants
$variants = array();
if ($id) {
    $stmtVar = $pdo->prepare('SELECT kich_thuoc, mau_sac, so_luong FROM chi_tiet_san_pham WHERE ma_san_pham = ?');
    $stmtVar->execute(array($id));
    $variants = $stmtVar->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch existing images
$images = array();
if ($id) {
    $images = get_product_images($id);
}
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0"><?php echo $id ? 'Sửa sản phẩm' : 'Thêm sản phẩm'; ?></h4>
  <div>
    <button form="product-form" type="submit" class="btn btn-success">Lưu</button>
    <a href="index.php?page=products" class="btn btn-outline-secondary">Huỷ</a>
  </div>
</div>

<form id="product-form" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?php echo h($product['id'] ?? ''); ?>" />
  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-3">
        <div class="card-header"><strong>Thông tin chung</strong></div>
        <div class="card-body">
          <div class="form-group">
            <label>Tên sản phẩm *</label>
            <input class="form-control" name="name" required value="<?php echo h($product['name'] ?? ''); ?>" />
            <small class="form-text text-muted">Tên hiển thị trên website.</small>
          </div>
          <div class="form-group">
            <label>Mô tả</label>
            <textarea class="form-control" name="description" rows="5"><?php echo h($product['description'] ?? ''); ?></textarea>
          </div>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header"><strong>Ảnh sản phẩm</strong></div>
        <div class="card-body">
          <?php if (!empty($images)): ?>
            <?php foreach ($images as $img): ?>
              <div class="form-group d-flex align-items-center">
                <img src="<?php echo h($img['dia_chi_anh']); ?>" alt="image" class="img-thumbnail mr-2" style="max-width:100px;" />
                <div>
                  <label class="mr-2">
                    <input type="radio" name="main_image" value="<?php echo h($img['ma_anh']); ?>" <?php echo $img['anh_chinh'] ? 'checked' : ''; ?> /> Ảnh chính
                  </label>
                  <label>
                    <input type="checkbox" name="delete_image[]" value="<?php echo h($img['ma_anh']); ?>" /> Xoá
                  </label>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
          <div class="form-group">
            <label>Thêm ảnh (có thể chọn nhiều)</label>
            <input class="form-control-file" type="file" name="image_files[]" multiple />
          </div>
          <small class="form-text text-muted">Chọn một ảnh làm ảnh chính; những ảnh khác sẽ là ảnh phụ. Bạn có thể xoá ảnh không cần dùng.</small>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header"><strong>Giá</strong></div>
        <div class="card-body">
          <div class="form-group">
            <label>Giá nhập</label>
            <input class="form-control" type="number" name="purchase" step="0.01" value="<?php echo h($product['purchase'] ?? 0); ?>" />
          </div>
          <div class="form-group mb-0">
            <label>Giá bán</label>
            <input class="form-control" type="number" name="price" step="0.01" value="<?php echo h($product['price'] ?? 0); ?>" />
          </div>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header"><strong>Biến thể (kích thước, màu sắc, số lượng)</strong></div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm" id="variants-table">
              <thead>
                <tr><th>Kích thước</th><th>Màu sắc</th><th>Số lượng</th></tr>
              </thead>
              <tbody>
                <?php if (count($variants) > 0): ?>
                  <?php foreach ($variants as $variant): ?>
                    <tr>
                      <td><input class="form-control form-control-sm" name="variant_size[]" value="<?php echo h($variant['kich_thuoc']); ?>" /></td>
                      <td><input class="form-control form-control-sm" name="variant_color[]" value="<?php echo h($variant['mau_sac']); ?>" /></td>
                      <td><input class="form-control form-control-sm" type="number" name="variant_qty[]" value="<?php echo h($variant['so_luong']); ?>" /></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                  <td><input class="form-control form-control-sm" name="variant_size[]" value="" /></td>
                  <td><input class="form-control form-control-sm" name="variant_color[]" value="" /></td>
                  <td><input class="form-control form-control-sm" type="number" name="variant_qty[]" value="" /></td>
                </tr>
              </tbody>
            </table>
          </div>
          <button type="button" id="add-variant" class="btn btn-sm btn-outline-primary">Thêm biến thể</button>
          <small class="form-text text-muted">Nhấn "Thêm biến thể" để thêm dòng mới cho size/màu/số lượng.</small>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card mb-3">
        <div class="card-header"><strong>Thông tin bổ sung</strong></div>
        <div class="card-body">
          <div class="form-group">
            <label>Danh mục</label>
            <select class="custom-select" name="category">
              <option value="">Chọn danh mục</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?php echo h($cat); ?>" <?php echo (isset($product['category']) && $product['category'] === $cat) ? 'selected' : ''; ?>>
                  <?php echo h($cat); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- Tag field removed -->
        </div>
      </div>
    </div>
  </div>
</form>

<script>
// Add variant row dynamically
(() => {
  const btn = document.getElementById('add-variant');
  if (btn) {
    btn.addEventListener('click', () => {
      const table = document.getElementById('variants-table');
      const tbody = table.getElementsByTagName('tbody')[0];
      const newRow = document.createElement('tr');
      newRow.innerHTML =
        '<td><input class="form-control form-control-sm" name="variant_size[]" value="" /></td>' +
        '<td><input class="form-control form-control-sm" name="variant_color[]" value="" /></td>' +
        '<td><input class="form-control form-control-sm" type="number" name="variant_qty[]" value="" /></td>';
      tbody.appendChild(newRow);
    });
  }
})();
</script>