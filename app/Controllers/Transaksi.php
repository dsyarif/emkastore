<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Transaksi extends BaseController
{
  //barang masuk
  public function index()
  {
    $data = array(
      'title'         => 'Barang Masuk',
      'group'         => $this->barang_masuk->groupBy('tanggal_masuk')->orderBy('tanggal_masuk', 'ASC')->findAll(),
      'barang'        => $this->barang->join('kategori_tb', 'barang_tb.id_kategori=kategori_tb.id_kategori', 'left')->join('sub_kategori_tb', 'barang_tb.id_sub_kategori=sub_kategori_tb.id_sub_kategori', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->orderBy('kode_barang', 'Asc')->findAll(),

      'barang_masuk'  => $this->barang_masuk->join('barang_tb', 'barang_masuk_tb.kode_barang=barang_tb.kode_barang', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->groupBy('tanggal_masuk')->orderBy('tanggal_masuk', 'ASC')->findAll()
    );

    return view('barang_masuk_view', $data);
  }


  public function save_barang_masuk()
  {
    $barang = $this->barang->where('kode_barang', $this->request->getVar('kode_barang'))->first();
    $harga_barang = $barang['harga_beli'] * $this->request->getVar('jumlah_masuk');
    if ($this->request->getVar('bayar') <= $harga_barang) {
      $data = [
        'kode_barang'           => $this->request->getVar('kode_barang'),
        'tanggal_masuk'         => $this->request->getVar('tanggal_masuk'),
        'jumlah_masuk'          => $this->request->getVar('jumlah_masuk'),
        'bayar'                 => $this->request->getVar('bayar'),
        'ket'                   => $this->request->getVar('ket'),
      ];
      $this->barang_masuk->save($data);
      session()->setFlashdata('success', 'Data Berhasil Disimpan');
    } else {
      session()->setFlashdata('danger', 'Data Gagal Disimpan Karena Jumlah Bayar/DP melebihi harga bayar');
    }
    return redirect()->to('barang-masuk');
  }

  public function update_barang_masuk()
  {
    $barang = $this->barang->where('kode_barang', $this->request->getVar('kode_barang'))->first();
    $harga_barang = $barang['harga_beli'] * $this->request->getVar('jumlah_masuk');
    if ($this->request->getVar('bayar') <= $harga_barang) {
      $data = [
        'id_barang_masuk'       => $this->request->getVar('id_barang_masuk'),
        'kode_barang'           => $this->request->getVar('kode_barang'),
        'tanggal_masuk'         => $this->request->getVar('tanggal_masuk'),
        'jumlah_masuk'          => $this->request->getVar('jumlah_masuk'),
        'ket'                   => $this->request->getVar('ket'),
        'bayar'                 => $this->request->getVar('bayar'),
      ];
      $this->barang_masuk->save($data);
      session()->setFlashdata('success', 'Data Berhasil Diubah');
    } else {
      session()->setFlashdata('danger', 'Data Gagal Disimpan Karena Jumlah Bayar/DP melebihi harga bayar');
    }
    return redirect()->to('barang-masuk');
  }

  public function delete_barang_masuk($id)
  {
    $this->barang_masuk->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => 'Data Berhasil Dihapus!'
    ]);
  }

  public function barang_keluar()
  {
    $data = array(
      'title'         => 'Barang Keluar',

      'barang'        => $this->barang->join('kategori_tb', 'barang_tb.id_kategori=kategori_tb.id_kategori', 'left')->join('sub_kategori_tb', 'barang_tb.id_sub_kategori=sub_kategori_tb.id_sub_kategori', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->orderBy('kode_barang', 'Asc')->findAll(),

      'barang_keluar' => $this->barang_keluar->join('barang_tb', 'barang_keluar_tb.kode_barang=barang_tb.kode_barang', 'left')->groupBy('tanggal_keluar')->orderBy('tanggal_keluar', 'asc')->findAll()
    );

    return view('barang_keluar_view', $data);
  }


  public function save_barang_keluar()
  {
    $kode_barang    = $this->request->getVar('kode_barang');
    $stok           =  $this->barang->selectSum('stok')->where('kode_barang', $kode_barang)->first();
    $barang_masuk   = $this->barang_masuk->selectSum('jumlah_masuk')->where('kode_barang', $kode_barang)->first();
    $barang_keluar  = $this->barang_keluar->selectSum('jumlah_keluar')->where('kode_barang', $kode_barang)->first();

    $total_stok     = ($barang_masuk['jumlah_masuk'] - $barang_keluar['jumlah_keluar']);
    $jml_keluar     = $this->request->getVar('jumlah_keluar');
    $data = [
      'kode_barang'     => $kode_barang,
      'tanggal_keluar'  => $this->request->getVar('tanggal_keluar'),
      'jumlah_keluar'   => $jml_keluar,
      'keterangan'      => $this->request->getVar('keterangan'),
      'alasan'          => $this->request->getVar('alasan'),
      'pajak'          => $this->request->getVar('pajak'),
    ];
    if ($total_stok < $jml_keluar) {
      session()->setFlashdata('danger', 'Data Gagal Disimpan, karena melebih stok yang ada');
    } else {
      $this->barang_keluar->save($data);
      session()->setFlashdata('success', 'Data Berhasil Disimpan');
    }


    return redirect()->to('barang-keluar');
  }

  public function update_barang_keluar()
  {
    $kode_barang    = $this->request->getVar('kode_barang');
    $barang_masuk   = $this->barang_masuk->selectSum('jumlah_masuk')->where('kode_barang', $kode_barang)->first();
    $barang_keluar  = $this->barang_keluar->selectSum('jumlah_keluar')->where('kode_barang', $kode_barang)->first();
    $barang_keluar_id  = $this->barang_keluar->where('id_barang_keluar', $this->request->getVar('id_barang_keluar'))->first();

    $total_stok     = (($barang_masuk['jumlah_masuk']  - $barang_keluar['jumlah_keluar']) + $barang_keluar_id['jumlah_keluar']);
    // dd($total_stok);
    $jml_keluar     = $this->request->getVar('jumlah_keluar');
    $data = [
      'id_barang_keluar' => $this->request->getVar('id_barang_keluar'),
      'kode_barang'     => $this->request->getVar('kode_barang'),
      'tanggal_keluar'  => $this->request->getVar('tanggal_keluar'),
      'jumlah_keluar'   => $this->request->getVar('jumlah_keluar'),
      'keterangan'      => $this->request->getVar('keterangan'),
      'alasan'          => $this->request->getVar('alasan'),
      'pajak'          => $this->request->getVar('pajak'),
    ];

    if ($total_stok < $jml_keluar) {
      session()->setFlashdata('danger', 'Data Gagal Disimpan, karena melebih stok yang ada');
    } else {
      $this->barang_keluar->save($data);
      session()->setFlashdata('success', 'Data Berhasil Disimpan');
    }

    // $this->barang_keluar->save($data);
    // session()->setFlashdata('success', 'Data Berhasil Diubah');

    return redirect()->to('barang-keluar');
  }

  public function delete_barang_keluar($id)
  {
    $this->barang_keluar->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => 'Data Berhasil Dihapus!'
    ]);
  }
}
