<?php
function rupiah($duit)
{
  $hasil = "Rp." . number_format($duit, 0, ',', '.');
  return $hasil;
}
?>
<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
  </div>

  <!-- Row -->
  <div class="row">

    <!-- DataTable with Hover -->
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
          <button data-toggle="modal" data-target="#tambah_barang" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Tambah Data</button>
        </div>
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush table-hover" id="dataTableHover">
            <thead class="thead-light">
              <tr>
                <th style="width: 5%;">No</th>
                <th>Barang</th>
                <th>Stok</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Supplier</th>
                <th style="width: 10%;">Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Barang</th>
                <th>Stok</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Supplier</th>
                <th style="width: 10%;">Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $db      = \Config\Database::connect();
              $masuk = $db->table('barang_masuk_tb');
              $keluar = $db->table('barang_keluar_tb');
              $no = 1;
              foreach ($barang as $k) : ?>
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
                $stok = ($jml_stok_masuk) - $jml_stok_keluar;
                ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $k['nm_barang']; ?></td>
                  <td><?= $stok; ?></td>
                  <td><?= rupiah($k['harga_beli']); ?></td>
                  <td><?= rupiah($k['harga_jual']); ?></td>
                  <td><?= $k['kategori']; ?></td>
                  <td><?= $k['sub_kategori']; ?></td>
                  <td><?= $k['nama_supplier']; ?></td>
                  <td>
                    <button data-toggle="modal" data-target="#edit_barang<?= $k['kode_barang']; ?>" class="btn btn-sm btn-warning mt-1"><i class="fa-solid fa-edit"></i></button>
                    <button onclick="hapus(<?= $k['id_barang']; ?>)" class="btn btn-sm btn-danger mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data"><i class="fa fa-trash"></i></button>
                  </td>
                </tr>

                <!-- modal edit barang -->
                <div class="modal fade" id="edit_barang<?= $k['kode_barang']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Edit Barang</b></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="card mb-4">
                          <div class="card-body">
                            <?php echo form_open('barang/update'); ?>
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_barang" value="<?= $k['id_barang']; ?>">
                            <div class="form-group">
                              <label class="font-weight-bold">Kode Barang</label>
                              <input type="text" name="kode_barang" required class="form-control" value="<?= $k['kode_barang']; ?>" readonly>
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold">Barang</label>
                              <input type="text" name="nm_barang" value="<?= $k['nm_barang']; ?>" required class="form-control" placeholder="Input Barang...">
                            </div>

                            <!-- <div class="form-group">
                              <label class="font-weight-bold">Stok</label>
                              <input type="number" name="stok" class="form-control" value="<?= $k['stok']; ?>" placeholder="Input Stok Awal...">
                            </div> -->

                            <div class="form-group">
                              <label class="font-weight-bold">Harga Satuan (Beli)</label>
                              <input type="number" required name="harga_beli" class="form-control" value="<?= $k['harga_beli']; ?>" placeholder="Input Harga Satuan Beli...">
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold">Harga Satuan (Jual)</label>
                              <input type="number" required name="harga_jual" class="form-control" value="<?= $k['harga_jual']; ?>" placeholder="Input Harga Satuan Jual...">
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Kategori</label>
                              <select name="id_kategori" required class="form-control">
                                <option label="== Pilih Kategori =="></option>
                                <?php foreach ($kategori as $s) : ?>
                                  <option value="<?= $s['id_kategori']; ?>" <?= ($k['id_kategori'] == $s['id_kategori']) ? 'selected' : ''; ?>><?= $s['kategori']; ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Sub Kategori</label>
                              <select name="id_sub_kategori" required class="form-control">
                                <option label="== Pilih Sub Kategori =="></option>
                                <?php foreach ($sub_kategori as $s) : ?>
                                  <option value="<?= $s['id_sub_kategori']; ?>" <?= ($k['id_sub_kategori'] == $s['id_sub_kategori']) ? 'selected' : ''; ?>><?= $s['sub_kategori']; ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Supplier</label>
                              <select name="id_supplier" required class="form-control">
                                <option label="== Pilih Supplier =="></option>
                                <?php foreach ($supplier as $s) : ?>
                                  <option value="<?= $s['id_supplier']; ?>" <?= ($k['id_supplier'] == $s['id_supplier']) ? 'selected' : ''; ?>><?= $s['nama_supplier']; ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                            </form>
                            <?= form_close() ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!--Row-->
</div>

<!-- modal tambah barang -->
<div class="modal fade" id="tambah_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Tambah Barang</b></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card mb-4">
          <div class="card-body">
            <?php echo form_open('barang/save'); ?>
            <?= csrf_field() ?>
            <div class="form-group">
              <label class="font-weight-bold">Kode Barang</label>
              <input type="hidden" value="<?= $kode; ?>" name="kode_barang">
              <input type="text" class="form-control" value="<?= $kode; ?>" readonly>
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Nama Barang</label>
              <input type="text" name="nm_barang" required class="form-control" placeholder="Input Nama Barang...">
            </div>

            <!-- <div class="form-group">
              <label class="font-weight-bold">Stok</label>
              <input type="number" name="stok" class="form-control" placeholder="Input Stok Awal...">
            </div> -->

            <div class="form-group">
              <label class="font-weight-bold">Harga Satuan (Beli)</label>
              <input type="number" required name="harga_beli" class="form-control" placeholder="Input Harga Satuan (Beli)...">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Harga Satuan (Jual)</label>
              <input type="number" required name="harga_jual" class="form-control" placeholder="Input Harga Satuan (Jual)...">
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Kategori</label>
              <select name="id_kategori" required class="form-control">
                <option label="== Pilih Kategori =="></option>
                <?php foreach ($kategori as $s) : ?>
                  <option value="<?= $s['id_kategori']; ?>"><?= $s['kategori']; ?></option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Sub Kategori</label>
              <select name="id_sub_kategori" required class="form-control">
                <option label="== Pilih Sub Kategori =="></option>
                <?php foreach ($sub_kategori as $s) : ?>
                  <option value="<?= $s['id_sub_kategori']; ?>"><?= $s['sub_kategori']; ?></option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Supplier</label>
              <select name="id_supplier" required class="form-control">
                <option label="== Pilih Supplier =="></option>
                <?php foreach ($supplier as $s) : ?>
                  <option value="<?= $s['id_supplier']; ?>"><?= $s['nama_supplier']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
            </form>
            <?= form_close() ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function hapus($___id) {
    swal.fire({
      icon: 'warning',
      iconColor: '#d33',
      title: 'Hapus Data?',
      text: "Data Barang Masuk dan Barang Keluar akan dihapus secara permanen juga",
      showCancelButton: true,
      confirmButtonText: 'Iya',
      cancelButtonText: 'Batal',
      confirmButtonColor: "#d33"
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          url: `barang/delete/${$___id}`,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            swal.fire({
              icon: 'success',
              // type: 'success',
              iconColor: '#d33',
              title: response.message,
              // showConfirmButton: false,
              confirmButtonColor: "#d33",
              timer: 2000
            }).then(function() {
              location.reload();
            });
          }
        });
      }
    });
  }
</script>
<?= $this->endSection(); ?>