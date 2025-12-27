<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// data server

$route['server'] = 'Server_controller/index';
$route['server/tambah'] = 'Server_controller/tambah_server';
$route['server/hapus/(:any)'] = 'Server_controller/hapus_server/$1';
$route['server/edit/(:any)'] = 'Server_controller/edit_server/$1';


// data pesanan
$route['daftar_pesan'] = 'Daftar_pesan_controller/index';
$route['daftar_pesan/tambah'] = 'Daftar_pesan_controller/tambah_pesanan';
$route['daftar_pesan/hapus/(:any)'] = 'Daftar_pesan_controller/hapus_pesanan/$1';
$route['daftar_pesan/selesai/(:any)'] = 'Daftar_pesan_controller/selesai_pesanan/$1';
$route['daftar_pesan/edit/(:any)'] = 'Daftar_pesan_controller/edit_pesanan/$1';
$route['daftar_pesan/hapus_semua'] = 'Daftar_pesan_controller/hapus_semua';
$route['daftar_pesan/hapus_banyak'] = 'Daftar_pesan_controller/hapus_banyak';
<<<<<<< HEAD
=======
$route['daftar_pesan'] = 'daftar_pesan_controller';
$route['daftar_pesan/(:any)'] = 'daftar_pesan_controller/$1';
$route['daftar_pesan/tambah'] = 'daftar_pesan_controller/tambah_pesan';
$route['daftar_pesan/edit/(:num)'] = 'daftar_pesan_controller/edit_pesan/$1';
$route['daftar_pesan/(:any)'] = 'daftar_pesan_controller/$1';
$route['default_controller'] = 'daftar_pesan_controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['daftar_pesan'] = 'daftar_pesan_controller/index';
$route['daftar_pesan/(:any)'] = 'daftar_pesan_controller/$1';
$route['daftar_pesan/(:any)/(:any)'] = 'daftar_pesan_controller/$1/$2';
$route['daftar_pesan'] = 'daftar_pesan_controller/index';
$route['daftar_pesan/(:any)'] = 'daftar_pesan_controller/$1';
$route['daftar_pesan/(:any)/(:num)'] = 'daftar_pesan_controller/$1/$2';



>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)

// data team
$route['team'] = 'Team_controller/index';
$route['team/tambah'] = 'Team_controller/tambah_team';
$route['team/hapus/(:any)'] = 'Team_controller/hapus_team/$1';
$route['team/edit/(:any)'] = 'Team_controller/edit_team/$1';

// data hutang
$route['hutang'] = 'Hutang_controller/index';
$route['hutang/tambah'] = 'Hutang_controller/tambah_hutang';
$route['hutang/hapus/(:any)'] = 'Hutang_controller/hapus_hutang/$1';
$route['hutang/edit/(:any)'] = 'Hutang_controller/edit_hutang/$1';
<<<<<<< HEAD
=======
$route['hutang'] = 'hutang_controller/index';
$route['hutang/export_pdf'] = 'hutang_controller/export_pdf';
$route['hutang/tambah'] = 'hutang_controller/tambah_hutang';
$route['hutang/hapus/(:num)'] = 'hutang_controller/hapus_hutang/$1';
$route['hutang/edit/(:num)'] = 'hutang_controller/edit_hutang/$1';


// laporan pembelian
$route['laporan-pembelian'] = 'laporan_pembelian';
$route['Laporan_pembelian'] = 'Laporan_pembelian_controller';
$route['Laporan_pembelian/(:any)'] = 'Laporan_pembelian_controller/$1';
$route['default_controller'] = 'login'; // atau controller utama kamu
$route['Laporan-pembelian'] = 'Laporan_pembelian_controller';
$route['Laporan-pembelian/(:any)'] = 'Laporan_pembelian_controller/$1';
$route['laporan_pembelian/export_pdf'] = 'Laporan_pembelian/export_pdf';
$route['laporan_pembelian/pdf'] = 'Laporan_pembelian/export_pdf';
$route['laporan_pembelian'] = 'Laporan_pembelian_controller/index';
$route['laporan_pembelian/export_pdf'] = 'Laporan_pembelian_controller/export_pdf';
$route['laporan_pembelian/hapus_pilih'] = 'Laporan_pembelian_controller/hapus_pilih';

>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)

