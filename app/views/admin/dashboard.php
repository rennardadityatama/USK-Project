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
    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-sm-6">
              <h3 class="f-w-700">Dashboard</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
                <li class="breadcrumb-item">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid dashboard-2">
        <div class="row">
          <div class="col-xl-8 col-lg-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
              <div class="card-header pb-0 border-0 bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="f-w-700 mb-0">Recent Transactions</h5>
                <span class="badge badge-light-primary text-primary">Last 5 Orders</span>
              </div>
              <div class="card-body pt-3">
                <div class="table-responsive theme-scrollbar">
                  <table class="table table-hover">
                    <thead class="bg-light">
                      <tr>
                        <th class="border-0 f-w-600 py-3">ID</th>
                        <th class="border-0 f-w-600 py-3">Customer</th>
                        <th class="border-0 f-w-600 py-3">Date</th>
                        <th class="border-0 f-w-600 py-3 text-end">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (empty($recentOrders)): ?>
                        <tr>
                          <td colspan="4" class="text-center py-4 text-muted">No recent orders found.</td>
                        </tr>
                      <?php else: ?>
                        <?php foreach (array_slice($recentOrders, 0, 5) as $order): ?>
                          <tr style="transition: all 0.3s ease;">
                            <td class="f-w-600 text-primary">#<?= $order['id'] ?></td>
                            <td>
                              <div class="f-w-600"><?= htmlspecialchars($order['customer_name']) ?></div>
                              <small class="text-muted">Verified</small>
                            </td>
                            <td class="text-muted"><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                            <td class="text-end f-w-700 text-dark">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-lg-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
              <div class="card-header pb-2 border-0 bg-transparent">
                <h5 class="f-w-700 mb-0">Selling Product</h5>
                <p class="text-muted f-12">Product</p>
              </div>
              <div class="card-body pt-0">
                <div class="table-responsive theme-scrollbar">
                  <table class="table table-bordernone mb-0">
                    <tbody>
                      <?php if (empty($bestSellingProducts)): ?>
                        <tr>
                          <td class="text-center p-4 text-muted">No sales yet</td>
                        </tr>
                      <?php else: ?>
                        <?php foreach ($bestSellingProducts as $product): ?>
                          <tr class="border-bottom-light">
                            <td class="py-3 px-3">
                              <div class="d-flex align-items-center">
                                <div class="flex-shrink-0" style="width: 45px; height: 45px; background-color: #f4f4f4; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #eee;">
                                  <img class="img-fluid"
                                    src="<?= BASE_URL ?>/uploads/products/<?= $product['image'] ?: 'default.png' ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                                </div>

                                <div class="flex-grow-1 ms-3">
                                  <div class="f-14 f-w-700 text-dark"><?= htmlspecialchars($product['name']) ?></div>
                                  <span class="text-muted f-12"><?= $product['total_sold'] ?> item</span>
                                </div>
                              </div>
                            </td>
                            <td class="text-end py-3 px-3">
                              <span class="f-w-700 f-14 text-dark">Rp.<?= number_format($product['price'], 2) ?></span>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>