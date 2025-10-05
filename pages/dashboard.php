<?php require_once __DIR__ . '/../includes/functions.php'; ?>
<div class="row">
  <div class="col-md-3 mb-3">
    <div class="card card-kpi"><div class="card-body">
      <div class="label">Doanh thu (7 ngày)</div>
      <div class="value"><?php echo money(12530000); ?></div>
    </div></div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card card-kpi"><div class="card-body">
      <div class="label">Số đơn</div>
      <div class="value">128</div>
    </div></div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card card-kpi"><div class="card-body">
      <div class="label">AOV</div>
      <div class="value"><?php echo money(98000); ?></div>
    </div></div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card card-kpi"><div class="card-body">
      <div class="label">Cảnh báo tồn kho</div>
      <div class="value text-danger">5 SKU</div>
    </div></div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <strong>Đơn hàng gần đây</strong>
    <div class="form-inline">
      <input class="form-control form-control-sm mr-2" placeholder="Search..."/>
      <select class="custom-select custom-select-sm">
        <option>Tất cả</option><option>Paid</option><option>Shipped</option>
      </select>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead class="thead-light">
        <tr><th>Mã</th><th>Khách</th><th>Trạng thái</th><th>Tổng</th><th>Ngày</th><th></th></tr>
      </thead>
      <tbody>
        <tr><td>#10023</td><td>Ngọc Mai</td><td><span class="badge badge-success badge-status">Paid</span></td><td><?php echo money(320000); ?></td><td>2025-09-14</td><td><a class="btn btn-sm btn-outline-primary" href="index.php?page=order_view&id=10023">Xem</a></td></tr>
        <tr><td>#10022</td><td>Thu Phương</td><td><span class="badge badge-warning badge-status">Fulfilling</span></td><td><?php echo money(560000); ?></td><td>2025-09-14</td><td><a class="btn btn-sm btn-outline-primary" href="index.php?page=order_view&id=10022">Xem</a></td></tr>
      </tbody>
    </table>
  </div>
</div>
