<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Vendor\VendorController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// admin controller
Route::middleware(['auth', 'access:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'admin'])->name('admin.dashbaord');

    //profile
    Route::get('/admin/profile',[AdminController::class,'profile'])->name('admin.profile');
    Route::post('admin/profile/store',[AdminController::class,'profileStore'])->name('admin.profile.store');

    //change password
    Route::get('change/password',[AdminController::class,'changepassword'])->name('change.password');
    Route::post('update/password',[AdminController::class,'updatepassword'])->name('update.password');

    //logout
    Route::get('admin/logout',[AdminController::class,'logout'])->name('admin.logout');
});

//admin login
Route::get('admin/login',[AdminController::class,'login'])->name('admin.login');


// vendor controller
Route::middleware(['auth', 'access:vendor'])->group(function () {
    Route::get('vendor/dashboard', [VendorController::class, 'vendor'])->name('vendor.dashbaord');

    //profile
    Route::get('/vendor/profile',[VendorController::class,'profile'])->name('vendor.profile');
    Route::post('vendor/profile/store',[VendorController::class,'profileStore'])->name('vendor.profile.store');

    //change password
    Route::get('/change/password',[VendorController::class,'changepassword'])->name('change.password');
    Route::post('/update/password',[VendorController::class,'updatepassword'])->name('update.password');

    //logout
    Route::get('vendor/logout',[VendorController::class,'logout'])->name('vendor.logout');
});
//vendor login
Route::get('vendor/login',[VendorController::class,'login'])->name('vendor.login');
