<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/captcha', [AuthController::class, 'captcha'])->name('captcha');
// OTP verification removed: login now authenticates directly without OTP

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Role-specific dashboards (new namespaced controllers)
    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/customer/dashboard', [\App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('customer.dashboard');

    // Job Order (accessible by both roles)
    // Keep generic route for compatibility but redirect to role-specific named routes
    Route::get('/joborders', function () {
        $role = auth()->user()->role ?? null;
        if ($role === 'admin') {
            return redirect()->route('admin.joborder.index');
        }
        return redirect()->route('customer.joborder.index');
    })->name('joborder.index');

    // Explicit role-specific joborder routes (new namespaced controllers)
    Route::get('/admin/joborders', [\App\Http\Controllers\Admin\JobOrderController::class, 'index'])->name('admin.joborder.index');
    Route::get('/customer/joborders', [\App\Http\Controllers\Customer\JobOrderController::class, 'index'])->name('customer.joborder.index');

    // Admin joborder CRUD
    Route::get('/admin/joborders/create', [\App\Http\Controllers\Admin\JobOrderController::class, 'create'])->name('admin.joborder.create');
    Route::post('/admin/joborders', [\App\Http\Controllers\Admin\JobOrderController::class, 'store'])->name('admin.joborder.store');
    Route::get('/admin/joborders/{joborder}/edit', [\App\Http\Controllers\Admin\JobOrderController::class, 'edit'])->name('admin.joborder.edit');
    Route::put('/admin/joborders/{joborder}', [\App\Http\Controllers\Admin\JobOrderController::class, 'update'])->name('admin.joborder.update');
    Route::delete('/admin/joborders/{joborder}', [\App\Http\Controllers\Admin\JobOrderController::class, 'destroy'])->name('admin.joborder.destroy');
    Route::post('/admin/joborders/{joborder}/update-progress', [\App\Http\Controllers\Admin\JobOrderController::class, 'updateProgress'])->name('admin.joborder.updateProgress');
    Route::post('/admin/joborders/{joborder}/update-actual', [\App\Http\Controllers\Admin\JobOrderController::class, 'updateActual'])->name('admin.joborder.updateActual');

    // Material routes (admin)
    // Data Material (CRUD)
    Route::resource('admin/materials', \App\Http\Controllers\MaterialController::class, [
        'names' => [
            'index' => 'admin.materials.index',
            'create' => 'admin.materials.create',
            'store' => 'admin.materials.store',
            'show' => 'admin.materials.show',
            'edit' => 'admin.materials.edit',
            'update' => 'admin.materials.update',
            'destroy' => 'admin.materials.destroy',
        ]
    ]);

    // Material Movements (Perpindahan Stok)
    Route::prefix('admin/material-movements')->name('admin.material-movements.')->group(function () {
        Route::get('/', [\App\Http\Controllers\MaterialMovementController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\MaterialMovementController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\MaterialMovementController::class, 'store'])->name('store');
        Route::get('/{materialMovement}', [\App\Http\Controllers\MaterialMovementController::class, 'show'])->name('show');
        Route::get('/{materialMovement}/edit', [\App\Http\Controllers\MaterialMovementController::class, 'edit'])->name('edit');
        Route::put('/{materialMovement}', [\App\Http\Controllers\MaterialMovementController::class, 'update'])->name('update');
        Route::delete('/{materialMovement}', [\App\Http\Controllers\MaterialMovementController::class, 'destroy'])->name('destroy');

        // Stok Masuk
        Route::get('/stock/in', [\App\Http\Controllers\MaterialMovementController::class, 'stockIn'])->name('stock-in');
        Route::post('/stock/in', [\App\Http\Controllers\MaterialMovementController::class, 'processStockIn'])->name('process-stock-in');

        // Stok Keluar
        Route::get('/stock/out', [\App\Http\Controllers\MaterialMovementController::class, 'stockOut'])->name('stock-out');
        Route::post('/stock/out', [\App\Http\Controllers\MaterialMovementController::class, 'processStockOut'])->name('process-stock-out');
    });

    // Admin Kategori & Satuan routes
    Route::get('/admin/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::get('/admin/kategori/create', [\App\Http\Controllers\Admin\KategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/admin/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/admin/kategori/{kategori}/edit', [\App\Http\Controllers\Admin\KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/admin/kategori/{kategori}', [\App\Http\Controllers\Admin\KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{kategori}', [\App\Http\Controllers\Admin\KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

    Route::get('/admin/satuan', [\App\Http\Controllers\Admin\SatuanController::class, 'index'])->name('admin.satuan.index');
    Route::get('/admin/satuan/create', [\App\Http\Controllers\Admin\SatuanController::class, 'create'])->name('admin.satuan.create');
    Route::post('/admin/satuan', [\App\Http\Controllers\Admin\SatuanController::class, 'store'])->name('admin.satuan.store');
    Route::get('/admin/satuan/{satuan}/edit', [\App\Http\Controllers\Admin\SatuanController::class, 'edit'])->name('admin.satuan.edit');
    Route::put('/admin/satuan/{satuan}', [\App\Http\Controllers\Admin\SatuanController::class, 'update'])->name('admin.satuan.update');
    Route::delete('/admin/satuan/{satuan}', [\App\Http\Controllers\Admin\SatuanController::class, 'destroy'])->name('admin.satuan.destroy');



    // Man Power Management
    Route::get('/admin/manpower', [\App\Http\Controllers\Admin\ManpowerController::class, 'index'])->name('admin.manpower.index');
    Route::get('/admin/manpower/create', [\App\Http\Controllers\Admin\ManpowerController::class, 'create'])->name('admin.manpower.create');
    Route::post('/admin/manpower', [\App\Http\Controllers\Admin\ManpowerController::class, 'store'])->name('admin.manpower.store');
    Route::get('/admin/manpower/{manpower}', [\App\Http\Controllers\Admin\ManpowerController::class, 'show'])->name('admin.manpower.show');
    Route::get('/admin/manpower/{manpower}/edit', [\App\Http\Controllers\Admin\ManpowerController::class, 'edit'])->name('admin.manpower.edit');
    Route::put('/admin/manpower/{manpower}', [\App\Http\Controllers\Admin\ManpowerController::class, 'update'])->name('admin.manpower.update');
    Route::delete('/admin/manpower/{manpower}', [\App\Http\Controllers\Admin\ManpowerController::class, 'destroy'])->name('admin.manpower.destroy');

    // Performance Man Power
    Route::get('/admin/performance', [\App\Http\Controllers\Admin\PerformanceController::class, 'index'])->name('admin.performance.index');
    Route::get('/admin/performance/create', [\App\Http\Controllers\Admin\PerformanceController::class, 'create'])->name('admin.performance.create');
    Route::post('/admin/performance', [\App\Http\Controllers\Admin\PerformanceController::class, 'store'])->name('admin.performance.store');
    Route::get('/admin/performance/{performance}', [\App\Http\Controllers\Admin\PerformanceController::class, 'show'])->name('admin.performance.show');
    Route::get('/admin/performance/{performance}/edit', [\App\Http\Controllers\Admin\PerformanceController::class, 'edit'])->name('admin.performance.edit');
    Route::put('/admin/performance/{performance}', [\App\Http\Controllers\Admin\PerformanceController::class, 'update'])->name('admin.performance.update');
    Route::delete('/admin/performance/{performance}', [\App\Http\Controllers\Admin\PerformanceController::class, 'destroy'])->name('admin.performance.destroy');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile (edit username & password)
    Route::get('/admin/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');

    // Customer profile routes
    Route::get('/customer/profile', [\App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::put('/customer/profile', [\App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('customer.profile.update');
});
