<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Supplier extends BaseController
{

  public function index()
  {
    $data = array(
      'title' => 'Supplier',
      'supplier' => $this->supplier->orderBy('id_supplier', 'Desc')->findAll()
    );

    return view('supplier_view', $data);
  }

  public function save_supplier()
  {
    $data = [
      'nama_supplier'  => ucwords($this->request->getVar('nama_supplier')),
      'no_hp'          => $this->request->getVar('no_hp'),
      'alamat'         => $this->request->getVar('alamat'),
    ];
    $this->supplier->save($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan');

    return redirect()->to('supplier');
  }

  public function update_supplier()
  {
    $data = [
      'id_supplier'    => $this->request->getVar('id_supplier'),
      'nama_supplier'  => ucwords($this->request->getVar('nama_supplier')),
      'no_hp'          => $this->request->getVar('no_hp'),
      'alamat'         => $this->request->getVar('alamat'),
    ];
    $this->supplier->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diubah');

    return redirect()->to('supplier');
  }
}
