<!-- tap on top -->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<div class="loader-wrapper">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
</div>

<div class="page-body">
    <div class="container-fluid">

        <!-- TITLE -->
        <div class="page-title">
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h3 class="mb-0">Users Orders</h3>
                </div>
                <div class="col-md-6 text-end">
                    <a href="<?= BASE_URL ?>index.php?c=adminCustomer&m=index" class="btn btn-light">
                        <i data-feather="arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="container-fluid">

        <?php if (empty($orders)): ?>
            <div class="card text-center p-4">
                <h5 class="text-muted">No orders found</h5>
            </div>
        <?php endif; ?>

        <?php foreach ($orders as $order): ?>
            <div class="card mb-4 shadow-sm border-0">

                <div class="card-body">

                    <!-- HEADER ORDER -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-0">Order #<?= $order['id'] ?></h5>
                            <small class="text-muted">
                                <?= date('d M Y H:i', strtotime($order['created_at'])) ?>
                            </small>
                        </div>

                        <div class="text-end">
                            <span class="badge bg-success">
                                <?= ucfirst($order['payment_status']) ?>
                            </span><br>
                            <small class="text-muted">
                                <?= ucfirst($order['status']) ?>
                            </small>
                        </div>
                    </div>

                    <!-- ITEMS -->
                    <div class="border rounded p-3 mb-3">

                        <?php foreach ($order['items'] as $item): ?>
                            <div class="d-flex align-items-center mb-3">

                                <img src="<?= BASE_URL ?>uploads/products/<?= $item['product_image'] ?>"
                                    width="50" height="50"
                                    class="rounded me-3"
                                    style="object-fit: cover;">

                                <div class="flex-grow-1">
                                    <div class="fw-semibold">
                                        <?= htmlspecialchars($item['product_name']) ?>
                                    </div>
                                    <small class="text-muted">
                                        <?= $item['qty'] ?> x Rp <?= number_format($item['price']) ?>
                                    </small>
                                </div>

                                <div class="fw-bold">
                                    Rp <?= number_format($item['qty'] * $item['price']) ?>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    </div>

                    <!-- FOOTER -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">

                        <div>
                            <small class="text-muted">Seller</small><br>
                            <strong><?= htmlspecialchars($order['seller_name'] ?? '-') ?></strong>
                        </div>

                        <div class="text-end">
                            <small class="text-muted">Total</small><br>
                            <h5 class="text-primary mb-0">
                                Rp <?= number_format($order['total_amount']) ?>
                            </h5>
                        </div>

                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<style>
    .card {
        border-radius: 12px;
    }

    .card:hover {
        transition: 0.3s;
        transform: translateY(-3px);
    }

    img {
        border: 1px solid #eee;
    }
</style>