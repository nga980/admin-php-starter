<?php
$customers = [
  ['name'=>'Ngọc Mai','email'=>'mai@example.com','orders'=>5,'spent'=>3250000,'tier'=>'Gold','created'=>'2025-06-02'],
  ['name'=>'Thu Phương','email'=>'phuong@example.com','orders'=>2,'spent'=>780000,'tier'=>'Silver','created'=>'2025-08-20'],
];
?>
<h4 class="mb-3">Khách hàng</h4>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead class="thead-light"><tr><th>Tên</th><th>Email</th><th>Số đơn</th><th>Tổng chi tiêu</th><th>Hạng</th><th>Ngày tạo</th></tr></thead>
      <tbody>
        <?php foreach($customers as $c): ?>
        <tr>
          <td><?php echo h($c['name']); ?></td>
          <td><?php echo h($c['email']); ?></td>
          <td><?php echo (int)$c['orders']; ?></td>
          <td><?php echo money($c['spent']); ?></td>
          <td><span class="badge badge-info"><?php echo h($c['tier']); ?></span></td>
          <td><?php echo h($c['created']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
