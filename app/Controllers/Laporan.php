<?php

namespace App\Controllers;


use App\Libraries\Pdfgenerator;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Laporan extends BaseController
{
  public function index()
  {
    $data = array(
      'title' => 'Laporan',
    );
    return view('laporan_view', $data);
  }

  public function cetak_pdf()
  {
    date_default_timezone_set('Asia/Jakarta');

    $Pdfgenerator = new Pdfgenerator();
    $paper = 'A4';
    //orientasi paper potrait / landscape
    $orientation = "landscape";
    // view('admin/tema_rud_admin', $data);
    $jenis = $this->request->getVar('jenis_laporan');
    if ($jenis === 'Stok Barang') {
      $data = [
        'title'         => 'Laporan Stok Barang',
        'tanggal'         => date('d M Y H:i'),
        'barang'        => $this->barang->join('kategori_tb', 'barang_tb.id_kategori=kategori_tb.id_kategori', 'left')->join('sub_kategori_tb', 'barang_tb.id_sub_kategori=sub_kategori_tb.id_sub_kategori', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->orderBy('kode_barang', 'Desc')->findAll()
      ];
      // filename dari pdf ketika didownload
      $file_pdf = 'Laporan Barang';
      // setting paper
      $html = view('cetak_stok', $data);
    } elseif ($jenis === 'Barang Masuk') {
      $tgl_awal   = $this->request->getVar('tgl_awal');
      $tgl_akhir  = $this->request->getVar('tgl_akhir');
      $data = [
        'title'         => 'Laporan Barang Masuk',
        'tgl_awal'      => $tgl_awal,
        'tgl_akhir'      => $tgl_akhir,
        // 'barang_masuk' => $this->barang_masuk->join('barang_tb', 'barang_masuk_tb.kode_barang=barang_tb.kode_barang', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->orderBy('id_barang_masuk', 'desc')->findAll()

        'barang_masuk' => $this->barang_masuk->join('barang_tb', 'barang_masuk_tb.kode_barang=barang_tb.kode_barang', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->where('tanggal_masuk >=', $tgl_awal)->where('tanggal_masuk <=', $tgl_akhir)->groupBy('tanggal_masuk')->orderBy('tanggal_masuk', 'asc')->findAll()
      ];
      $file_pdf = 'Laporan Barang Masuk';
      if (!empty($data['barang_masuk'])) {
        $html = view('cetak_barang_masuk', $data);
      } else {
        session()->setFlashdata('danger', 'Data Yang Ingin Anda Cetak Tidak Ada');
        return redirect()->to('laporan');
      }
    } else {
      $tgl_awal   = $this->request->getVar('tgl_awal');
      $tgl_akhir  = $this->request->getVar('tgl_akhir');
      $data = [
        'title'         => 'Laporan Barang Keluar',
        'tgl_awal'      => $tgl_awal,
        'tgl_akhir'     => $tgl_akhir,
        'barang_keluar' => $this->barang_keluar->join('barang_tb', 'barang_keluar_tb.kode_barang=barang_tb.kode_barang', 'left')->where('tanggal_keluar >=', $tgl_awal)->where('tanggal_keluar <=', $tgl_akhir)->groupBy('tanggal_keluar')->orderBy('tanggal_keluar', 'asc')->findAll()
      ];
      $file_pdf = 'Laporan Barang Keluar (' . date('d-m-Y', strtotime($tgl_awal)) . ' - ' . date('d-m-Y', strtotime($tgl_akhir)) . ')';
      $html = view('cetak_barang_keluar', $data);
    }
    // run dompdf
    $Pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
}
