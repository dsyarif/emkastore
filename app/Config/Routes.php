<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index', ['filter' => 'flogin']);
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'flogout']);


// Kategori
$routes->group('kategori', static function ($routes) {
  $routes->add('/', 'Barang::kategori', ['filter' => 'flogout']);
  $routes->add('save', 'Barang::save_kategori');
  $routes->add('update', 'Barang::update_kategori');
  $routes->add('getkategori', 'Barang::get_kategori');
  $routes->add('delete/(:num)', 'Barang::delete_kategori/$1');
});

// Sub Kategori
$routes->group('sub_kategori', static function ($routes) {
  $routes->add('/', 'Barang::sub_kategori', ['filter' => 'flogout']);
  $routes->add('save', 'Barang::save_sub_kategori');
  $routes->add('update', 'Barang::update_sub_kategori');
  $routes->add('delete/(:num)', 'Barang::delete_sub_kategori/$1');
});

// Supplier
$routes->group('supplier', static function ($routes) {
  $routes->add('/', 'Supplier::index', ['filter' => 'flogout']);
  $routes->add('save', 'Supplier::save_supplier');
  $routes->add('update', 'Supplier::update_supplier');
});

// Barang
$routes->group('barang', static function ($routes) {
  $routes->add('/', 'Barang::index', ['filter' => 'flogout']);
  $routes->add('save', 'Barang::save_barang');
  $routes->add('update', 'Barang::update_barang');
  $routes->add('delete/(:num)', 'Barang::delete_barang/$1');
});

// Barang Masuk
$routes->group('barang-masuk', static function ($routes) {
  $routes->add('/', 'Transaksi::index', ['filter' => 'flogout']);
  $routes->add('save', 'Transaksi::save_barang_masuk');
  $routes->add('update', 'Transaksi::update_barang_masuk');
  $routes->add('delete/(:num)', 'Transaksi::delete_barang_masuk/$1');
});

// Barang Keluar
$routes->group('barang-keluar', static function ($routes) {
  $routes->add('/', 'Transaksi::barang_keluar', ['filter' => 'flogout']);
  $routes->add('save', 'Transaksi::save_barang_keluar');
  $routes->add('update', 'Transaksi::update_barang_keluar');
  $routes->add('delete/(:num)', 'Transaksi::delete_barang_keluar/$1');
});

// Laporan
$routes->group('laporan', static function ($routes) {
  $routes->add('/', 'Laporan::index', ['filter' => 'flogout']);
  $routes->add('cetak', 'Laporan::cetak_pdf');
});

// Pengguna
$routes->group('pengguna', static function ($routes) {
  $routes->add('/', 'Pengguna::index', ['filter' => 'flogout']);
  $routes->add('save', 'Pengguna::save_pengguna');
  $routes->add('update', 'Pengguna::update_pengguna');
  $routes->add('delete/(:num)', 'Pengguna::delete_pengguna/$1');
});

// Login
$routes->group('login', static function ($routes) {
  $routes->add('/', 'Login::index', ['filter' => 'flogin']);
  $routes->add('ceklogin', 'Login::ceklogin');
  $routes->add('logout', 'Login::logout');
});
