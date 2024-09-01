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
    <p style="font-family: Trebuchet MS, Arial, Helvetica, sans-serif; padding-left: 15px;padding-right: 15px;"><b>LAPORAN STOK BARANG EMKA STORE</b></p>
    <p style="font-family: Trebuchet MS, Arial, Helvetica, sans-serif; padding-left: 15px;padding-right: 15px; font-size: small; margin-top: -10px;"><b>Tanggal Update Data</b> : <?= $tanggal ?> WIB</p>
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
                <th>Barang</th>
                <th>Stok</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <!-- <th>Total Beli</th> -->
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
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
                ?>
                <tr>
                  <td style="text-align: center;"><?= $no++; ?></td>
                  <td><?= $k['nm_barang']; ?> - <?= $k['kategori']; ?> - <?= $k['sub_kategori']; ?></td>
                  <td style="text-align: center;"><?= $stok; ?></td>
                  <td style="text-align: center;"><?= rupiah($k['harga_beli']); ?></td>
                  <td style="text-align: center;"><?= rupiah($k['harga_jual']); ?></td>
                  <!-- <td style="text-align: center;"><?= rupiah($k['harga_beli'] * $stok); ?></td> -->
                </tr>
              <?php
              //  $total += $stok * $k['harga_beli'];
              endforeach ?>
              <!-- <tr style="background-color: #e0e0e0;">
                <td colspan="5" style="text-align: center;"><b>Total</b></td>
                <td style="text-align: center;"><b><?= rupiah($total); ?></b></td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>

</html>