<?php
$uri = current_url(true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="<?= base_url() ?>/assets/img/logo/logo4.png" rel="icon">
  <title>ZNFL OFFICIALSHOP - <?= $title; ?></title>
  <link href="<?= base_url() ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>/assets/css/ruang-admin.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
  <link href="<?= base_url() ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- <link href="https://cdn.datatables.net/v/dt/dt-2.1.4/datatables.min.css" rel="stylesheet"> -->
  <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.1.4/datatables.min.css" rel="stylesheet">

</head>

<body id="page-top">
  <?php $level = session()->get('level') ?>
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion keaktifan" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" style="background-color: #800000; color: #fff;">
        <div class="sidebar-brand-icon">
          <img src="<?= base_url() ?>/assets/img/logo/logo4.png">
        </div>
        <div class="sidebar-brand-text mx-3">ZNFL OFFICIALSHOP</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item <?= ($uri->getSegment(1) == 'dashboard' || $uri->getSegment(1) == '') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url() ?>dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Data Master
      </div>
      <?php if ($level == 'Owner') : ?>
        <li class="nav-item <?= ($uri->getSegment(1) == 'pengguna') ? 'active' : ''; ?>">
          <a class="nav-link" href="<?= base_url() ?>pengguna">
            <i class="fas fa-solid fa-users"></i>
            <span>Pengguna</span>
          </a>
        </li>
        <li class="nav-item <?= ($uri->getSegment(1) == 'supplier') ? 'active' : ''; ?>">
          <a class="nav-link" href="<?= base_url() ?>supplier">
            <!-- <i class="far fa-fw fa-window-maximize"></i> -->
            <i class="fa-solid fa-people-carry-box"></i>
            <span>Supplier</span>
          </a>
        </li>
      <?php endif ?>

      <li class="nav-item <?= ($uri->getSegment(1) == 'barang' || $uri->getSegment(1) == 'kategori' || $uri->getSegment(1) == 'sub_kategori') ? 'active' : ''; ?>">
        <a class="nav-link collapsed" href="<?= base_url() ?>/assets/#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true" aria-controls="collapseForm">
          <i class="fa-solid fa-box-open"></i>
          <span>Barang</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Data Barang</h6>
            <a class="collapse-item <?= ($uri->getSegment(1) == 'barang') ? 'active' : ''; ?>" href="<?= base_url() ?>barang">Barang</a>
            <a class="collapse-item <?= ($uri->getSegment(1) == 'kategori') ? 'active' : ''; ?>" href="<?= base_url() ?>kategori">Kategori</a>
            <a class="collapse-item <?= ($uri->getSegment(1) == 'sub_kategori') ? 'active' : ''; ?>" href="<?= base_url() ?>sub_kategori">Sub Kategori</a>
          </div>
        </div>
      </li>

      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Transaksi
      </div>
      <li class="nav-item <?= ($uri->getSegment(1) == 'barang-masuk') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url() ?>barang-masuk">
          <!-- <i class="fas fa-fw fa-columns"></i> -->
          <!-- <i class="fa-solid fa-circle-down"></i> -->
          <i class="fa-solid fa-cart-arrow-down"></i>
          <span>Barang Masuk</span>
        </a>
      </li>
      <li class="nav-item <?= ($uri->getSegment(1) == 'barang-keluar') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url() ?>barang-keluar">
          <!-- <i class="fa-solid fa-circle-up"></i> -->
          <i class="fa-solid fa-cart-arrow-up"></i>
          <span>Barang Keluar</span>
        </a>
      </li>

      <?php if ($level == 'Owner') : ?>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">
          Laporan
        </div>
        <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="<?= base_url() ?>/assets/#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true" aria-controls="collapsePage">
          <i class="fa-solid fa-book"></i>
          <span>Cetak Laporan</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= base_url() ?>">Harian</a>
            <a class="collapse-item" href="<?= base_url() ?>">Mingguan</a>
            <a class="collapse-item" href="<?= base_url() ?>">Bulanan</a>
            <a class="collapse-item" href="<?= base_url() ?>">Tahunan</a>
          </div>
        </div>
      </li> -->


        <li class="nav-item <?= ($uri->getSegment(1) == 'laporan') ? 'active' : ''; ?>">
          <a class="nav-link" href="<?= base_url() ?>laporan">
            <i class="fa-solid fa-book"></i>
            <span>Laporan</span>
          </a>
        </li>
      <?php endif ?>
    </ul>

    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top bg-gradient-danger">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="<?= base_url() ?>/assets/#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="<?= base_url() ?>/assets/img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small"><?= session()->get('nama') ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!-- <a class="dropdown-item" href="<?= base_url() ?>/assets/#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a> -->
                <a class="dropdown-item" onclick="logout()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <?= $this->renderSection('content'); ?>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script>
                document.write(new Date().getFullYear());
              </script> - ZNFL OFFICIALSHOP
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="<?= base_url() ?>/assets/#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="<?= base_url() ?>/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/ruang-admin.min.js"></script>
  <script src="<?= base_url() ?>/assets/vendor/chart.js/Chart.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/demo/chart-area-demo.js"></script>

  <!-- datatables -->
  <script src="<?= base_url() ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>

  <!-- <script src="https://cdn.datatables.net/v/dt/dt-2.1.4/datatables.min.js"></script> -->
  <script src="<?= base_url() ?>/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

  <script>
    function logout() {
      Swal.fire({
        icon: 'error',
        iconColor: '#d33',
        title: 'Logout!',
        confirmButtonColor: "#d33",
        confirmButtonText: "Iya",
        cancelButtonText: "Batal",
        showCancelButton: true,
        text: 'Anda Yakin Ingin Keluar Dari Sistem?'
      }).then((result) => {
        // Kalo diklik "Yakin!", arahin ke link lain
        if (result.isConfirmed) {
          window.location.href = '<?= site_url('login/logout') ?>';
        }
      });
    }

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

    const navLink = document.querySelectorAll('.keaktifan li');
    navLink.forEach(items => {
      items.addEventListener('click', () => {
        navLink.forEach(items => {
          if (items.classList.contains('active')) {
            items.classList.remove('active');
          };
        });
        items.classList.add('active');
      });

    });
  </script>
</body>

</html>