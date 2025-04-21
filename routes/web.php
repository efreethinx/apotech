<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembelianDetailController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => to_route('login'));

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);

    Route::get('/satuan/data', [SatuanController::class, 'data'])->name('satuan.data');
    Route::resource('/satuan', SatuanController::class);

    Route::get('/obat/data', [ObatController::class, 'data'])->name('obat.data');
    Route::post('/obat/delete-selected', [ObatController::class, 'deleteSelected'])->name('obat.delete_selected');
    Route::post('/obat/cetak-barcode', [ObatController::class, 'cetakBarcode'])->name('obat.cetak_barcode');
    Route::resource('/obat', ObatController::class);

    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);

    Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
    Route::post('/member/cetak-member', [MemberController::class, 'cetakMember'])->name('member.cetak_member');
    Route::resource('/member', MemberController::class);

    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('/user', UserController::class);

    Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
    Route::resource('/pengeluaran', PengeluaranController::class);

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
    Route::post('/profil/password', [UserController::class, 'updatePassword'])->name('user.updatePassword');

    Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

    Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
    Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
    Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
    Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
    Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

    Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
    Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])
        ->name('transaksi.load_form');
    Route::resource('/transaksi', PenjualanDetailController::class)->except('create', 'show', 'edit');

    Route::group(['prefix' => 'pembelian', 'as' => 'pembelian.'], function () {
        Route::get('/data', [PembelianController::class, 'data'])->name('data');
        Route::get('/supplier/data', [PembelianController::class, 'supplier'])->name('supplier.data');
        Route::get('/obat/data', [PembelianController::class, 'obat'])->name('obat.data');
        Route::get('/{id}/data', [PembelianController::class, 'show'])->name('show');
        Route::get('/{id_supplier}/create', [PembelianController::class, 'create'])->name('create');

        Route::get('/', [PembelianController::class, 'index'])->name('index');
        Route::post('/', [PembelianController::class, 'store'])->name('store');
        Route::delete('/{id}', [PembelianController::class, 'destroy'])->name('destroy');

        Route::get('/transaksi/{id}/data', [PembelianDetailController::class, 'data'])->name('transaksi.data');
        Route::get('/transaksi/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])->name('transaksi.load_form');
        Route::resource('/transaksi', PembelianDetailController::class)->only('index', 'store', 'update', 'destroy');
    });

    Route::get('/stok-opname', [StockOpnameController::class, 'index'])->name('stok-opname');
    Route::post('/stok-opname', [StockOpnameController::class, 'store'])->name('stok-opname.store');
    Route::get('stok/data', [StockOpnameController::class, 'stokObatData'])->name('stok.data');
    Route::get('stok-opname/data', [StockOpnameController::class, 'stokOpnameData'])->name('stok_opname.data');
    Route::get('/stok-obat/{id}', [StockOpnameController::class, 'getStokObat']);
    Route::delete('/stok-opname/{id}', [StockOpnameController::class, 'destroy'])->name('stok-opname.destroy');

    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

require __DIR__ . '/auth.php';
