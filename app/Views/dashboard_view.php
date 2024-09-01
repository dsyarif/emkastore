<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>/assets/./">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
  </div>

  <div class="row mb-3">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Jenis Barang</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jml_barang; ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                <span>Since last month</span> -->
              </div>
            </div>
            <div class="col-auto">
              <!-- <i class="fas fa-calendar fa-2x text-primary"></i> -->
              <i class="fa-solid fa-box-open fa-2x text-primary"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- New User Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Supplier</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $supplier; ?></div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                <span>Since last month</span> -->
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-info"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Barang Masuk</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= empty($jml_barang_masuk[0]['jumlah_masuk']) ? 0 : $jml_barang_masuk[0]['jumlah_masuk'];; ?> Pcs</div>
              <!-- <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stok_barang[0]['stok'] + $jml_barang_masuk[0]['jumlah_masuk'] - $jml_barang_keluar[0]['jumlah_keluar']; ?> Pcs</div> -->
              <div class="mt-2 mb-0 text-muted text-xs">
                <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                <span>Since last years</span> -->
              </div>
            </div>
            <div class="col-auto">
              <i class="fa-solid fa-box-archive fa-2x text-success"></i>
              <!-- <i class="fas fa-shopping-cart fa-2x text-success"></i> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Barang Keluar</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= empty($jml_barang_keluar[0]['jumlah_keluar']) ? 0 : $jml_barang_keluar[0]['jumlah_keluar'];; ?> Pcs</div>
              <div class="mt-2 mb-0 text-muted text-xs">
                <!-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                <span>Since yesterday</span> -->
              </div>
            </div>
            <div class="col-auto">
              <!-- <i class="fas fa-comments fa-2x text-warning"></i> -->
              <i class="fa-solid fa-boxes-packing fa-2x text-warning"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Pie Chart -->
    <!-- Invoice Example -->
    <div class="col-xl-12 col-lg-12 mb-4">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Data Barang dengan Jumlah Stok Kurang dari 10 pcs</h6>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Stok</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $db      = \Config\Database::connect();
              $masuk = $db->table('barang_masuk_tb');
              $keluar = $db->table('barang_keluar_tb');
              $no = 1;
              foreach ($data_barang as $k) : ?>
                <?php
                $data_masuk  = $masuk->selectSum('jumlah_masuk')->where('kode_barang', $k['kode_barang'])->get()->getRow();
                $data_keluar = $keluar->selectSum('jumlah_keluar')->where('kode_barang', $k['kode_barang'])->get()->getRow();

                if ($data_masuk->jumlah_masuk > 0) {
                  $jml_stok_masuk = $data_masuk->jumlah_masuk;
                } else {
                  $jml_stok_masuk = 0;
                }

                if ($data_keluar->jumlah_keluar > 0) {
                  $jml_stok_keluar = $data_keluar->jumlah_keluar;
                } else {
                  $jml_stok_keluar = 0;
                }

                $stok = ($k['stok'] + $jml_stok_masuk) - $jml_stok_keluar;
                ?>
                <?php if ($stok < 10) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $k['kode_barang']; ?></td>
                    <td><?= $k['nm_barang']; ?></td>
                    <td><?= $stok; ?></td>
                  </tr>
                <?php endif ?>
              <?php endforeach ?>

            </tbody>
          </table>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>

  <!-- Modal Logout -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to logout?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
          <a href="<?= base_url() ?>/assets/login.html" class="btn btn-primary">Logout</a>
        </div>
      </div>
    </div>
  </div>

</div>
<?= $this->endSection(); ?>