<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Pengguna extends BaseController
{
  public function index()
  {
    $data = array(
      'title'         => 'Pengguna',
      'pengguna'      => $this->pengguna->orderBy('id_pengguna', 'Desc')->findAll(),
    );
    return view('pengguna_view', $data);
  }

  public function save_pengguna()
  {
    $data = [
      'nama'        => ucwords($this->request->getVar('nama')),
      'username'    => $this->request->getVar('username'),
      'password'    => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
      'level'       => $this->request->getVar('level'),
    ];
    $this->pengguna->save($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan');

    return redirect()->to('pengguna');
  }

  public function update_pengguna()
  {
    $data = [
      'id_pengguna'    => $this->request->getVar('id_pengguna'),
      'nama_pengguna'  => ucwords($this->request->getVar('nama_pengguna')),
      'no_hp'          => $this->request->getVar('no_hp'),
      'alamat'         => $this->request->getVar('alamat'),
    ];
    $this->pengguna->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diubah');

    return redirect()->to('pengguna');
  }
}
