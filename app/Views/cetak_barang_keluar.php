<?php
function rupiah($duit)
{
  $hasil = "Rp." . number_format($duit, 0, ',', '.');
  return $hasil;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>/assets/images/icon.svg">
  <style>
    body {
      font-family: "Trebuchet MS, Arial, Helvetica, sans-serif";
    }

    .card {
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      font-size: 14px;
    }

    table {
      border-collapse: collapse;
      /* Removes default table spacing */
      width: 100%;
      /* Set a width for the table */
    }

    th,
    td {
      border: 1px solid black;
      padding: 8px;
    }

    table th {
      background-color: #e0e0e0;
      /* Light gray for headers */
    }
  </style>

  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
</head>

<body>
  <div style="text-align:center; margin-bottom: 10px;">
    <p style="font-family: Trebuchet MS, Arial, Helvetica, sans-serif; padding-left: 15px;padding-right: 15px;"><b>LAPORAN BARANG KELUAR EMKA STORE</b></p>
    <p style="font-family: Trebuchet MS, Arial, Helvetica, sans-serif; padding-left: 15px;padding-right: 15px; font-size: small; margin-top: -10px;"><b>Periode</b> : <?= date('d/m/Y', strtotime($tgl_awal)) ?> - <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
  </div>
  <br>
  <div class=" col-xl-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <!-- <th>Keterangan</th> -->
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Harga Total</th>
                <th>Pajak</th>
                <th>Keuntungan</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              $total = 0;
              $tot_untung = 0;
              $jml = 0;
              $pjk = 0;
              foreach ($barang_keluar as $k) :
                $harga_jual = $k['jumlah_keluar'] * $k['harga_jual'];
                $harga_beli = $k['jumlah_keluar'] * $k['harga_beli'];
                $pajak = $harga_jual * ($k['pajak'] / 100);
                $keuntungan = $harga_jual - $harga_beli - $pajak;

                $db                 = \Config\Database::connect();
                $data               = $db->table('barang_keluar_tb');
                $d_barang_keluar     = $data->join('barang_tb', 'barang_keluar_tb.kode_barang=barang_tb.kode_barang', 'left')->where('tanggal_keluar', $k['tanggal_keluar'])->orderBy('tanggal_keluar', 'asc')->get(1000, 1)->getResultArray();
                $j_barang_keluar     = $data->join('barang_tb', 'barang_keluar_tb.kode_barang=barang_tb.kode_barang', 'left')->where('tanggal_keluar', $k['tanggal_keluar'])->orderBy('tanggal_keluar', 'asc')->get(1000, 1)->getNumRows();
              ?>
                <tr>
                  <td rowspan="<?= $j_barang_keluar + 1; ?>" style=" text-align: center;"><?= $no++; ?></td>
                  <td rowspan="<?= $j_barang_keluar + 1; ?>" style=" text-align: center;"><?= date('d M Y', strtotime($k['tanggal_keluar'])); ?></td>
                  <td><?= $k['nm_barang']; ?></td>
                  <!-- <td style="text-align: center;"><?= $k['keterangan']; ?></td> -->
                  <td style="text-align: center;"><?= rupiah($k['harga_jual']); ?></td>
                  <td style="text-align: center;"><?= $k['jumlah_keluar']; ?></td>
                  <td style="text-align: center;"><?= rupiah($harga_jual); ?></td>
                  <td style="text-align: center;"><?= rupiah($pajak); ?></td>
                  <td style="text-align: center;"><?= rupiah($keuntungan); ?></td>
                </tr>

                <?php
                $d_total = 0;
                $d_tot_untung = 0;
                $d_jml = 0;
                $d_pjk = 0;
                if ($j_barang_keluar > 0): ?>
                  <?php
                  foreach ($d_barang_keluar as $d):
                    $d_harga_jual = $d['jumlah_keluar'] * $d['harga_jual'];
                    $d_harga_beli = $d['jumlah_keluar'] * $d['harga_beli'];
                    $d_pajak = $d_harga_jual * ($d['pajak'] / 100);
                    $d_keuntungan = ($d_harga_jual - $d_harga_beli) - $d_pajak;
                  ?>
                    <tr>
                      <td><?= $d['nm_barang']; ?></td>
                      <td style="text-align: center;"><?= rupiah($d['harga_jual']); ?></td>
                      <td style="text-align: center;"><?= $d['jumlah_keluar']; ?></td>
                      <td style="text-align: center;"><?= rupiah($harga_jual); ?></td>
                      <td style="text-align: center;"><?= rupiah($pajak); ?></td>
                      <td style="text-align: center;"><?= rupiah($keuntungan); ?></td>
                    </tr>

                  <?php
                    $d_total += $d_harga_jual;
                    $d_tot_untung += $d_keuntungan;
                    $d_jml += $d['jumlah_keluar'];
                    $d_pjk += $d_pajak;
                  endforeach ?>
                <?php endif ?>

              <?php
                $total += $harga_jual;
                $tot_untung += $keuntungan;
                $jml += $k['jumlah_keluar'];
                $pjk += $pajak;
              endforeach ?>
              <tr style="background-color: #e0e0e0;">
                <td colspan="4" style="text-align: center;"><b>Total</b></td>
                <td style="text-align: center;"><b><?= $jml + $d_jml; ?></b></td>
                <td style="text-align: center;"><b><?= rupiah($total + $d_total); ?></b></td>
                <td style="text-align: center;"><b><?= rupiah($pjk + $d_pjk); ?></b></td>
                <td style="text-align: center;"><b><?= rupiah($tot_untung + $d_tot_untung); ?></b></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>

</html>