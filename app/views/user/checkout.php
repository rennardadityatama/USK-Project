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
<!-- Page Body Start-->
<div class="page-body checkout">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Checkout</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
            <li class="breadcrumb-item">Ecommerce</li>
            <li class="breadcrumb-item active">Checkout</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="card">
      <div class="card-header pb-0">
        <h4>Checkout Details</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12 col-sm-12">
            <form action="<?= BASE_URL ?>index.php?c=userOrder&m=placeOrderAll"
              method="POST" enctype="multipart/form-data">

              <?php foreach ($sellers as $sellerId => $seller): ?>

                <div class="card border mb-4">
                  <div class="card-header bg-success">
                    Seller: <?= $seller['seller_name'] ?>
                  </div>

                  <div class="card-body">
                    <input type="hidden" name="seller_ids[]" value="<?= $sellerId ?>">
                    <table class="table table-borderless">
                      <thead class="table-light">
                        <tr>
                          <th width="5%">No</th>
                          <th>Product Name</th>
                          <th>Price</th>
                          <th class="text-center">QTY</th>
                          <th class="text-end">SubTotal</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($seller['items'] as $item): ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td>
                              <div class="d-flex align-items-center">
                                <?php if (!empty($item['image'])): ?>
                                  <img src="<?= BASE_URL ?>uploads/products/<?= $item['image'] ?>"
                                    class="img-fluid img-30 me-2">
                                <?php endif; ?>
                                <span><?= $item['name'] ?></span>
                              </div>
                            </td>
                            <td>Rp <?= number_format($item['price'],0,',','.') ?></td>
                            <td class="text-center"><?= $item['qty'] ?></td>
                            <td class="text-end">Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>

                      <tfoot>
                        <tr class="border-top">
                          <td colspan="3" class="text-end">
                            <strong>Total</strong>
                          </td>
                          <td class="text-end">
                            <strong class="text-primary">
                              Rp <?= number_format($seller['total'], 0, ',', '.') ?>
                            </strong>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              <?php endforeach; ?>
              <button type="submit" class="btn btn-primary w-100">
                Checkout
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>

<!-- Confirm Order Modal -->
<div class="modal fade" id="confirmOrderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="confirmMessage">Are you sure you want to place this order?</p>
        <div class="mt-3">
          <table class="table table-sm table-borderless">
            <tr>
              <td><strong>Total Amount:</strong></td>
              <td class="text-end" id="modalTotal">Rp <?= number_format($totalOrder, 0, ',', '.') ?></td>
            </tr>
            <tr>
              <td><strong>Payment Method:</strong></td>
              <td class="text-end" id="modalPayment">-</td>
            </tr>
            <tr>
              <td><strong>Payment Proof:</strong></td>
              <td class="text-end" id="modalProof">-</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary me-2 d-inline-flex align-items-center" id="confirmOrderBtn">
          <i data-feather="check-circle"></i>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Confirm Order Modal -->
<div class="modal fade" id="confirmOrderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="confirmMessage">Are you sure you want to place this order?</p>
        <div class="mt-3">
          <table class="table table-sm table-borderless">
            <tr>
              <td><strong>Total Amount:</strong></td>
              <td class="text-end" id="modalTotal">Rp <?= number_format($totalOrder, 0, ',', '.') ?></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary me-2 d-inline-flex align-items-center" id="confirmOrderBtn">
          <i data-feather="check-circle"></i>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const confirmOrderModal = new bootstrap.Modal(document.getElementById('confirmOrderModal'));
    const confirmOrderBtn = document.getElementById('confirmOrderBtn');
    const modalPayment = document.getElementById('modalPayment');
    const modalProof = document.getElementById('modalProof');
    const modalTotal = document.getElementById('modalTotal');

    let currentActiveForm = null; // Untuk menyimpan form mana yang sedang dikonfirmasi

    // 4. KONFIRMASI FINAL DI MODAL
    confirmOrderBtn.addEventListener('click', function() {
      if (currentActiveForm) {
        confirmOrderModal.hide();
        currentActiveForm.submit(); // Submit form spesifik yang tadi diklik
      }
    });
  });
</script>