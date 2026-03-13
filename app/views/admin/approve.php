    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"> </div>
      <div class="dot"></div>
    </div>
    <!-- Loader ends-->
    <!-- Page Body Start -->
    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-sm-6">
              <h3>Approve Orders</h3>
            </div>
            <div class="col-sm-6 text-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="<?= BASE_URL ?>index.php?c=adminDashboard&m=index"><i data-feather="home"></i></a>
                </li>
                <li class="breadcrumb-item active">Approve Orders</li>
              </ol>
            </div>
          </div>
        </div>

        <!-- Session Toast -->
        <?php if (!empty($_SESSION['toast'])): ?>
          <div class="alert alert-<?= $_SESSION['toast']['type'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['toast']['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php unset($_SESSION['toast']); ?>
        <?php endif; ?>

        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body">
                <?php if (empty($orders)): ?>
                  <div class="alert alert-info text-center"><i data-feather="info"></i> No orders found</div>
                <?php else: ?>
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="order-table">
                      <thead class="table-light">
                        <tr>
                          <th>Order ID</th>
                          <th>User</th>
                          <th>Items</th>
                          <th>Total</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($orders as $order): ?>
                          <tr>
                            <td>#<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></td>
                            <td>
                              <strong><?= htmlspecialchars($order['customer_name']) ?></strong><br>
                              <small class="text-muted"><?= htmlspecialchars($order['customer_email']) ?></small><br>
                              <small class="text-muted"><?= htmlspecialchars($order['customer_phone'] ?? '-') ?></small>
                            </td>
                            <td>
                              <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#itemsModal<?= $order['id'] ?>">
                                <?= count($order['items']) ?> item(s)
                              </button>
                            </td>
                            <td><strong class="text-success">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></strong></td>
                            <td>
                              <?php
                              $statusBadge = match ($order['status']) {
                                'pending' => '<span class="badge bg-warning">Pending</span>',
                                'completed' => '<span class="badge bg-success">Completed</span>',
                                'refund' => '<span class="badge bg-danger">Refund</span>',
                                default => '<span class="badge bg-secondary">' . ucfirst($order['status']) . '</span>'
                              };
                              echo $statusBadge;
                              ?>
                            </td>
                            <td>
                              <div class="btn-group-vertical btn-group-sm w-100">
                                <?php if ($order['status'] === 'pending'): ?>
                                  <button class="btn btn-success mb-1" onclick="openCashModal(<?= $order['id'] ?>, <?= $order['total_amount'] ?>)">
                                    Pay Cash
                                  </button>
                                <?php elseif ($order['status'] === 'completed'): ?>
                                  <button class="btn btn-primary mb-1" disabled>
                                    Selesai
                                  </button>
                                <?php endif; ?>
                              </div>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                  <nav class="mt-3">
                    <ul class="pagination justify-content-center">

                      <!-- Prev -->
                      <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?c=adminApprove&m=index&page=<?= $currentPage - 1 ?>">Prev</a>
                      </li>

                      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                          <a class="page-link" href="?c=adminApprove&m=index&page=<?= $i ?>">
                            <?= $i ?>
                          </a>
                        </li>
                      <?php endfor; ?>

                      <!-- Next -->
                      <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?c=adminApprove&m=index&page=<?= $currentPage + 1 ?>">Next</a>
                      </li>

                    </ul>
                  </nav>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modals for Items & Resi -->
    <?php foreach ($orders as $order): ?>
      <!-- Items Modal -->
      <div class="modal fade" id="itemsModal<?= $order['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5>Order #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?> Items</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <table class="table table-bordered table-striped mb-0">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($order['items'] as $item): ?>
                    <tr>
                      <td><?= htmlspecialchars($item['product_name']) ?></td>
                      <td><?= $item['qty'] ?></td>
                      <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                      <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <?php endforeach; ?>
      <!-- Resi Modal -->
      <div class="modal fade" id="cashModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form method="POST" action="<?= BASE_URL ?>index.php?c=adminApprove&m=approveOrder">
              <div class="modal-header">
                <h5>Cash Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="order_id" id="cashOrderId">
                <div class="mb-3">
                  <label>Total</label>
                  <input type="text" id="cashTotal" class="form-control" readonly>
                </div>
                <div class="mb-3">
                  <label>Customer Money</label>
                  <input type="number" name="cash_paid" id="cashPaid" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Change</label>
                  <input type="text" id="cashChange" class="form-control" readonly>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Confirm Payment</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalTitle">Confirm Action</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p id="deleteMessage">Are you sure?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <form id="deleteForm" method="POST">
              <input type="hidden" name="order_id" id="deleteOrderId" value="">
              <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Yes</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Preview QRIS -->
    <div class="modal fade" id="qrisModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header border-0">
            <h5 class="modal-title">Payment Proof Preview</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <img id="qrisPreview" src="" class="img-fluid rounded" style="max-height:360px;">
          </div>
        </div>
      </div>
    </div>

    <style>
      #order-table td:last-child {
        width: 150px;
      }

      .action-box {
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .countdown-box {
        width: 100%;
        border: 1px dashed #dc3545;
        border-radius: 6px;
        padding: 6px;
        text-align: center;
        font-size: 13px;
        background: #fff5f5;
      }
    </style>

    <script>
      function openCashModal(orderId, total) {
        document.getElementById('cashOrderId').value = orderId;
        document.getElementById('cashTotal').value = total;
        document.getElementById('cashPaid').value = '';
        document.getElementById('cashChange').value = '';
        const modal = new bootstrap.Modal(document.getElementById('cashModal'));
        modal.show();
      }
      document.getElementById('cashPaid').addEventListener('input', function() {
        let paid = parseInt(this.value) || 0;
        let total = parseInt(document.getElementById('cashTotal').value);
        let change = paid - total;
        document.getElementById('cashChange').value =
          change >= 0 ? change : 0;
      });

      function approveOrder(orderId) {
        if (confirm("Approve order #" + orderId + "?")) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '<?= BASE_URL ?>index.php?c=adminApprove&m=approveOrder';
          const input = document.createElement('input');
          input.name = 'order_id';
          input.value = orderId;
          form.appendChild(input);
          document.body.appendChild(form);
          form.submit();
        }
      }
    </script>