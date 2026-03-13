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
          <div class="card shadow-sm h-100 border-0">
            <!-- BODY -->
            <div class="card-body">

              <div class="d-flex align-items-center mb-3">
                <div>
                  <h5 class="mb-0 fw-bold customer-name">
                    <?= htmlspecialchars($customer['name']) ?>
                  </h5>
                  <small class="text-muted fs-6">Customer</small>
                </div>

              </div>

              <ul class="list-unstyled mb-3">
                <li class="mb-2 fs-6 customer-email">
                  <strong>Email:</strong><br>
                  <?= htmlspecialchars($customer['email']) ?>
                </li>
                <?php if (!empty($customer['phone'])): ?>
                  <li class="mb-2 fs-6">
                    <strong>Phone:</strong><br>
                    <?= htmlspecialchars($customer['phone']) ?>
                  </li>
                <?php endif; ?>
              </ul>
              <!-- TOTAL ORDERS -->
              <div class="border-top pt-2 mt-2 text-center">
                <span class="badge bg-primary fs-6 px-3 py-2">
                  Total Orders : <?= $customer['total_orders'] ?>
                </span>
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