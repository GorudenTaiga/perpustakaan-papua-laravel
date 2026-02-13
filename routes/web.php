<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/contact')->name('contact');
Route::get('/subscribe')->name('subscribe');
Route::get('/help', function () {
    return view('help');
})->name('help');
Route::get('/categories', [BukuController::class, 'allCategory'])->name('allCategories');
Route::get('/buku', [BukuController::class, 'index'])->name('allBuku');
Route::get('/buku/{slug}', [BukuController::class, 'view'])->name('buku');

Route::middleware(['auth:member'])->group(function () {
    Route::get('/profile', [UserController::class, 'index'])->name('userProfile');
    Route::get('/pinjam', [UserController::class, 'peminjaman'])->name('pinjam');
    Route::post('/pinjam/store', [UserController::class, 'pinjam'])->name('pinjam.store');
    Route::get('/cetakKTA/{id}', [UserController::class, 'cetakKTA'])->name('cetakKTA');
    Route::put('/member/update-photo', [UserController::class, 'updatePhoto'])->name('member.updatePhoto');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::get('/wishlist/partial', [WishlistController::class, 'partial'])->name('wishlist.partial');

});

Route::get('/getImage/{path}', [AssetController::class, 'index']);

// Route::middleware(['auth:admin'])->group(function () {
//     Route::prefix('/admin')->group(function () {
//         Route::prefix('/buku')->group(function () {
//             Route::get('/', [BukuController::class, 'index'])->name('adminBuku');
//             Route::get('/create', [BukuController::class, 'create'])->name('adminBukuCreate');
//             Route::post('/store', [BukuController::class, 'store'])->name('adminBukuStore');
//             Route::get('/{buku}/edit', [BukuController::class, 'edit'])->name('adminBukuEdit');
//             Route::put('/{buku}', [BukuController::class, 'update'])->name('adminBukuUpdate');
//             Route::delete('/{buku}', [BukuController::class, 'destroy'])->name('adminBukuDestroy');
//             Route::post('/category/store', [BukuController::class, 'storeCategory'])->name('adminBukuCategoryStore');
//         });
//         // Add Filament admin panel route group
//         /* The line `\Filament\Facades\Filament::routes();` is defining routes for the Filament admin
//         panel. Filament is a Laravel package that provides a customizable admin panel for managing
//         resources in your application. By calling the `routes()` method on the `Filament` facade, it
//         sets up the necessary routes for the admin panel to function properly, allowing you to
//         access and interact with the admin panel features. */
//         // \Filament\Facades\Filament::routes();
//     });
// });

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('postLogin');
Route::post('/logout', [LoginController::class, 'logout'])->name('postLogout');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('postRegister');

Route::any('{catchall}', function () {
    return view('errors.404');
});