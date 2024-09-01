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
          <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
          <button data-toggle="modal" data-target="#tambah_pengguna" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Tambah Data</button>
        </div>
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush table-hover" id="dataTableHover">
            <thead class="thead-light">
              <tr>
                <th style="width: 5%;">No</th>
                <th>Nama</th>
                <th>Level</th>
                <th style="width: 10%;">Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Level</th>
                <th style="width: 10%;">Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php $no = 1;
              foreach ($pengguna as $p) : ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $p['nama']; ?></td>
                  <td><?= $p['level']; ?></td>
                  <td>
                    <button data-toggle="modal" data-target="#edit_pengguna<?= $p['id_pengguna']; ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-edit"></i></button>
                  </td>
                </tr>

                <!-- modal edit pengguna -->
                <div class="modal fade" id="edit_pengguna<?= $p['id_pengguna']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Edit Pengguna</b></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="card mb-4">
                          <div class="card-body">
                            <?php echo form_open('pengguna/update'); ?>
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_pengguna" value="<?= $p['id_pengguna']; ?>">
                            <div class="form-group">
                              <label class="font-weight-bold">Nama Pengguna</label>
                              <input type="text" name="nama" value="<?= $p['nama']; ?>" required class="form-control" placeholder="Input Nama Pengguna...">
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold">Username</label>
                              <input type="text" name="username" value="<?= $p['username']; ?>" required class="form-control" placeholder="Input Username...">
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold">Level</label>
                              <select name="level" class="form-control">
                                <option value="Admin" <?= ($p['level'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="Owner" <?= ($p['level'] == 'Owner') ? 'selected' : ''; ?>>Owner</option>
                              </select>
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
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!--Row-->
</div>

<!-- modal tambah pengguna -->
<div class="modal fade" id="tambah_pengguna" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Tambah Pengguna</b></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card mb-4">
          <div class="card-body">
            <?php echo form_open('pengguna/save'); ?>
            <?= csrf_field() ?>
            <div class="form-group">
              <label class="font-weight-bold">Nama Pengguna</label>
              <input type="text" name="nama" required class="form-control" placeholder="Input Nama Pengguna...">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Username</label>
              <input type="text" name="username" required class="form-control" placeholder="Input Username Pengguna...">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Password</label>
              <input type="password" name="password" required class="form-control" placeholder="Input Password Pengguna...">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Level</label>
              <select name="level" class="form-control" required>
                <option label="== Pilih Level =="></option>
                <option value="Admin">Admin</option>
                <option value="Owner">Owner</option>
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

</script>
<?= $this->endSection(); ?>