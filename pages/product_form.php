<?php
$sku = $_GET['sku'] ?? '';
?>
<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0"><?php echo $sku ? 'Sửa sản phẩm' : 'Thêm sản phẩm'; ?></h4>
  <div>
    <button class="btn btn-success">Lưu</button>
    <a href="index.php?page=products" class="btn btn-outline-secondary">Huỷ</a>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card mb-3">
      <div class="card-header"><strong>Thông tin chung</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label>Tên sản phẩm *</label>
          <input class="form-control" required/>
          <small class="form-text text-muted">Tên hiển thị trên website.</small>
        </div>
        <div class="form-group">
          <label>Mô tả</label>
          <textarea class="form-control" rows="5"></textarea>
        </div>
        <div class="form-group">
          <label>Ảnh</label>
          <input type="file" class="form-control-file" multiple/>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header"><strong>Biến thể</strong></div>
      <div class="card-body">
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label>Thuộc tính 1</label>
            <input class="form-control" placeholder="Size (S/M/L)"/>
          </div>
          <div class="col-md-6 form-group">
            <label>Thuộc tính 2</label>
            <input class="form-control" placeholder="Màu (Đen/Trắng/Đỏ)"/>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-sm">
            <thead><tr><th>SKU</th><th>Giá</th><th>Giá sale</th><th>Tồn</th><th>Trọng lượng (g)</th><th></th></tr></thead>
            <tbody>
              <tr>
                <td><input class="form-control form-control-sm" value="<?php echo h($sku ?: 'TSHIRT-BASIC-BLK-S'); ?>"></td>
                <td><input class="form-control form-control-sm" type="number" value="159000"></td>
                <td><input class="form-control form-control-sm" type="number" value="129000"></td>
                <td><input class="form-control form-control-sm" type="number" value="12"></td>
                <td><input class="form-control form-control-sm" type="number" value="250"></td>
                <td><button class="btn btn-sm btn-outline-danger">Xoá</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card mb-3">
      <div class="card-header"><strong>Hiển thị</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label>Danh mục</label>
          <select class="custom-select"><option>Áo thun</option><option>Đầm</option></select>
        </div>
        <div class="form-group">
          <label>Tag</label>
          <input class="form-control" placeholder="basic, summer"/>
        </div>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="visible" checked>
          <label class="custom-control-label" for="visible">Hiển thị</label>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header"><strong>SEO</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label>Slug</label>
          <input class="form-control" value="ao-thun-basic-den"/>
        </div>
        <div class="form-group">
          <label>Meta title</label>
          <input class="form-control"/>
        </div>
        <div class="form-group">
          <label>Meta description</label>
          <textarea class="form-control" rows="3"></textarea>
        </div>
      </div>
    </div>
  </div>
</div>
