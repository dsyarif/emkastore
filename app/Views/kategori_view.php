<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url() ?>barang">Barang</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>
  </div>

  <!-- Row -->
  <div class="row">

    <!-- DataTable with Hover -->
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Data Kategori</h6>
          <button data-toggle="modal" data-target="#tambah_kategori" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Tambah Data</button>
        </div>
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush table-hover" id="dataTableHover">
            <thead class="thead-light">
              <tr>
                <th style="width: 5%;">No</th>
                <th>Kategori</th>
                <th style="width: 10%; text-align: center;">Status</th>
                <th style="width: 10%;">Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Kategori</th>
                <th style="width: 10%; text-align: center;">Status</th>
                <th style="width: 10%;">Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php $no = 1;
              foreach ($kategori as $k) : ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $k['kategori']; ?></td>
                  <td style="text-align: center;"><span class="badge <?= ($k['status_kategori'] == 'Aktif') ? 'badge-success' : 'badge-danger'; ?>"><?= $k['status_kategori']; ?></span></td>
                  <td>
                    <button data-toggle="modal" data-target="#edit_kategori<?= $k['id_kategori']; ?>" class="btn btn-sm btn-warning mt-1"><i class="fa-solid fa-edit"></i></button>
                    <button onclick="hapus(<?= $k['id_kategori']; ?>)" class="btn btn-sm btn-danger mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data"><i class="fa fa-trash"></i></button>
                  </td>
                </tr>

                <!-- modal edit kategori -->
                <div class="modal fade" id="edit_kategori<?= $k['id_kategori']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Edit Kategori</b></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="card mb-4">
                          <div class="card-body">
                            <?php echo form_open('kategori/update'); ?>
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_kategori" value="<?= $k['id_kategori']; ?>">
                            <div class="form-group">
                              <label class="font-weight-bold">Kategori</label>
                              <input type="text" name="kategori" value="<?= $k['kategori']; ?>" required class="form-control" placeholder="Input Kategori...">
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold">Status Kategori</label>
                              <select name="status_kategori" required class="form-control">
                                <option label="== Pilih Status Kategori=="></option>
                                <option value="Aktif" <?= ($k['status_kategori'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                <option value="Tidak Aktif" <?= ($k['status_kategori'] == 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
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

<!-- modal tambah kategori -->
<div class="modal fade" id="tambah_kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Tambah Kategori</b></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card mb-4">
          <div class="card-body">
            <?php echo form_open('kategori/save'); ?>
            <?= csrf_field() ?>
            <div class="form-group">
              <label class="font-weight-bold">Kategori</label>
              <input type="text" name="kategori" required class="form-control" placeholder="Input Kategori...">
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
          url: `kategori/delete/${$___id}`,
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