<!-- Trong file view_user.php (trang chi tiết khách hàng) -->
<h4 class="mt-5 mb-4 text-primary">
    <i class="fas fa-history"></i> LỊCH SỬ MUA HÀNG
</h4>

<?php
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$orders = $stmt->get_result();

if ($orders->num_rows == 0): ?>
    <div class="alert alert-info">Khách hàng chưa mua gì.</div>
<?php else: ?>
    <div class="accordion" id="lichsu">
        <?php while($order = $orders->fetch_assoc()): ?>
        <div class="card mb-2">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <button class="btn btn-link text-white collapsed" data-bs-toggle="collapse" data-bs-target="#order<?= $order['id'] ?>">
                        Mã đơn: <strong>DH<?= sprintf("%05d", $order['id']) ?></strong> 
                        — <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                        — Tổng: <strong><?= number_format($order['total_amount']) ?>₫</strong>
                    </button>
                    <span class="badge bg-light text-dark float-end">
                        <?= $order['status'] == 'completed' ? 'Hoàn thành' : 
                            ($order['status'] == 'pending' ? 'Chờ xử lý' : 'Đang giao') ?>
                    </span>
                </h6>
            </div>
            <div id="order<?= $order['id'] ?>" class="collapse" data-bs-parent="#lichsu">
                <div class="card-body">
                    <?php
                    $details = $conn->query("SELECT * FROM order_details WHERE order_id = {$order['id']}");
                    while($d = $details->fetch_assoc()):
                    ?>
                    <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                        <img src="../uploads/<?=htmlspecialchars($d['product_image'])?>" width="60" class="me-3">
                        <div class="flex-grow-1">
                            <strong><?=htmlspecialchars($d['product_name'])?></strong><br>
                            <small><?= $d['quantity'] ?> × <?= number_format($d['price']) ?>₫</small>
                        </div>
                        <strong><?= number_format($d['subtotal']) ?>₫</strong>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>