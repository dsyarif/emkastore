<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link href="<?= base_url() ?>assets/img/logo/logo.png" rel="icon"> -->
  <link href="<?= base_url() ?>/assets/img/logo/logo4.png" rel="icon">
  <title>Emkastore - Login</title>
  <link href="<?= base_url() ?>assets/<?= base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>assets/css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <img src="<?= base_url() ?>/assets/img/logo/logo4.png" alt="Logo" width="15%">
                    <h1 class="h4 text-gray-900 mb-4 mt-2">Login <strong>Emka Store</strong> </h1>
                  </div>
                  <form action="<?= base_url() ?>login/ceklogin" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control" required name="username" placeholder="Input Username">
                    </div>
                    <div class="form-group">
                      <input type="password" required name="password" class="form-control" placeholder="Input Password">
                    </div>
                    <div class="form-group">
                      <select class="form-control" required name="level">
                        <option label="== Pilih Level =="></option>
                        <option value="Owner">Owner</option>
                        <option value="Admin">Admin</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?= base_url() ?>assets/js/ruang-admin.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    <?php if (session()->has("success")) { ?>
      Swal.fire({
        icon: 'success',
        iconColor: '#6777EF',
        title: 'Selamat!',
        showConfirmButton: false,
        timer: 2000,
        text: '<?= session("success") ?>'
      })
    <?php } ?>
    <?php if (session()->has("danger")) { ?>
      Swal.fire({
        icon: 'error',
        iconColor: '#6777EF',
        title: 'Mohon Maaf!',
        showConfirmButton: false,
        timer: 3000,
        text: '<?= session("danger") ?>'
      })
    <?php } ?>
  </script>
</body>

</html>