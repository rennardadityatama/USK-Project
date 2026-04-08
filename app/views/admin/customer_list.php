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
<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row align-items-center mb-3">
        <div class="col-md-6">
          <h3 class="mb-0">Users List</h3>
        </div>
        <!-- <div class="col-sm-6 text-end">
          <button class="btn btn-primary" id="btnAddCustomer">Add Customer</button>
        </div> -->
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fa fa-search"></i>
            </span>
            <input id="searchCustomer"
              class="form-control"
              type="text"
              placeholder="Search Name or Email...">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row g-4" id="customerCards">

      <?php foreach ($customers as $customer): ?>
        <div class="col-xl-4 col-lg-6">
          <div class="card h-100 border-0 shadow-sm hover-card">

            <div class="card-body d-flex flex-column">

              <!-- HEADER -->
              <div class="d-flex align-items-center mb-3">
                <div class="avatar-circle me-3">
                  <?= strtoupper(substr($customer['name'], 0, 1)) ?>
                </div>

                <div>
                  <h5 class="mb-0 fw-bold">
                    <?= htmlspecialchars($customer['name']) ?>
                  </h5>
                  <small class="text-muted">Customer</small>
                </div>
              </div>

              <!-- INFO -->
              <div class="mb-3">
                <div class="mb-2">
                  <small class="text-muted d-block">Email</small>
                  <span><?= htmlspecialchars($customer['email']) ?></span>
                </div>

                <?php if (!empty($customer['phone'])): ?>
                  <div>
                    <small class="text-muted d-block">Phone</small>
                    <span><?= htmlspecialchars($customer['phone']) ?></span>
                  </div>
                <?php endif; ?>
              </div>

              <!-- ACTION -->
              <div class="mt-auto pt-3 border-top text-center">
                <a href="<?= BASE_URL ?>index.php?c=adminOrder&m=byCustomer&id=<?= $customer['id'] ?>"
                  class="btn btn-primary w-100">
                  <i data-feather="shopping-cart"></i> View Orders
                </a>
              </div>

            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>

<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
  <div id="toastContainer"></div>
</div>

<style>
  .avatar-circle {
    width: 45px;
    height: 45px;
    background: #7366ff;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
  }
</style>

<script>
  const searchInput = document.getElementById("searchCustomer");

  searchInput.addEventListener("keyup", function() {

    const keyword = this.value.toLowerCase();
    const cards = document.querySelectorAll("#customerCards .col-xl-4");

    cards.forEach(card => {

      const name = card.querySelector(".customer-name")?.textContent.toLowerCase() || "";
      const email = card.querySelector(".customer-email")?.textContent.toLowerCase() || "";
      const nik = card.querySelector(".customer-nik")?.textContent.toLowerCase() || "";

      if (
        name.includes(keyword) ||
        email.includes(keyword) ||
        nik.includes(keyword)
      ) {
        card.style.display = "";
      } else {
        card.style.display = "none";
      }

    });

  });
</script>