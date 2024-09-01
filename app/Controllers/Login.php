<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{

  public function index()
  {
    $data = array(
      'title' => 'Login',
    );

    return view('login_view', $data);
  }

  function ceklogin()
  {
    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');
    $level    = $this->request->getVar('level');

    $db      = \Config\Database::connect();
    if ($username == '' || $password == '') {
      session()->setFlashdata('danger', 'Username atau Password tidak boleh kosong');
    } else {
      $data_user = $db->query("SELECT * FROM pengguna_tb WHERE username = '" . $username . "' AND level = '" . $level . "'")->getRowArray();
      if ($data_user) {
        if (!password_verify($password, $data_user['password'])) {
          session()->setFlashdata('danger', 'Password yang anda input salah');
        } else {
          $sessData = array(
            'id_pengguna'   => $data_user['id_pengguna'],
            'username'      => $data_user['username'],
            'nama'          => $data_user['nama'],
            'level'         => $data_user['level'],
            'logged_in'     => TRUE
          );
          session()->set($sessData);
          return redirect()->to('dashboard');
        }
      } else {
        session()->setFlashdata('danger', 'Username yang anda input salah atau Akun belum terdaftar');
      }
    }
    return redirect()->to('login')->withInput();
  }

  public function logout()
  {
    $sessData = array('id_user', 'username', 'level', 'logged_in');
    session()->destroy($sessData);
    return redirect()->to('login');
  }
}
