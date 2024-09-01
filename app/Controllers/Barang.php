<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Barang extends BaseController
{
  public function index()
  {
    $data = array(
      'title'         => 'Barang',
      'kode'           => $this->barang->kode_produk(),
      'supplier'      => $this->supplier->where('status_supplier', 'Aktif')->orderBy('id_supplier', 'Desc')->findAll(),
      'kategori'      => $this->kategori->where('status_kategori', 'Aktif')->orderBy('id_kategori', 'Desc')->findAll(),
      'sub_kategori'  => $this->subkategori->where('status_sub_kategori', 'Aktif')->orderBy('id_sub_kategori', 'Desc')->findAll(),
      'barang'        => $this->barang->join('kategori_tb', 'barang_tb.id_kategori=kategori_tb.id_kategori', 'left')->join('sub_kategori_tb', 'barang_tb.id_sub_kategori=sub_kategori_tb.id_sub_kategori', 'left')->join('supplier_tb', 'barang_tb.id_supplier=supplier_tb.id_supplier', 'left')->orderBy('kode_barang', 'Desc')->findAll()
    );

    return view('barang_view', $data);
  }

  public function save_barang()
  {
    $data = [
      'kode_barang'           => $this->request->getVar('kode_barang'),
      'nm_barang'             => ucwords($this->request->getVar('nm_barang')),
      'id_supplier'           => $this->request->getVar('id_supplier'),
      'id_kategori'           => $this->request->getVar('id_kategori'),
      'id_sub_kategori'       => $this->request->getVar('id_sub_kategori'),
      // 'stok'                  => $this->request->getVar('stok'),
      'harga_beli'            => $this->request->getVar('harga_beli'),
      'harga_jual'            => $this->request->getVar('harga_jual'),
    ];
    $this->barang->insert($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan');

    return redirect()->to('barang');
  }

  public function update_barang()
  {
    $data = [
      'id_barang'           => $this->request->getVar('id_barang'),
      'kode_barang'           => $this->request->getVar('kode_barang'),
      'nm_barang'             => ucwords($this->request->getVar('nm_barang')),
      'id_supplier'           => $this->request->getVar('id_supplier'),
      'id_kategori'           => $this->request->getVar('id_kategori'),
      'id_sub_kategori'       => $this->request->getVar('id_sub_kategori'),
      // 'stok'                  => $this->request->getVar('stok'),
      'harga_beli'          => $this->request->getVar('harga_beli'),
      'harga_jual'            => $this->request->getVar('harga_jual'),
    ];
    $this->barang->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diubah');

    return redirect()->to('barang');
  }


  public function get_kategori()
  {
    $this->kategori->select('id_kategori, kategori, status_kategori');
    return DataTable::of($this->kategori)
      ->addNumbering()
      ->hide('id_kategori')->toJson();
  }

  public function kategori()
  {
    $data = array(
      'title' => 'Kategori',
      'kategori' => $this->kategori->orderBy('id_kategori', 'Desc')->findAll()
    );

    return view('kategori_view', $data);
  }

  public function save_kategori()
  {
    $data = [
      'kategori'          => ucwords($this->request->getVar('kategori')),
      'status_kategori'   => 'Aktif'
    ];
    $this->kategori->save($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan');

    return redirect()->to('kategori');
  }

  public function update_kategori()
  {
    $data = [
      'id_kategori'       => $this->request->getVar('id_kategori'),
      'kategori'          => ucwords($this->request->getVar('kategori')),
      'status_kategori'   => $this->request->getVar('status_kategori')
    ];
    $this->kategori->save($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan');

    return redirect()->to('kategori');
  }

  public function sub_kategori()
  {
    $data = array(
      'title' => 'Sub Kategori',
      'sub_kategori' => $this->subkategori->orderBy('id_sub_kategori', 'Desc')->findAll()
    );

    return view('sub_kategori_view', $data);
  }

  public function save_sub_kategori()
  {
    $data = [
      'sub_kategori'          => ucwords($this->request->getVar('sub_kategori')),
      'status_sub_kategori'   => 'Aktif'
    ];
    $this->subkategori->save($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan');

    return redirect()->to('sub_kategori');
  }

  public function update_sub_kategori()
  {
    $data = [
      'id_sub_kategori'       => $this->request->getVar('id_sub_kategori'),
      'sub_kategori'          => ucwords($this->request->getVar('sub_kategori')),
      'status_sub_kategori'   => $this->request->getVar('status_sub_kategori')
    ];
    $this->subkategori->save($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan');

    return redirect()->to('sub_kategori');
  }

  public function delete_barang($id)
  {
    $barang = $this->barang->where('id_barang', $id)->first();
    $barang_msk = $this->barang_masuk->where('kode_barang', $barang['kode_barang'])->findAll();
    if (!empty($barang_msk)) {
      foreach ($barang_msk as $masuk) {
        $this->barang_masuk->delete($masuk['id_barang_masuk']);
      }
    }

    $barang_kl = $this->barang_keluar->where('kode_barang', $barang['kode_barang'])->findAll();
    if (!empty($barang_kl)) {
      foreach ($barang_kl as $keluar) {
        $this->barang_keluar->delete($keluar['id_barang_keluar']);
      }
    }

    $this->barang->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => 'Data Berhasil Dihapus!'
    ]);
  }

  public function delete_kategori($id)
  {
    $barang = $this->barang->where('id_kategori', $id)->findAll();
    if (!empty($barang)) {
      foreach ($barang as $br) {
        $barang_msk = $this->barang_masuk->where('kode_barang', $br['kode_barang'])->findAll();
        if (!empty($barang_msk)) {
          foreach ($barang_msk as $masuk) {
            $this->barang_masuk->delete($masuk['id_barang_masuk']);
          }
        }

        $barang_kl = $this->barang_keluar->where('kode_barang', $br['kode_barang'])->findAll();
        if (!empty($barang_kl)) {
          foreach ($barang_kl as $keluar) {
            $this->barang_keluar->delete($keluar['id_barang_keluar']);
          }
        }

        $this->barang->delete($br['id_barang']);
      }
    }

    $this->kategori->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => 'Data Berhasil Dihapus!'
    ]);
  }

  public function delete_sub_kategori($id)
  {
    $barang = $this->barang->where('id_sub_kategori', $id)->findAll();
    if (!empty($barang)) {
      foreach ($barang as $br) {
        $barang_msk = $this->barang_masuk->where('kode_barang', $br['kode_barang'])->findAll();
        if (!empty($barang_msk)) {
          foreach ($barang_msk as $masuk) {
            $this->barang_masuk->delete($masuk['id_barang_masuk']);
          }
        }

        $barang_kl = $this->barang_keluar->where('kode_barang', $br['kode_barang'])->findAll();
        if (!empty($barang_kl)) {
          foreach ($barang_kl as $keluar) {
            $this->barang_keluar->delete($keluar['id_barang_keluar']);
          }
        }

        $this->barang->delete($br['id_barang']);
      }
    }

    $this->subkategori->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => 'Data Berhasil Dihapus!'
    ]);
  }
}
