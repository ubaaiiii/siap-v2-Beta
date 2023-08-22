<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Modul\ProfileController;
use App\Http\Controllers\Modul\PengajuanController;
use App\Http\Controllers\Modul\SertifikatController;
use App\Http\Controllers\Modul\LaporanController;
use App\Http\Controllers\Modul\InquiryController;
use App\Http\Controllers\Modul\KalkulatorController;
use App\Http\Controllers\Modul\PanduanController;
use App\Http\Controllers\Modul\VerifikasiController;
use App\Http\Controllers\Modul\ValidasiController;
use App\Http\Controllers\Modul\PembatalanController;
use App\Http\Controllers\Modul\KlaimController;
use App\Http\Controllers\Modul\PembayaranController;
use App\Http\Controllers\Modul\BorderoController;
use App\Http\Controllers\Modul\RevisiController;
use App\Http\Controllers\Modul\RollbackController;
use App\Http\Controllers\Modul\CabangController;
use App\Http\Controllers\Modul\MitraController;
use App\Http\Controllers\Modul\KontakController;
use App\Http\Controllers\Modul\UserController;
use App\Http\Controllers\Modul\RateController;
use App\Http\Controllers\Modul\ReasController;
use App\Http\Controllers\Modul\CadanganController;
use App\Http\Controllers\Modul\DashboardController;
use App\Http\Controllers\Modul\ReasuransiController;
use App\Http\Controllers\Modul\DocumentController;
use App\Http\Controllers\Modul\CheckerController;
use App\Http\Controllers\Modul\ProsesController;
use App\Http\Controllers\Modul\Push_notifController;
use App\Helpers\Functions;
// use DB;
// use Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/cekadmin', function () {
// 	dd(Auth::guard('admin')->user()->level);
// });



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::view('/', 'welcome');
Auth::routes();

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/login/user', 'Auth\LoginController@showUserLoginForm');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::get('/register/user', 'Auth\RegisterController@showUserRegisterForm');

Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::post('/login/admin', 'Auth\LoginController@adminLogin')->name('login.admin');
Route::post('/login/user', 'Auth\LoginController@userLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::post('/register/user', 'Auth\RegisterController@createUser');

// Jangan Dijalanin, nanti gabisa di up lagi, harus dari server
// Route::get('/server-down',function () {
//     Artisan::call('down');
//     return "OK";
// });

// Route::get('/server-up',function () {
//     Artisan::call('up');
//     return "OK";
// });

Route::get('/clear-cache', function () {
    // Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "OK";
});

Route::get('/perintah-artisan', function () {
    // Artisan::call('cache:clear');
    Artisan::call('make:mail MailSend');
    return "OK";
});

Route::view('/home', 'home')->middleware('auth');
Route::group(['middleware' => 'cek:auth'], function () {

    // dd(Auth::guard());
    // if (Auth::guard('admin')->user()->level == "checker") {

    Route::get('/index', 'HomeController@index');
    Route::get('/notification', 'HomeController@notification');

    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/password', [ProfileController::class, 'password']);
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/pengajuan', [PengajuanController::class, 'index']);
    Route::get('/pengajuan/add', [PengajuanController::class, 'add']);
    Route::get('/hitungpremi', [PengajuanController::class, 'hitungpremi']);
    Route::get('/pengajuan/edit/{id}', [PengajuanController::class, 'edit']);
    Route::get('/pengajuan/delete/{id}', [PengajuanController::class, 'delete']);
    Route::get('/pengajuan/report/{id}', [PengajuanController::class, 'report']);
    Route::get('/pengajuan/report/lpfk/{id}', [PengajuanController::class, 'reportlpfk']);
    Route::get('/pengajuan/report/skkt/{id}', [PengajuanController::class, 'reportskkt']);
    Route::get('/pengajuan/report/spa/{id}', [PengajuanController::class, 'reportspa']);
    Route::get('/pengajuan/report/spkk/{id}', [PengajuanController::class, 'reportspkk']);
    Route::get('/pengajuan/report/spm/{id}', [PengajuanController::class, 'reportspm']);
    Route::get('/pengajuan/log/{id}', [PengajuanController::class, 'log']);
    Route::get('/pengajuan/salin/{id}', [PengajuanController::class, 'salin']);
    Route::get('/pengajuan/approve/{id}', [PengajuanController::class, 'approve']);
    Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::post('/pengajuan/update', [PengajuanController::class, 'update'])->name('pengajuan.update');
    Route::post('/pengajuan/upload', [PengajuanController::class, 'upload'])->name('pengajuan.upload');
    Route::get('/pengajuan/data', [PengajuanController::class, 'getData']);
    Route::get('/pengajuan/desktop', [PengajuanController::class, 'getDesktop']);
    Route::get('/pengajuan/doc/{id}/{type}', [DocumentController::class, 'doc']);


    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::post('/laporan/cetak', [LaporanController::class, 'cetak']);

    Route::get('/inquiry', [InquiryController::class, 'index']);
    Route::get('/inquiry/data', [InquiryController::class, 'getData']);
    Route::get('/inquiry/{id}', [InquiryController::class, 'index']);
    Route::get('/inquiry/view/{id}', [InquiryController::class, 'view']);
    Route::get('/inquiry/desktop', [InquiryController::class, 'getDesktop']);
    Route::get('/inquiry/cancel', [InquiryController::class, 'cancel']);
    Route::get('/inquiry/cancel/data', [InquiryController::class, 'data_cancel']);
    Route::get('/inquiryclaim/view/{id}', [InquiryController::class, 'detail_inquiry_claim']);




    Route::get('/sertifikat', [SertifikatController::class, 'index']);
    Route::get('/sertifikat/data', [SertifikatController::class, 'getData']);
    Route::get('/sertifikat/view/{id}', [SertifikatController::class, 'view']);
    Route::get('/sertifikat/invoice/{id}', [SertifikatController::class, 'invoice']);
    Route::get('/sertifikat/cert/{id}', [SertifikatController::class, 'sertifikat']);
    Route::get('/sertifikat/topup/{id}', [SertifikatController::class, 'topup']);
    Route::post('/sertifikat/topup/store', [SertifikatController::class, 'storetopup']);
    Route::get('/sertifikat/desktop', [SertifikatController::class, 'getDesktop']);

    Route::get('/kalkulator', [KalkulatorController::class, 'index']);
    Route::post('/kalkulator/hitung', [KalkulatorController::class, 'hitung']);
    Route::get('/kalkulator/detail/{id}', [KalkulatorController::class, 'detail']);


    // Panduan
    Route::get('/panduan', [PanduanController::class, 'index']);
    Route::get('/panduan/data', [PanduanController::class, 'getData']);


    // broker

    // VERIFIKASI
    Route::get('/verifikasi', [VerifikasiController::class, 'index']);
    Route::get('/verifikasi/desktop', [VerifikasiController::class, 'getDesktop']);
    Route::get('/verifikasi/data', [VerifikasiController::class, 'getData']);
    Route::get('/verifikasi/edit/{id}', [VerifikasiController::class, 'edit']);
    Route::post('/verifikasi/update', [VerifikasiController::class, 'update'])->name('verifikasi.update');
    Route::get('/verifikasi/revisi/{id}', [VerifikasiController::class, 'revisi']);
    Route::get('/verifikasi/sppa/{id}', [VerifikasiController::class, 'sppa']);
    Route::get('/verifikasi/log/{id}', [VerifikasiController::class, 'log']);
    Route::get('/verifikasi/approve/{id}', [VerifikasiController::class, 'approve']);
    Route::get('/verifikasi/reject/{id}', [VerifikasiController::class, 'reject']);


    // VALIDASI
    Route::get('/validasi', [ValidasiController::class, 'index']);
    Route::get('/validasi/desktop', [ValidasiController::class, 'getDesktop']);
    Route::get('/validasi/data', [ValidasiController::class, 'getData']);
    Route::get('/validasi/validasi/{id}', [ValidasiController::class, 'cekvalidasi']);
    Route::get('/validasi/reject/{id}', [ValidasiController::class, 'reject']);
    Route::get('/validasi/rollback/{id}', [ValidasiController::class, 'rollback']);
    Route::post('/validasi/update', [ValidasiController::class, 'update'])->name('validasi.update');
    Route::get('/validasi/revisi/{id}', [ValidasiController::class, 'revisi']);
    Route::get('/validasi/sppa/{id}', [ValidasiController::class, 'sppa']);
    Route::get('/validasi/log/{id}', [ValidasiController::class, 'log']);
    Route::get('/validasi/approve/{id}', [ValidasiController::class, 'approve']);
    Route::get('/validasi/reject/{id},{asuransi}', [ValidasiController::class, 'reject']);

    // PEMBATALAN
    Route::get('/pembatalan', [PembatalanController::class, 'index']);
    Route::get('/pembatalan/add', [PembatalanController::class, 'inquirycancel']);
    Route::get('/pembatalan/data', [PembatalanController::class, 'getData']);
    Route::get('/pembatalan/data_inquiry_cancel', [PembatalanController::class, 'getInquiry']);
    Route::get('/pembatalan/detail_cancel/{id}', [PembatalanController::class, 'detail_cancel']);
    Route::get('/pembatalan/view/{id}', [PembatalanController::class, 'view']);
    Route::get('/pembatalan/desktop', [PembatalanController::class, 'getDesktop']);
    Route::get('/pembatalan/log/{id}/{type}', [PembatalanController::class, 'log']);
    Route::get('/pembatalan/doc/{id}/{type}', [DocumentController::class, 'doc']);
    Route::get('/pembatalan/cetak/{id}', [PembatalanController::class, 'cetak']);
    Route::get('/pembatalan/approve/{id}', [PembatalanController::class, 'approve']);
    Route::post('/pembatalan/store', [PembatalanController::class, 'store'])->name('pembatalan.store');

    // KLAIM
    Route::get('/klaim', [KlaimController::class, 'index']);
    Route::get('/klaim/add', [KlaimController::class, 'inquiryklaim']);
    Route::get('/klaim/data', [KlaimController::class, 'getData']);
    Route::get('/klaim/data_inquiry_cancel', [KlaimController::class, 'getInquiry']);
    Route::get('/klaim/desktop', [KlaimController::class, 'getDesktop']);
    Route::get('/klaim/pro', [KlaimController::class, 'pro']);
    Route::get('/klaim/pro/data', [KlaimController::class, 'getPro']);
    Route::get('/klaim/edit/{id}', [KlaimController::class, 'edit']);
    Route::get('/klaim/log/{id}/{type}', [PembatalanController::class, 'log']);
    Route::get('/klaim/doc/{id}/{type}', [DocumentController::class, 'doc']);
    Route::get('/klaim/klaim/{id}', [DocumentController::class, 'klaim']);

    // Checker
    Route::get('/checker', [CheckerController::class, 'index']);
    Route::get('/checker/desktop', [CheckerController::class, 'getDesktop']);
    Route::get('/checker/edit/{id}', [CheckerController::class, 'edit']);
    Route::post('/checker/update', [CheckerController::class, 'update'])->name('checker.update');
    Route::get('/checker/approve/{id}', [CheckerController::class, 'approve']);

    // Proses
    Route::get('/proses', [ProsesController::class, 'index']);
    Route::get('/proses/desktop', [ProsesController::class, 'getDesktop']);
    Route::get('/proses/edit/{id}', [ProsesController::class, 'edit']);
    Route::post('/proses/update', [ProsesController::class, 'update'])->name('proses.update');
    Route::get('/proses/approve/{id}', [ProsesController::class, 'approve']);
    Route::get('/proses/rollback/{id}', [ProsesController::class, 'rollback']);

    // PEMBAYARAN
    Route::get('/pembayaran', [PembayaranController::class, 'index']);
    Route::get('/pembayaran/add', [PembayaranController::class, 'add']);
    Route::get('/pembayaran/edit/{id}', [PembayaranController::class, 'edit']);
    Route::get('/pembayaran/delete/{id}/{regid}', [PembayaranController::class, 'delete']);
    Route::get('/pembayaran/data', [PembayaranController::class, 'getData']);
    Route::get('/pembayaran/get_nama', [PembayaranController::class, 'get_nama']);
    Route::get('/pembayaran/desktop', [PembayaranController::class, 'getDesktop']);
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::post('/pembayaran/update', [PembayaranController::class, 'update'])->name('pembayaran.update');

    Route::get('/push_notif', [Push_notifController::class, 'index']);
    Route::get('/push_notif/add', [Push_notifController::class, 'add']);
    Route::get('/push_notif/edit/{id}', [Push_notifController::class, 'edit']);
    Route::get('/push_notif/delete/{id}', [Push_notifController::class, 'delete']);
    Route::get('/push_notif/data', [Push_notifController::class, 'getData']);
    Route::get('/push_notif/get_nama', [Push_notifController::class, 'get_nama']);
    Route::get('/push_notif/desktop', [Push_notifController::class, 'getDesktop']);
    Route::post('/push_notif/store', [Push_notifController::class, 'store'])->name('push_notif.store');
    Route::post('/push_notif/update', [Push_notifController::class, 'update'])->name('push_notif.update');

    // BORDERO
    Route::get('/bordero', [BorderoController::class, 'index']);
    Route::get('/bordero/add', [BorderoController::class, 'add']);
    Route::get('/bordero/data', [BorderoController::class, 'getData']);
    Route::get('/bordero/desktop', [BorderoController::class, 'getDesktop']);
    Route::post('/bordero/store', [BorderoController::class, 'store'])->name('bordero.store');

    // REVISI
    Route::get('/revisi', [RevisiController::class, 'index']);
    Route::get('/revisi/add/{id}', [RevisiController::class, 'add']);
    Route::get('/revisi/data', [RevisiController::class, 'getData']);
    Route::get('/revisi/desktop', [RevisiController::class, 'getDesktop']);
    Route::post('/revisi/store', [RevisiController::class, 'store'])->name('revisi.store');

    // ROLLBACK
    Route::get('/rollback', [RollbackController::class, 'index']);
    Route::get('/rollback/add', [RollbackController::class, 'add']);
    Route::get('/rollback/data', [RollbackController::class, 'getData']);
    Route::get('/rollback/desktop', [RollbackController::class, 'getDesktop']);

    // CABANG
    Route::get('/cabang', [CabangController::class, 'index']);
    Route::get('/cabang/add', [CabangController::class, 'add']);
    Route::get('/cabang/data', [CabangController::class, 'getData']);
    Route::get('/cabang/desktop', [CabangController::class, 'getDesktop']);
    Route::post('/cabang/store', [CabangController::class, 'store'])->name('cabang.store');
    Route::post('/cabang/update', [CabangController::class, 'update'])->name('cabang.update');
    Route::post('/cabang/update/{id}', [CabangController::class, 'update']);
    Route::get('/cabang/edit/{id}', [CabangController::class, 'edit']);


    // MITRA
    Route::get('/mitra', [MitraController::class, 'index']);
    Route::get('/mitra/add', [MitraController::class, 'add']);
    Route::get('/mitra/data', [MitraController::class, 'getData']);
    Route::get('/mitra/desktop', [MitraController::class, 'getDesktop']);
    Route::post('/mitra/store', [MitraController::class, 'store'])->name('mitra.store');
    Route::post('/mitra/update', [MitraController::class, 'update'])->name('mitra.update');
    Route::post('/mitra/update/{id}', [MitraController::class, 'update']);
    Route::get('/mitra/edit/{id}', [MitraController::class, 'edit']);
    Route::get('/mitra/delete/{id}', [MitraController::class, 'delete']);

    // KONTAK
    Route::get('/kontak', [KontakController::class, 'index']);
    Route::get('/kontak/add', [KontakController::class, 'add']);
    Route::get('/kontak/data', [KontakController::class, 'getData']);
    Route::get('/kontak/desktop', [KontakController::class, 'getDesktop']);
    Route::post('/kontak/update', [KontakController::class, 'update'])->name('kontak.update');
    Route::get('/kontak/edit/{id}', [KontakController::class, 'edit']);
    Route::get('/kontak/delete/{id}', [KontakController::class, 'delete']);

    // USER
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/add', [UserController::class, 'add']);
    Route::get('/user/data', [UserController::class, 'getData']);
    Route::get('/user/desktop', [UserController::class, 'getDesktop']);
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/edit/{id}', [UserController::class, 'edit']);
    Route::get('/user/reset/{id}', [UserController::class, 'reset']);
    Route::get('/user/email/{id}', [UserController::class, 'email']);
    Route::get('/user/delete/{id}', [UserController::class, 'delete']);

    // RATE
    Route::get('/rate', [RateController::class, 'index']);
    Route::get('/rate/add', [RateController::class, 'add']);
    Route::get('/rate/data', [RateController::class, 'getData']);
    Route::get('/rate/desktop', [RateController::class, 'getDesktop']);

    // REAS
    Route::get('/reas', [ReasController::class, 'index']);
    Route::get('/reas/add', [ReasController::class, 'add']);
    Route::get('/reas/data', [ReasController::class, 'getData']);
    Route::get('/reas/desktop', [ReasController::class, 'getDesktop']);

    // Cadangan
    Route::get('/cadangan', [CadanganController::class, 'index']);
    Route::get('/cadangan/add', [CadanganController::class, 'add']);
    Route::get('/cadangan/data', [CadanganController::class, 'getData']);
    Route::get('/cadangan/desktop', [CadanganController::class, 'getDesktop']);
    Route::get('/cadangan/desktop/detail', [CadanganController::class, 'getDetail']);
    Route::get('/cadangan/detail/{id}', [CadanganController::class, 'detail']);
    Route::get('/cadangan/desktop/transaksi', [CadanganController::class, 'gettransaksi']);
    Route::get('/cadangan/transaksi/{id}', [CadanganController::class, 'transaksi']);

    // Cadangan
    Route::get('/reasuransi', [ReasuransiController::class, 'index']);
    Route::get('/reasuransi/add', [ReasuransiController::class, 'add']);
    Route::get('/reasuransi/data', [ReasuransiController::class, 'getData']);
    Route::get('/reasuransi/desktop', [ReasuransiController::class, 'getDesktop']);
    Route::get('/reasuransi/desktop/detail', [ReasuransiController::class, 'getDetail']);
    Route::get('/reasuransi/detail/{id}', [ReasuransiController::class, 'detail']);

    // Maintenance
    Route::get('/maintenance', [HomeController::class, 'maintenance']);

    // Document
    Route::get('/document/data', [DocumentController::class, 'getData']);
    Route::get('/document/data/{any}', [DocumentController::class, 'getData']);

    // Test
    // Route::get('/test/{any}', [Functions::class, 'formatBytes']);
    Route::get('/test', [Functions::class, 'test']);
    Route::view('/test/upload', 'modul.bordero.report');
    Route::post('/test/upload', [Functions::class, 'upload']);

    // }


});
// Route::view('/user', 'home');
