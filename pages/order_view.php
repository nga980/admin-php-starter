<?php
$id = (int)($_GET['id'] ?? 0);
$demo = [
  'id'=>$id ?: 10023,
  'customer'=>'Ngọc Mai',
  'address'=>'12 Lý Thường Kiệt, Hoàn Kiếm, Hà Nội',
  'phone'=>'0901 234 567',
  'status'=>'Paid',
  'items'=>[
    ['name'=>'Áo thun basic đen', 'sku'=>'TSHIRT-BASIC-BLK-S', 'price'=>159000, 'qty'=>2],
    ['name'=>'Đầm hoa đỏ', 'sku'=>'DRESS-FLORAL-RED-M', 'price'=>399000, 'qty'=>1],
  ],
  'payments'=>[
    ['time'=>'2025-09-14 10:05','method'=>'VNPay','amount'=>717000,'status'=>'success']
  ],
  'timeline'=>[
    ['time'=>'2025-09-14 10:02','text'=>'Đơn hàng được tạo'],
    ['time'=>'2025-09-14 10:05','text'=>'Thanh toán thành công (VNPay)'],
    ['time'=>'2025-09-14 12:20','text'=>'Đã tiếp nhận để đóng gói']
  ]
];
$subtotal = array_reduce($demo['items'], fn($s,$i)=>$s+$i['price']*$i['qty'], 0);
?>
<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0">Đơn #<?php echo (int)$demo['id']; ?></h4>
  <div>
    <a href="#" class="btn btn-outline-secondary">In hoá đơn</a>
    <a href="#" class="btn btn-warning">Tạo nhãn vận chuyển</a>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card mb-3">
      <div class="card-header"><strong>Sản phẩm</strong></div>
      <div class="card-body p-0">
        <table class="table mb-0">
          <thead class="thead-light"><tr><th>Tên</th><th>SKU</th><th class="text-right">SL</th><th class="text-right">Giá</th><th class="text-right">Tổng</th></tr></thead>
          <tbody>
            <?php foreach($demo['items'] as $it): ?>
            <tr>
              <td><?php echo h($it['name']); ?></td>
              <td><?php echo h($it['sku']); ?></td>
              <td class="text-right"><?php echo (int)$it['qty']; ?></td>
              <td class="text-right"><?php echo money($it['price']); ?></td>
              <td class="text-right"><?php echo money($it['price']*$it['qty']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr><th colspan="4" class="text-right">Tạm tính</th><th class="text-right"><?php echo money($subtotal); ?></th></tr>
            <tr><th colspan="4" class="text-right">Phí vận chuyển</th><th class="text-right"><?php echo money(30000); ?></th></tr>
            <tr><th colspan="4" class="text-right">Tổng</th><th class="text-right"><?php echo money($subtotal+30000); ?></th></tr>
          </tfoot>
        </table>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header"><strong>Timeline</strong></div>
      <div class="card-body">
        <ul class="list-unstyled mb-0">
          <?php foreach($demo['timeline'] as $t): ?>
            <li class="mb-2"><span class="text-muted mr-2"><?php echo h($t['time']); ?></span> <?php echo h($t['text']); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card mb-3">
      <div class="card-header"><strong>Khách hàng</strong></div>
      <div class="card-body">
        <div><strong><?php echo h($demo['customer']); ?></strong></div>
        <div><?php echo h($demo['phone']); ?></div>
        <div class="text-muted"><?php echo h($demo['address']); ?></div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header"><strong>Thanh toán</strong></div>
      <div class="card-body">
        <?php foreach($demo['payments'] as $p): ?>
          <div class="d-flex justify-content-between">
            <div><?php echo h($p['time']); ?> • <?php echo h($p['method']); ?></div>
            <strong><?php echo money($p['amount']); ?></strong>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
