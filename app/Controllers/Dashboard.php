<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
  public function index(): string
  {
    $data = array(
      'title'              => 'Dashboard',
      'jml_barang'         => $this->barang->countAllResults(),
      'supplier'           => $this->supplier->countAllResults(),
      'stok_barang'        => $this->barang->selectSum('stok')->findAll(),
      'jml_barang_masuk'   => $this->barang_masuk->selectSum('jumlah_masuk')->findAll(),
      'jml_barang_keluar'  => $this->barang_keluar->selectSum('jumlah_keluar')->findAll(),
      'barang_terlaris'    => $this->barang_keluar->join('barang_tb', 'barang_keluar_tb.kode_barang=barang_tb.kode_barang', 'left')->orderBy('jumlah_keluar', 'Desc')->limit(3)->findAll(),
      'data_barang'        => $this->barang->findAll()
    );
    // dd($data['stok_barang']);
    return view('dashboard_view', $data);
  }
}
