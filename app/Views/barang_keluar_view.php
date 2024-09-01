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
          <h6 class="m-0 font-weight-bold text-primary">Data Barang Keluar</h6>
          <button data-toggle="modal" data-target="#tambah_barang_keluar" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Tambah Data</button>
        </div>
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush table-hover cell-border  row-border" id="dataTableHover" style=" border: 1px solid #ccc">
            <thead class="thead-light" style="vertical-align: center;">
              <tr>
                <th style="width: 5%;">No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Harga Satuan</th>
                <th style="text-align: center;">Jumlah</th>
                <th>Harga Total</th>
                <th style="text-align: center;">Pajak</th>
                <th>Keuntungan</th>
                <!-- <th style="text-align: center;">Keterangan</th> -->
                <th style="width: 10%;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($barang_keluar as $k) :
                $harga_jual = $k['jumlah_keluar'] * $k['harga_jual'];
                $harga_beli = $k['jumlah_keluar'] * $k['harga_beli'];
                $pajak = $harga_jual * ($k['pajak'] / 100);
                $keuntungan = ($harga_jual - $harga_beli) - $pajak;

                $db                 = \Config\Database::connect();
                $data               = $db->table('barang_keluar_tb');
                $d_barang_keluar     = $data->join('barang_tb', 'barang_keluar_tb.kode_barang=barang_tb.kode_barang', 'left')->where('tanggal_keluar', $k['tanggal_keluar'])->orderBy('tanggal_keluar', 'asc')->get(1000, 1)->getResultArray();
                $j_barang_keluar     = $data->join('barang_tb', 'barang_keluar_tb.kode_barang=barang_tb.kode_barang', 'left')->where('tanggal_keluar', $k['tanggal_keluar'])->orderBy('tanggal_keluar', 'asc')->get(1000, 1)->getNumRows();
                // dd($d_barang_keluar);
              ?>
                <tr>
                  <td rowspan="<?= $j_barang_keluar + 1; ?>"><?= $no++; ?></td>
                  <td rowspan="<?= $j_barang_keluar + 1; ?>"><?= date('d M Y', strtotime($k['tanggal_keluar'])); ?></td>
                  <td><?= $k['nm_barang']; ?></td>
                  <td><?= rupiah($k['harga_jual']); ?></td>
                  <td style="text-align: center;"><?= $k['jumlah_keluar']; ?></td>
                  <td><?= rupiah($harga_jual); ?></td>
                  <td style="text-align: center;">
                    <?php if ($k['pajak'] == 0): ?>
                      0%
                    <?php else: ?>
                      <?= $k['pajak']; ?>% (<?= rupiah($pajak); ?>)
                    <?php endif ?>
                  </td>
                  <td><?= rupiah($keuntungan); ?></td>
                  <!-- <td style="text-align: center;"><span class="badge <?= ($k['keterangan'] == 'Terjual') ? 'badge-success' : 'badge-danger'; ?>"><?= $k['keterangan']; ?></span></td> -->
                  <td>
                    <button data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Data" data-toggle="modal" data-target="#edit_barang_keluar<?= $k['id_barang_keluar']; ?>" class="btn btn-sm btn-warning mt-1"><i class="fa-solid fa-edit"></i></button>
                    <button onclick="hapus(<?= $k['id_barang_keluar']; ?>)" class="btn btn-sm btn-danger mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data"><i class="fa fa-trash"></i></button>
                  </td>
                </tr>

                <!-- modal edit barang -->
                <div class="modal fade" id="edit_barang_keluar<?= $k['id_barang_keluar']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Edit Barang Keluar</b></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="card mb-4">
                          <div class="card-body">
                            <?php echo form_open('barang-keluar/update'); ?>
                            <?= csrf_field() ?>
                            <input type="hidden" value="<?= $k['id_barang_keluar']; ?>" name="id_barang_keluar">
                            <div class="form-group">
                              <label class="font-weight-bold">Tanggal Keluar</label>
                              <input type="date" required name="tanggal_keluar" value="<?= $k['tanggal_keluar']; ?>" class="form-control">
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Barang Keluar</label>
                              <select name="kode_barang" required class="form-control">
                                <option label="== Pilih Barang =="></option>
                                <?php foreach ($barang as $s) : ?>
                                  <option value="<?= $s['kode_barang']; ?>" <?= ($k['kode_barang'] == $s['kode_barang']) ? 'selected' : ''; ?>><?= $s['kode_barang']; ?> - <?= $s['nm_barang']; ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Stok Keluar</label>
                              <input type="number" name="jumlah_keluar" class="form-control" value="<?= $k['jumlah_keluar']; ?>" required placeholder="Input Jumlah Stok Barang Keluar...">
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Pajak (%)</label>
                              <input type="number" name="pajak" class="form-control" value="<?= $k['pajak']; ?>">
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Keterangan</label>
                              <select name="keterangan" required class="form-control">
                                <option label="== Pilih Keterangan =="></option>
                                <option value="Terjual" <?= ($k['keterangan'] == 'Terjual') ? 'selected' : ''; ?>>Terjual</option>
                                <option value="Barang Rusak" <?= ($k['keterangan'] == 'Barang Rusak') ? 'selected' : ''; ?>>Barang Rusak</option>
                              </select>
                            </div>

                            <div class="form-group">
                              <label class="font-weight-bold">Alasan (Opsional jika barang rusak)</label>
                              <input type="text" name="alasan" class="form-control" value="<?= $k['alasan']; ?>" placeholder="Input Alasan...">
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


                <?php if ($j_barang_keluar > 0): ?>
                  <?php foreach ($d_barang_keluar as $d):
                    $harga_jual = $d['jumlah_keluar'] * $d['harga_jual'];
                    $harga_beli = $d['jumlah_keluar'] * $d['harga_beli'];
                    $pajak = $harga_jual * ($d['pajak'] / 100);
                    $keuntungan = ($harga_jual - $harga_beli) - $pajak;
                  ?>
                    <tr>
                      <td><?= $d['nm_barang']; ?></td>
                      <td><?= rupiah($d['harga_jual']); ?></td>
                      <td style="text-align: center;"><?= $d['jumlah_keluar']; ?></td>
                      <td><?= rupiah($harga_jual); ?></td>
                      <td style="text-align: center;">
                        <?php if ($d['pajak'] == 0): ?>
                          0%
                        <?php else: ?>
                          <?= $d['pajak']; ?>% (<?= rupiah($pajak); ?>)
                        <?php endif ?>
                      </td>
                      <td><?= rupiah($keuntungan); ?></td>
                      <!-- <td style="text-align: center;"><span class="badge <?= ($d['keterangan'] == 'Terjual') ? 'badge-success' : 'badge-danger'; ?>"><?= $d['keterangan']; ?></span></td> -->
                      <td>
                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Data" data-toggle="modal" data-target="#edit_barang_keluar<?= $d['id_barang_keluar']; ?>" class="btn btn-sm btn-warning mt-1"><i class="fa-solid fa-edit"></i></button>
                        <button onclick="hapus(<?= $d['id_barang_keluar']; ?>)" class="btn btn-sm btn-danger mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>

                    <!-- modal edit barang -->
                    <div class="modal fade" id="edit_barang_keluar<?= $d['id_barang_keluar']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLabelLogout"><b>Edit Barang Keluar</b></h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="card mb-4">
                              <div class="card-body">
                                <?php echo form_open('barang-keluar/update'); ?>
                                <?= csrf_field() ?>
                                <input type="hidden" value="<?= $d['id_barang_keluar']; ?>" name="id_barang_keluar">
                                <div class="form-group">
                                  <label class="font-weight-bold">Tanggal Keluar</label>
                                  <input type="date" required name="tanggal_keluar" value="<?= $d['tanggal_keluar']; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label class="font-weight-bold">Barang Keluar</label>
                                  <select name="kode_barang" required class="form-control">
                                    <option label="== Pilih Barang =="></option>
                                    <?php foreach ($barang as $s) : ?>
                                      <option value="<?= $s['kode_barang']; ?>" <?= ($d['kode_barang'] == $s['kode_barang']) ? 'selected' : ''; ?>><?= $s['kode_barang']; ?> - <?= $s['nm_barang']; ?></option>
                                    <?php endforeach ?>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label class="font-weight-bold">Stok Keluar</label>
                                  <input type="number" name="jumlah_keluar" class="form-control" value="<?= $d['jumlah_keluar']; ?>" required placeholder="Input Jumlah Stok Barang Keluar...">
                                </div>

                                <div class="form-group">
                                  <label class="font-weight-bold">Pajak (%)</label>
                                  <input type="number" name="pajak" class="form-control" value="<?= $d['pajak']; ?>">
                                </div>

                                <div class="form-group">
                                  <label class="font-weight-bold">Keterangan</label>
                                  <select name="keterangan" required class="form-control">
                                    <option label="== Pilih Keterangan =="></option>
                                    <option value="Terjual" <?= ($d['keterangan'] == 'Terjual') ? 'selected' : ''; ?>>Terjual</option>
                                    <option value="Barang Rusak" <?= ($d['keterangan'] == 'Barang Rusak') ? 'selected' : ''; ?>>Barang Rusak</option>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label class="font-weight-bold">Alasan (Opsional jika barang rusak)</label>
                                  <input type="text" name="alasan" class="form-control" value="<?= $d['alasan']; ?>" placeholder="Input Alasan...">
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
<div class="modal fade" id="tambah_barang_keluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Tambah Barang Keluar</b></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card mb-4">
          <div class="card-body">
            <?php echo form_open('barang-keluar/save'); ?>
            <?= csrf_field() ?>
            <div class="form-group">
              <label class="font-weight-bold">Tanggal Keluar</label>
              <input type="date" required name="tanggal_keluar" class="form-control">
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Barang Keluar</label>
              <select name="kode_barang" required class="form-control">
                <option label="== Pilih Barang =="></option>
                <?php foreach ($barang as $s) : ?>
                  <option value="<?= $s['kode_barang']; ?>"><?= $s['kode_barang']; ?> - <?= $s['nm_barang']; ?></option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Stok Keluar</label>
              <input type="number" name="jumlah_keluar" required class="form-control" placeholder="Input Jumlah Stok Barang...">
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Pajak (%)</label>
              <input type="number" name="pajak" class="form-control">
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Keterangan</label>
              <select name="keterangan" required class="form-control">
                <option label="== Pilih Keterangan =="></option>
                <option value="Terjual">Terjual</option>
                <option value="Barang Rusak">Barang Rusak</option>
              </select>
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Alasan (Opsional jika barang rusak)</label>
              <input type="text" name="alasan" class="form-control" placeholder="Input Alasan...">
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
          url: `barang-keluar/delete/${$___id}`,
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