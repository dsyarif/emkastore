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
          <h6 class="m-0 font-weight-bold text-primary">Data Supplier</h6>
          <button data-toggle="modal" data-target="#tambah_supplier" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Tambah Data</button>
        </div>
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush table-hover" id="dataTableHover">
            <thead class="thead-light">
              <tr>
                <th style="width: 5%;">No</th>
                <th>Supplier</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th style="width: 10%;">Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Supplier</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th style="width: 10%;">Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php $no = 1;
              foreach ($supplier as $k) : ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $k['nama_supplier']; ?></td>
                  <td><?= $k['no_hp']; ?></td>
                  <td><?= $k['alamat']; ?></td>
                  <td>
                    <button data-toggle="modal" data-target="#edit_supplier<?= $k['id_supplier']; ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-edit"></i></button>
                  </td>
                </tr>

                <!-- modal edit supplier -->
                <div class="modal fade" id="edit_supplier<?= $k['id_supplier']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Edit Supplier</b></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="card mb-4">
                          <div class="card-body">
                            <?php echo form_open('supplier/update'); ?>
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_supplier" value="<?= $k['id_supplier']; ?>">
                            <div class="form-group">
                              <label class="font-weight-bold">Supplier</label>
                              <input type="text" name="nama_supplier" value="<?= $k['nama_supplier']; ?>" required class="form-control" placeholder="Input Supplier...">
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold">No HP</label>
                              <input type="number" name="no_hp" value="<?= $k['no_hp']; ?>" required class="form-control" placeholder="Input No HP Supplier...">
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold">Alamat</label>
                              <textarea style="height: 10em;" name="alamat" class="form-control" required placeholder="Input Alamat Supplier..."><?= $k['alamat']; ?></textarea>
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

<!-- modal tambah supplier -->
<div class="modal fade" id="tambah_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabelLogout"><b>Tambah Supplier</b></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card mb-4">
          <div class="card-body">
            <?php echo form_open('supplier/save'); ?>
            <?= csrf_field() ?>
            <div class="form-group">
              <label class="font-weight-bold">Supplier</label>
              <input type="text" name="nama_supplier" required class="form-control" placeholder="Input Supplier...">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">No HP</label>
              <input type="number" name="no_hp" required class="form-control" placeholder="Input No HP Supplier...">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Alamat</label>
              <textarea style="height: 10em;" name="alamat" class="form-control" required placeholder="Input Alamat Supplier..."></textarea>
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

<!-- <script type="text/javascript">
  $(document).ready(function() {
    var table = $('#supplier').DataTable({
      processing: true,
      serverSide: true,
      ajax: '<?php echo base_url('supplier') ?>',
      columnDefs: [{
          targets: -1,
          orderable: true
        }, 
      ],

    });

    setInterval(function() {
      table.ajax.reload(null, false); 
    }, 30000);

  }); -->
</script>
<?= $this->endSection(); ?>