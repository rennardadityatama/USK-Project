<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="tivo admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, Tivo admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="pixelstrap">
  <link rel="icon" href="<?= BASE_URL ?>/assets/images/favicon/logo.png" type="image/x-icon">
  <link rel="shortcut icon" href="<?= BASE_URL ?>/assets/images/favicon/logo.png" type="image/x-icon">
  <title>Register | iTama Book</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/vendors/font-awesome.css">
  <!-- ico-font-->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/vendors/icofont.css">
  <!-- Themify icon-->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/vendors/themify.css">
  <!-- Flag icon-->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/vendors/flag-icon.css">
  <!-- Feather icon-->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/vendors/feather-icon.css">
  <!-- Bootstrap css-->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/vendors/bootstrap.css">
  <!-- App css-->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/style.css">
  <link id="color" rel="stylesheet" href="<?= BASE_URL ?>/assets/css/color-1.css" media="screen">
  <!-- Responsive css-->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/responsive.css">
</head>

<body>
  <!-- Loader starts-->
  <div class="loader-wrapper">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"> </div>
    <div class="dot"></div>
  </div>
  <!-- Loader ends-->
  <!-- login page start-->
  <div class="container-fluid p-0">
    <div class="row m-0">
      <div class="col-xl-7 p-0"><img class="bg-img-cover bg-center" src="<?= BASE_URL ?>/assets/img/bg.jpg" alt="looginpage"></div>
      <div class="col-xl-5 p-0">
        <div class="login-card" style="background: none !important; background-color: #f5f5f5 !important;">
          <div>
            <div><a class="logo text-center" href="login.php"><img class="img-fluid for-light" src="<?= BASE_URL ?>/assets/img/logo.png" alt="looginpage"></a></div>
            <div class="login-main">
              <form class="theme-form" id="registerForm" method="POST"
                action="<?= BASE_URL ?>index.php?c=auth&m=register"
                enctype="multipart/form-data">

                <input type="hidden" name="csrf_token" value="<?= Csrf::token(); ?>">

                <h4>Create your account</h4>
                <p>Enter your personal details to create account</p>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Your Name</label>
                      <input class="form-control" name="name" type="text" required placeholder="Your Name">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control" name="email" type="email" required placeholder="example@gmail.com">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Phone</label>
                      <input class="form-control" name="phone" type="text" required placeholder="0822...">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Password</label>
                      <input class="form-control" type="password" name="password" required placeholder="********">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input class="form-control" type="password" name="confirm_password" required placeholder="********">
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group">
                      <label>Address</label>
                      <input class="form-control" name="address" type="text" required placeholder="Your Address">
                    </div>
                  </div>
                </div>

                <div class="form-group mt-3">
                  <button class="btn btn-primary w-100" type="submit">Create Account</button>
                </div>

                <p class="mt-3 text-center">
                  Already have an account?
                  <a href="#" onclick="goLogin(event)">Sign in</a>
                </p>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Toast Container -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
      <div id="appToast" class="toast align-items-center text-white border-0" role="alert">
        <div class="d-flex">
          <div class="toast-body d-flex align-items-center gap-2">
            <i class="fa fa-check-circle"></i>
            <span id="toastMessage"></span>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
      </div>
    </div>

    <style>
      .login-main {
        max-width: 720px;
        /* sebelumnya 600px */
        margin: auto;
        padding: 30px 35px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      }

      .form-group {
        margin-bottom: 18px;
      }
    </style>

    <script>
      function showToast(message, type = 'success') {
        const toastEl = document.getElementById('appToast');
        const toastMsg = document.getElementById('toastMessage');

        toastEl.classList.remove('bg-success', 'bg-danger');
        toastEl.classList.add(type === 'success' ? 'bg-success' : 'bg-danger');

        toastMsg.innerText = message;

        const toast = new bootstrap.Toast(toastEl, {
          delay: 2000
        });

        toast.show();
      }

      function goLogin(e) {
        e.preventDefault();
        window.location.href = "<?= BASE_URL ?>index.php?c=auth&m=login";
      }

      document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        try {

          const res = await fetch('<?= BASE_URL ?>index.php?c=auth&m=register', {
            method: 'POST',
            body: new FormData(this)
          });

          const json = await res.json();

          showToast(json.message, json.status ? 'success' : 'danger');

          if (json.status && json.data?.redirect) {
            setTimeout(() => {
              window.location.href = json.data.redirect;
            }, 2000);
          }

        } catch (err) {
          showToast('Terjadi kesalahan server', 'danger');
        }

      });
    </script>


    <!-- latest jquery-->
    <script src="<?= BASE_URL ?>/assets/js/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap js-->
    <script src="<?= BASE_URL ?>/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- feather icon js-->
    <script src="<?= BASE_URL ?>/assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- scrollbar js-->
    <!-- Sidebar jquery-->
    <script src="<?= BASE_URL ?>/assets/js/config.js"></script>
    <!-- Template js-->
    <script src="<?= BASE_URL ?>/assets/js/script.js"></script>
    <!-- login js-->
  </div>
</body>

</html>