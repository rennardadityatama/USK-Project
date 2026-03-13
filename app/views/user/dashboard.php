<div class="tap-top"><i data-feather="chevrons-up"></i></div>

<!-- Loader starts-->
<div class="loader-wrapper">
  <div class="dot"></div>
  <div class="dot"></div>
  <div class="dot"></div>
  <div class="dot"></div>
  <div class="dot"></div>
</div>
<!-- Loader ends-->

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Dashboard</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#"><i data-feather="home"></i></a>
            </li>
            <li class="breadcrumb-item">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid dashboard-2">
    <div class="row">

      <!-- ABOUT US -->
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0 d-flex justify-content-between">
            <h5>About iTama Book</h5>
            <i data-feather="book-open" class="txt-primary"></i>
          </div>

          <div class="card-body">

            <div class="row align-items-center">

              <div class="col-md-8">
                <h4 class="mb-2">Welcome to iTama Book</h4>

                <p class="text-muted mb-3">
                  iTama Book adalah platform toko buku online yang memudahkan pelanggan
                  untuk menemukan, membeli, dan melacak pengiriman buku dengan cepat dan aman.
                  Sistem ini juga menyediakan dashboard admin untuk mengelola pesanan,
                  pelanggan, produk, serta pengiriman secara efisien.
                </p>
              </div>

              <div class="col-md-4 text-center">
                <i data-feather="shopping-cart" style="width:70px;height:70px;" class="txt-primary mb-2"></i>
                <h5 class="mt-2">Online Bookstore System</h5>
                <p class="text-muted mb-0">Fast • Secure • Easy to Manage</p>
              </div>

            </div>

          </div>
        </div>
      </div>


      <!-- RECENT ORDERS -->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header d-flex align-items-center gap-2 pb-0">
            <i data-feather="clock" class="txt-warning"></i>
            <h5 class="mb-0">Recent Orders</h5>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm mb-0">
                <thead>
                  <tr>
                    <th>Order ID</th>
                    <th class="text-end">Status</th>
                  </tr>
                </thead>

                <tbody>
                  <?php foreach ($recent_orders as $order): ?>
                    <tr>
                      <td class="f-w-600">#INV-<?= $order['id'] ?></td>
                      <td class="text-end">
                        <span class="badge badge-light-info">
                          <?= ucfirst($order['status']) ?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>


      <!-- RECENT PAYMENTS -->
      <div class="col-sm-12">
        <div class="card">

          <div class="card-header pb-0 d-flex justify-content-between">
            <h5>Recent Payment Status</h5>
            <i data-feather="credit-card" class="txt-primary"></i>
          </div>

          <div class="card-body">
            <div class="table-responsive theme-scrollbar">

              <table class="table table-bordernone">

                <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Order Date</th>
                    <th>Payment Status</th>
                  </tr>
                </thead>

                <tbody>
                  <?php foreach ($recent_payments as $ship): ?>
                    <tr>
                      <td>
                        <span class="f-w-600">
                          #INV-<?= str_pad($ship['id'], 5, '0', STR_PAD_LEFT) ?>
                        </span>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <?php
                          $image = !empty($ship['product_image'])
                            ? BASE_URL . "uploads/products/" . $ship['product_image']
                            : BASE_URL . "assets/images/no-image.png";
                          ?>
                          <img class="img-30 me-2"
                            src="<?= $image ?>"
                            style="width:35px;height:35px;object-fit:cover;border-radius:5px;">
                          <span><?= $ship['product_name'] ?></span>
                        </div>
                      </td>
                      <td>
                        <?= date('d M Y', strtotime($ship['created_at'])) ?>
                      </td>
                      <td>
                        <span class="badge badge-light-success">
                          <?= ucfirst($ship['payment_status']) ?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>