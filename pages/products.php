<?php
$demo = [
  ['img' => 'https://via.placeholder.com/60', 'sku'=>'TSHIRT-BASIC-BLK-S', 'name'=>'Áo thun basic đen', 'cat'=>'Áo thun', 'variants'=>'S/M/L', 'price'=>159000, 'sale'=>129000, 'stock'=>12, 'status'=>1, 'updated'=>'2025-09-14'],
  ['img' => 'https://via.placeholder.com/60', 'sku'=>'DRESS-FLORAL-RED-M', 'name'=>'Đầm hoa đỏ', 'cat'=>'Đầm', 'variants'=>'S/M', 'price'=>399000, 'sale'=>0, 'stock'=>2, 'status'=>1, 'updated'=>'2025-09-12'],
  ['img' => 'https://via.placeholder.com/60', 'sku'=>'JEANS-SKINNY-BLU-26', 'name'=>'Quần jeans skinny', 'cat'=>'Quần', 'variants'=>'26/27/28', 'price'=>489000, 'sale'=>459000, 'stock'=>0, 'status'=>0, 'updated'=>'2025-09-11']
];
?>
<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0">Sản phẩm</h4>
  <div>
    <a href="index.php?page=product_form" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Thêm sản phẩm</a>
  </div>
</div>

<div class="card mb-3">
  <div class="card-body">
    <form class="form-row">
      <div class="col-md-3 mb-2">
        <input class="form-control" placeholder="Tên / SKU"/>
      </div>
      <div class="col-md-2 mb-2">
        <select class="custom-select"><option>Danh mục</option><option>Áo thun</option><option>Đầm</option></select>
      </div>
      <div class="col-md-2 mb-2">
        <select class="custom-select"><option>Trạng thái</option><option value="1">Hiển thị</option><option value="0">Ẩn</option></select>
      </div>
      <div class="col-md-2 mb-2">
        <select class="custom-select"><option>Tồn kho</option><option>Còn hàng</option><option>Hết hàng</option></select>
      </div>
      <div class="col-md-3 mb-2 text-right">
        <button class="btn btn-outline-secondary">Reset</button>
        <button class="btn btn-primary ml-2">Lọc</button>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead class="thead-light">
        <tr>
          <th>Ảnh</th><th>SKU</th><th>Tên</th><th>Danh mục</th><th>Biến thể</th><th>Giá</th><th>Giá sale</th><th>Tồn</th><th>Trạng thái</th><th>Ngày cập nhật</th><th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($demo as $row): ?>
        <tr>
          <td><img src="<?php echo h($row['img']); ?>" width="48" height="48" class="rounded"></td>
          <td><?php echo h($row['sku']); ?></td>
          <td><?php echo h($row['name']); ?></td>
          <td><?php echo h($row['cat']); ?></td>
          <td><?php echo h($row['variants']); ?></td>
          <td><?php echo money($row['price']); ?></td>
          <td><?php echo $row['sale'] ? money($row['sale']) : '-'; ?></td>
          <td><?php echo (int)$row['stock']; ?></td>
          <td><?php echo $row['status'] ? '<span class="badge badge-success">Hiển thị</span>' : '<span class="badge badge-secondary">Ẩn</span>'; ?></td>
          <td><?php echo h($row['updated']); ?></td>
          <td class="text-right">
            <a href="index.php?page=product_form&sku=<?php echo urlencode($row['sku']); ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
            <button class="btn btn-sm btn-outline-danger">Xoá</button>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="card-footer d-flex justify-content-between">
    <div>Hiển thị 1–3 / 3</div>
    <nav>
      <ul class="pagination pagination-sm mb-0">
        <li class="page-item active"><span class="page-link">1</span></li>
        <li class="page-item disabled"><span class="page-link">2</span></li>
      </ul>
    </nav>
  </div>
</div>
