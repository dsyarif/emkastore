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
          <h6 class="m-0 font-weight-bold text-primary">Data Barang Masuk</h6>
          <button data-toggle="modal" data-target="#tambah_barang_masuk" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Tambah Data</button>
        </div>
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush table-hover cell-border  row-border" id="dataTableHover" style=" border: 1px solid #ccc">
            <thead class="thead-light">
              <tr>
                <th style="width: 5%;">No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Suplier</th>
                <th>Harga</th>
                <th>Ket.</th>
                <th style="text-align: center;">Jumlah</th>
                <th style="text-align: center;">Total</th>
                <th>DP/Bayar</th>
                <th>Kekurangan</th>
                <th style="width: 10%;">Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Suplier</th>
                <th>Harga</th>
                <th>Ket.</th>
                <th style="text-align: center;">Jumlah</th>
                <th style="text-align: center;">Total</th>
                <th>DP/Bayar</th>
                <th>Kekurangan</th>
                <th style="width: 10%;">Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php $no = 1;

              foreach ($barang_masuk as $k) :
                $db                 = \Config\Database::connect();
                $data               = $db->table('barang_masuk_tb');
                $d_barang_masuk     = $data->join('barang_tb', 'barang_masuk_tb.kode_barang=barang_tb.kode_barang', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->where('tanggal_masuk', $k['tanggal_masuk'])->orderBy('tanggal_masuk', 'asc')->get(1000, 1)->getResultArray();
                $j_barang_masuk     = $data->join('barang_tb', 'barang_masuk_tb.kode_barang=barang_tb.kode_barang', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->where('tanggal_masuk', $k['tanggal_masuk'])->orderBy('tanggal_masuk', 'asc')->get(1000, 1)->getNumRows();
                // dd($d_barang_masuk);
              ?>
                <tr>
                  <td rowspan="<?= $j_barang_masuk + 1; ?>"><?= $no++; ?></td>
                  <td rowspan="<?= $j_barang_masuk + 1; ?>"><?= date('d M Y', strtotime($k['tanggal_masuk'])); ?></td>
                  <td><?= $k['nm_barang']; ?></td>
                  <td><?= $k['nama_supplier']; ?></td>
                  <td><?= rupiah($k['harga_beli']); ?></td>
                  <td><?= $k['ket']; ?></td>
                  <td style="text-align: center;"><?= $k['jumlah_masuk']; ?></td>
                  <td><?= rupiah($k['jumlah_masuk'] * $k['harga_beli']); ?></td>
                  <td><?= rupiah($k['bayar']); ?></td>
                  <td><?= rupiah($k['jumlah_masuk'] * $k['harga_beli'] - $k['bayar']); ?></td>
                  <td>
                    <button data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Data" data-toggle="modal" data-target="#edit_barang_masuk<?= $k['id_barang_masuk']; ?>" class="btn btn-sm btn-warning mt-1"><i class="fa-solid fa-edit"></i></button>
                    <button onclick="hapus(<?= $k['id_barang_masuk']; ?>)" class="btn btn-sm btn-danger mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data"><i class="fa fa-trash"></i></button>
                  </td>

                </tr>

                <!-- modal edit barang -->
                <div class="modal fade" id="edit_barang_masuk<?= $k['id_barang_masuk']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Edit Barang Masuk</b></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="card mb-4">
                          <div class="card-body">
                            <?php echo form_open('barang-masuk/update'); ?>
                            <?= csrf_field() ?>
                            <input type="hidden" value="<?= $k['id_barang_masuk']; ?>" name="id_barang_masuk">
                            <div class="form-group">
                              <label class="font-weight-bold">Tanggal Masuk</label>
                              <input type="date" required name="tanggal_masuk" value="<?= $k['tanggal_masuk']; ?>" class="form-control">
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Barang Masuk</label>
                              <select name="kode_barang" required class="form-control">
                                <option label="== Pilih Barang =="></option>
                                <?php foreach ($barang as $s) : ?>
                                  <option value="<?= $s['kode_barang']; ?>" <?= ($k['kode_barang'] == $s['kode_barang']) ? 'selected' : ''; ?>><?= $s['kode_barang']; ?> - <?= $s['nm_barang']; ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Stok Masuk</label>
                              <input type="number" name="jumlah_masuk" class="form-control" value="<?= $k['jumlah_masuk']; ?>" placeholder="Input Jumlah Stok Barang Masuk...">
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Keterangan</label>
                              <select name="ket" required class="form-control">
                                <option label="== Pilih Keterangan =="></option>
                                <option value="Setoran" <?= ($k['ket'] == "Setoran") ? 'selected' : ''; ?>>Setoran</option>
                                <option value="Transfer" <?= ($k['ket'] == "Transfer") ? 'selected' : ''; ?>>Transfer</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold">DP/Bayar</label>
                              <input type="number" name="bayar" class="form-control" value="<?= $k['bayar']; ?>" placeholder="Input Jumlah DP/Bayar...">
                            </div>
                            <button type="submit" class="btn btn-warning btn-block">Ubah</button>
                            </form>
                            <?= form_close() ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php if ($j_barang_masuk > 0): ?>
                  <?php foreach ($d_barang_masuk as $d): ?>
                    <tr>
                      <td><?= $d['nm_barang']; ?></td>
                      <td><?= $d['nama_supplier']; ?></td>
                      <td><?= rupiah($d['harga_beli']); ?></td>
                      <td><?= $d['ket']; ?></td>
                      <td style="text-align: center;"><?= $d['jumlah_masuk']; ?></td>
                      <td><?= rupiah($d['jumlah_masuk'] * $d['harga_beli']); ?></td>
                      <td><?= rupiah($d['bayar']); ?></td>
                      <td><?= rupiah($d['jumlah_masuk'] * $d['harga_beli'] - $d['bayar']); ?></td>
                      <td>
                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Data" data-toggle="modal" data-target="#edit_barang_masuk<?= $d['id_barang_masuk']; ?>" class="btn btn-sm btn-warning mt-1"><i class="fa-solid fa-edit"></i></button>
                        <button onclick="hapus(<?= $d['id_barang_masuk']; ?>)" class="btn btn-sm btn-danger mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data"><i class="fa fa-trash"></i></button>
                      </td>

                    </tr>

                    <div class="modal fade" id="edit_barang_masuk<?= $d['id_barang_masuk']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLabelLogout"><b>Edit Barang Masuk</b></h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="card mb-4">
                              <div class="card-body">
                                <?php echo form_open('barang-masuk/update'); ?>
                                <?= csrf_field() ?>
                                <input type="hidden" value="<?= $d['id_barang_masuk']; ?>" name="id_barang_masuk">
                                <div class="form-group">
                                  <label class="font-weight-bold">Tanggal Masuk</label>
                                  <input type="date" required name="tanggal_masuk" value="<?= $d['tanggal_masuk']; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label class="font-weight-bold">Barang Masuk</label>
                                  <select name="kode_barang" required class="form-control">
                                    <option label="== Pilih Barang =="></option>
                                    <?php foreach ($barang as $s) : ?>
                                      <option value="<?= $s['kode_barang']; ?>" <?= ($d['kode_barang'] == $s['kode_barang']) ? 'selected' : ''; ?>><?= $s['kode_barang']; ?> - <?= $s['nm_barang']; ?></option>
                                    <?php endforeach ?>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label class="font-weight-bold">Stok Masuk</label>
                                  <input type="number" name="jumlah_masuk" class="form-control" value="<?= $d['jumlah_masuk']; ?>" placeholder="Input Jumlah Stok Barang Masuk...">
                                </div>

                                <div class="form-group">
                                  <label class="font-weight-bold">Keterangan</label>
                                  <select name="ket" required class="form-control">
                                    <option label="== Pilih Keterangan =="></option>
                                    <option value="Setoran" <?= ($d['ket'] == "Setoran") ? 'selected' : ''; ?>>Setoran</option>
                                    <option value="Transfer" <?= ($d['ket'] == "Transfer") ? 'selected' : ''; ?>>Transfer</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label class="font-weight-bold">DP/Bayar</label>
                                  <input type="number" name="bayar" class="form-control" value="<?= $d['bayar']; ?>" placeholder="Input Jumlah DP/Bayar...">
                                </div>
                                <button type="submit" class="btn btn-warning btn-block">Ubah</button>
                                </form>
                                <?= form_close() ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach ?>
                <?php endif ?>
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
<div class="modal fade" id="tambah_barang_masuk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Tambah Barang Masuk</b></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card mb-4">
          <div class="card-body">
            <?php echo form_open('barang-masuk/save'); ?>
            <?= csrf_field() ?>
            <div class="form-group">
              <label class="font-weight-bold">Tanggal Masuk</label>
              <input type="date" required name="tanggal_masuk" class="form-control">
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Barang Masuk</label>
              <select name="kode_barang" required class="form-control">
                <option label="== Pilih Barang =="></option>
                <?php foreach ($barang as $s) : ?>
                  <option value="<?= $s['kode_barang']; ?>"><?= $s['kode_barang']; ?> - <?= $s['nm_barang']; ?></option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Stok Masuk</label>
              <input type="number" name="jumlah_masuk" class="form-control" placeholder="Input Jumlah Stok Barang...">
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Keterangan</label>
              <select name="ket" required class="form-control">
                <option label="== Pilih Keterangan =="></option>
                <option value="Setoran">Setoran</option>
                <option value="Transfer">Transfer</option>
              </select>
            </div>

            <div class="form-group">
              <label class="font-weight-bold">DP/Bayar</label>
              <input type="number" name="bayar" class="form-control" placeholder="Input Jumlah Jumlah DP/Bayar...">
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
      text: "Data akan dihapus secara permanen",
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Iya',
      cancelButtonText: 'Batal',
      confirmButtonColor: "#d33"
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          url: `barang-masuk/delete/${$___id}`,
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