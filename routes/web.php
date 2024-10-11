<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategorisController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authorize;
use Monolog\Level;







/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::pattern('id', '[0-9]+');
// Tugas Register
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'postRegister']);


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
Route::get('/', [WelcomeController::class, 'index']);


// route user
Route::middleware(['authorize:ADM'])->group(function(){
Route::group(['prefix' => 'user'], function() {
    Route::get('/', [UserController::class, 'index']);  
    Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);         // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); //Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax 
    Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  // menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);     // menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});
});


//route level
// Route::group(['prefix' =>'level'],function(){
    Route::middleware(['authorize:ADM'])->group(function(){
    Route::get('/level', [LevelController::class, 'index']);          // menampilkan halaman awal level
    Route::post('/level/list', [LevelController::class, 'list']);      // menampilkan data level dalam json untuk datables
    Route::get('/level/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
    Route::post('/level', [LevelController::class,'store']);          // menyimpan data level baru
    Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']); // Menampilkan halaman form tambah level Ajax
    Route::post('/level/ajax', [LevelController::class, 'store_ajax']); // Menampilkan data level baru Ajax
    Route::get('/level/{id}', [LevelController::class, 'show']);       // menampilkan detail level
    Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']); 
    Route::get('/level/{id}/edit', [LevelController::class, 'edit']);  // menampilkan halaman form edit level
    Route::put('/level/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
    Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // Menampilkan halaman form edit level Ajax
    Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']); // Menyimpan perubahan data level Ajax
    Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete level Ajax
    Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data level Ajax
    Route::delete('/level/{id}', [LevelController::class, 'destroy']); // menghapus data level
});
//route kategori
Route::middleware(['authorize:ADM,MNG'])->group(function(){
Route::group(['prefix' =>'kategori'],function(){
    Route::get('/', [KategorisController::class, 'index']);          // menampilkan halaman awal kategori
    Route::post('/list', [KategorisController::class, 'list']);      // menampilkan data kategori dalam json untuk datables
    Route::get('/create', [KategorisController::class, 'create']);   // menampilkan halaman form tambah kategori
    Route::post('/', [KategorisController::class,'store']);          // menyimpan data kategori baru
    Route::get('/create_ajax', [KategorisController::class, 'create_ajax']); // Menampilkan halaman form tambah kategori Ajax
    Route::post('/ajax', [KategorisController::class, 'store_ajax']); // Menampilkan data kategori baru Ajax
    Route::get('/{id}', [KategorisController::class, 'show']);       // menampilkan detail kategori
    Route::get('/{id}/show_ajax', [KategorisController::class, 'show_ajax']);
    Route::get('/{id}/edit', [KategorisController::class, 'edit']);  // menampilkan halaman form edit kategori
    Route::put('/{id}', [KategorisController::class, 'update']);     // menyimpan perubahan data kategori
    Route::get('/{id}/edit_ajax', [KategorisController::class, 'edit_ajax']); // Menampilkan halaman form edit kategori Ajax
    Route::put('/{id}/update_ajax', [KategorisController::class, 'update_ajax']); // Menyimpan perubahan data kategori Ajax
    Route::get('/{id}/delete_ajax', [KategorisController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete kategori Ajax
    Route::delete('/{id}/delete_ajax', [KategorisController::class, 'delete_ajax']); // Untuk hapus data kategori Ajax
    Route::delete('/{id}', [KategorisController::class, 'destroy']); // menghapus data kategori
});
});
//route barang
// Route::group(['prefix' =>'barang'],function(){
//     Route::get('/', [BarangController::class, 'index']);          // menampilkan halaman awal barang
//     Route::post('/list', [BarangController::class, 'list']);      // menampilkan data barang dalam json untuk datables
//     Route::get('/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
//     Route::post('/', [BarangController::class,'store']);          // menyimpan data barang baru
//     Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah barang Ajax
//     Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menampilkan data barang baru Ajax
//     Route::get('/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
//     Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
//     Route::get('/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
//     Route::put('/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
//     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit barang Ajax
//     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data barang Ajax
//     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete barang Ajax
//     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data barang Ajax
//     Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
// });

//route barang
// Route::group(['prefix' =>'barang'],function(){
//     Route::middleware(['authorize:ADM'])->group(function(){
//     Route::get('/', [BarangController::class, 'index']);          // menampilkan halaman awal barang
//     Route::post('/barang/list', [BarangController::class, 'list']);      // menampilkan data barang dalam json untuk datables
//     Route::get('/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
//     Route::post('/', [BarangController::class,'store']);          // menyimpan data barang baru
//     Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah barang Ajax
//     Route::post('/barang/ajax', [BarangController::class, 'store_ajax']); // Menampilkan data barang baru Ajax
//     Route::get('/barang/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
//     Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']);
//     Route::get('/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
//     Route::put('/barang/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
//     Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit barang Ajax
//     Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data barang Ajax
//     Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete barang Ajax
//     Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data barang Ajax
//     Route::delete('/barang/{id}', [BarangController::class, 'destroy']); // menghapus data barang
// });

// Route::middleware(['authorize:MNG'])->group(function(){
//     Route::get('/', [BarangController::class, 'index']);          // menampilkan halaman awal barang
//     Route::post('/barang/list', [BarangController::class, 'list']);      // menampilkan data barang dalam json untuk datables
//     Route::get('/barang/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
//     Route::post('/', [BarangController::class,'store']);          // menyimpan data barang baru
//     Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah barang Ajax
//     Route::post('/barang/ajax', [BarangController::class, 'store_ajax']); // Menampilkan data barang baru Ajax
//     Route::get('/barang/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
//     Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']);
//     Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
//     Route::put('/barang/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
//     Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit barang Ajax
//     Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data barang Ajax
//     Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete barang Ajax
//     Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data barang Ajax
//     Route::delete('/barang/{id}', [BarangController::class, 'destroy']); // menghapus data barang
// });


Route::middleware(['authorize:ADM,MNG'])->group(function(){
    Route::get('/barang', [BarangController::class, 'index']);          // menampilkan halaman awal barang
    Route::post('/barang/list', [BarangController::class, 'list']);      // menampilkan data barang dalam json untuk datables
    Route::get('/barang/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
    Route::post('/barang', [BarangController::class,'store']);          // menyimpan data barang baru
    Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah barang Ajax
    Route::post('/barang/ajax', [BarangController::class, 'store_ajax']); // Menampilkan data barang baru Ajax
    Route::get('/barang/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
    Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']);
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
    Route::put('/barang/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
    Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit barang Ajax
    Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data barang Ajax
    Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete barang Ajax
    Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data barang Ajax
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']); // menghapus data barang
});

//route supplier
Route::middleware(['authorize:ADM,MNG' ])->group(function(){
Route::group(['prefix' =>'supplier'],function(){
    Route::get('/', [SupplierController::class, 'index']);          // menampilkan halaman awal supplier
    Route::post('/list', [SupplierController::class, 'list']);      // menampilkan data supplier dalam json untuk datables
    Route::get('/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah supplier
    Route::post('/', [SupplierController::class,'store']);          // menyimpan data supplier baru
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah supplier Ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Menampilkan data supplier baru Ajax
    Route::get('/{id}', [SupplierController::class, 'show']);       // menampilkan detail supplier
    Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);  // menampilkan halaman form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data supplier
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // Menampilkan halaman form edit supplier Ajax
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // Menyimpan perubahan data supplier Ajax
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete supplier Ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data supplier Ajax
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
});
});
});