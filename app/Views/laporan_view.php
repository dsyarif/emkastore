<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid" id="container-wrapper">

  <!-- Row -->
  <div class="row">

    <!-- DataTable with Hover -->
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan</h6>
        </div>
        <div class="card-body" style="margin-top: -20px;">
          <?= form_open('laporan/cetak', 'target="_blank"') ?>
          <div class="form-group">
            <label class="font-weight-bold">Jenis Laporan</label>
            <select name="jenis_laporan" id="mySelect" required class="form-control">
              <option label="== Pilih Laporan =="></option>
              <option value="Stok Barang">Stok Barang</option>
              <option value="Barang Masuk">Barang Masuk</option>
              <option value="Barang Keluar">Barang Keluar</option>
            </select>
          </div>
          <div class="form-group" id="myInput1">
            <label class="font-weight-bold">Tanggal Awal</label>
            <input type="date" name="tgl_awal" class="form-control">
          </div>
          <div class="form-group" id="myInput2">
            <label class="font-weight-bold">Tanggal Akhir</label>
            <input type="date" name="tgl_akhir" class="form-control">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Cetak Laporan</button>
          </div>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
  <!--Row-->

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#mySelectt').change(function() {
      const selectedOption = $(this).val();
      if (selectedOption === 'option1') {
        $('#myInput').show();
      } else {
        $('#myInput').hide();
      }
    });
  });
</script>

<script>
  const mySelect = document.getElementById('mySelect');
  const myInput1 = document.getElementById('myInput1');
  const myInput2 = document.getElementById('myInput2');

  mySelect.addEventListener('change', function() {
    const selectedOption = this.value;
    if (selectedOption !== 'Stok Barang') {
      myInput1.style.display = 'block';
      myInput2.style.display = 'block';
    } else {
      myInput1.style.display = 'none';
      myInput2.style.display = 'none';
    }
  });
</script>
<?= $this->endSection(); ?>