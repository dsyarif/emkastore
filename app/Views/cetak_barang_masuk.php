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
    <p style="font-family: Trebuchet MS, Arial, Helvetica, sans-serif; padding-left: 15px;padding-right: 15px;"><b>LAPORAN BARANG MASUK EMKA STORE</b></p>
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
                <th>Supplier</th>
                <th>Harga</th>
                <th>Ket.</th>
                <th>Jumlah</th>
                <th>Harga Total</th>
                <th>DP/Bayar</th>
                <th>Kekurangan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $total = 0;
              $jml = 0;
              $bayar = 0;
              $kurang = 0;
              foreach ($barang_masuk as $k) :
                $db                 = \Config\Database::connect();
                $data               = $db->table('barang_masuk_tb');
                $d_barang_masuk     = $data->join('barang_tb', 'barang_masuk_tb.kode_barang=barang_tb.kode_barang', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->where('tanggal_masuk', $k['tanggal_masuk'])->orderBy('tanggal_masuk', 'asc')->get(1000, 1)->getResultArray();
                $j_barang_masuk     = $data->join('barang_tb', 'barang_masuk_tb.kode_barang=barang_tb.kode_barang', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->where('tanggal_masuk', $k['tanggal_masuk'])->orderBy('tanggal_masuk', 'asc')->get(1000, 1)->getNumRows();
              ?>
                <tr>
                  <td rowspan="<?= $j_barang_masuk + 1; ?>" style="text-align: center;"><?= $no++; ?></td>
                  <td rowspan="<?= $j_barang_masuk + 1; ?>" style="text-align: center;"><?= date('d M Y', strtotime($k['tanggal_masuk'])); ?></td>
                  <td><?= $k['nm_barang']; ?></td>
                  <td><?= $k['nama_supplier']; ?></td>
                  <td style="text-align: center;"><?= rupiah($k['harga_beli']); ?></td>
                  <td><?= $k['ket']; ?></td>
                  <td style="text-align: center;"><?= $k['jumlah_masuk']; ?></td>
                  <td style="text-align: center;"><?= rupiah($k['jumlah_masuk'] * $k['harga_beli']); ?></td>
                  <td style="text-align: center;"><?= rupiah($k['bayar']); ?></td>
                  <td style="text-align: center;"><?= rupiah($k['jumlah_masuk'] * $k['harga_beli'] - $k['bayar']); ?></td>
                </tr>

                <?php
                $d_total = 0;
                $d_jml = 0;
                $d_bayar = 0;
                $d_kurang = 0;
                if ($j_barang_masuk > 0): ?>
                  <?php
                  foreach ($d_barang_masuk as $d): ?>
                    <tr>
                      <td><?= $d['nm_barang']; ?></td>
                      <td><?= $d['nama_supplier']; ?></td>
                      <td style="text-align: center;"><?= rupiah($d['harga_beli']); ?></td>
                      <td><?= $d['ket']; ?></td>
                      <td style="text-align: center;"><?= $d['jumlah_masuk']; ?></td>
                      <td style="text-align: center;"><?= rupiah($d['jumlah_masuk'] * $d['harga_beli']); ?></td>
                      <td style="text-align: center;"><?= rupiah($d['bayar']); ?></td>
                      <td style="text-align: center;"><?= rupiah($d['jumlah_masuk'] * $d['harga_beli'] - $d['bayar']); ?></td>
                    </tr>
                  <?php
                    $d_total += $d['jumlah_masuk'] * $d['harga_beli'];
                    $d_jml += $d['jumlah_masuk'];
                    $d_bayar += $d['bayar'];
                    $d_kurang += $d['jumlah_masuk'] * $d['harga_beli'] - $d['bayar'];
                  endforeach ?>
                <?php endif ?>
              <?php
                $total += $k['jumlah_masuk'] * $k['harga_beli'];
                $jml += $k['jumlah_masuk'];
                $bayar += $k['bayar'];
                $kurang += $k['jumlah_masuk'] * $k['harga_beli'] - $k['bayar'];
              endforeach
              ?>
              <tr style="background-color: #e0e0e0;">
                <td colspan="6" style="text-align: center;"><b>Total</b></td>
                <td style="text-align: center;"><b><?= $jml + $d_jml; ?></b></td>
                <td style="text-align: center;"><b><?= rupiah($total + $d_total); ?></b></td>
                <td style="text-align: center;"><b><?= rupiah($bayar + $d_bayar); ?></b></td>
                <td style="text-align: center;"><b><?= rupiah($kurang + $d_kurang); ?></b></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>

</html>