<?php
$orders = [
  ['id'=>10023,'customer'=>'Ngọc Mai','status'=>'Paid','total'=>320000,'date'=>'2025-09-14'],
  ['id'=>10022,'customer'=>'Thu Phương','status'=>'Fulfilling','total'=>560000,'date'=>'2025-09-14'],
];
?>
<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0">Đơn hàng</h4>
  <div>
    <a href="#" class="btn btn-outline-secondary">Xuất CSV</a>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead class="thead-light">
        <tr><th>Mã</th><th>Khách</th><th>Trạng thái</th><th>Tổng</th><th>Ngày</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach($orders as $o): ?>
        <tr>
          <td>#<?php echo (int)$o['id']; ?></td>
          <td><?php echo h($o['customer']); ?></td>
          <td><span class="badge badge-<?php echo $o['status']==='Paid'?'success':'warning'; ?>"><?php echo h($o['status']); ?></span></td>
          <td><?php echo money($o['total']); ?></td>
          <td><?php echo h($o['date']); ?></td>
          <td class="text-right"><a class="btn btn-sm btn-outline-primary" href="index.php?page=order_view&id=<?php echo (int)$o['id']; ?>">Xem</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
