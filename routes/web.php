<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/captcha', [AuthController::class, 'captcha'])->name('captcha');

// Public monitoring page (guest access)
Route::get('/monitor', [\App\Http\Controllers\MonitorController::class, 'index'])->name('monitor');

// Public customer registration (simple public form)
Route::get('/register-customer', [\App\Http\Controllers\CustomerRegistrationController::class, 'show'])->name('customer.register');
Route::post('/register-customer', [\App\Http\Controllers\CustomerRegistrationController::class, 'store'])->name('customer.register.store');
// OTP verification removed: login now authenticates directly without OTP

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Role-specific dashboards (new namespaced controllers)
    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/customer/dashboard', [\App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/management-customer/dashboard', [\App\Http\Controllers\ManagementCustomer\DashboardController::class, 'index'])->name('management-customer.dashboard');
    Route::get('/management-epp/dashboard', [\App\Http\Controllers\ManagementEpp\DashboardController::class, 'index'])->name('management-epp.dashboard');
    Route::get('/management-customer/requests', [\App\Http\Controllers\ManagementCustomer\RequestController::class, 'index'])->name('management-customer.requests.index');
    Route::get('/management-customer/requests/{jobOrder}', [\App\Http\Controllers\ManagementCustomer\RequestController::class, 'show'])->name('management-customer.requests.show');
    Route::get('/management-customer/requests/{jobOrder}/export-pdf', [\App\Http\Controllers\ManagementCustomer\RequestController::class, 'exportPdf'])->name('management-customer.requests.exportPdf');
    Route::post('/management-customer/requests/{jobOrder}/approve', [\App\Http\Controllers\ManagementCustomer\RequestController::class, 'approve'])->name('management-customer.requests.approve');
    Route::post('/management-customer/requests/{jobOrder}/reject', [\App\Http\Controllers\ManagementCustomer\RequestController::class, 'reject'])->name('management-customer.requests.reject');

    Route::get('/management-epp/requests', [\App\Http\Controllers\ManagementEpp\RequestController::class, 'index'])->name('management-epp.requests.index');
    Route::get('/management-epp/requests/{jobOrder}', [\App\Http\Controllers\ManagementEpp\RequestController::class, 'show'])->name('management-epp.requests.show');
    Route::get('/management-epp/requests/{jobOrder}/export-pdf', [\App\Http\Controllers\ManagementEpp\RequestController::class, 'exportPdf'])->name('management-epp.requests.exportPdf');
    Route::post('/management-epp/requests/{jobOrder}/approve', [\App\Http\Controllers\ManagementEpp\RequestController::class, 'approve'])->name('management-epp.requests.approve');
    Route::get('/customer/notifications', [\App\Http\Controllers\Customer\NotificationController::class, 'index'])->name('customer.notifications.index');
    Route::get('/customer/notifications/{notification}', [\App\Http\Controllers\Customer\NotificationController::class, 'show'])->name('customer.notifications.show');
    Route::post('/customer/notifications/{notification}/mark-as-read', [\App\Http\Controllers\Customer\NotificationController::class, 'markAsRead'])->name('customer.notifications.markAsRead');
    Route::post('/customer/notifications/mark-all-read', [\App\Http\Controllers\Customer\NotificationController::class, 'markAllAsRead'])->name('customer.notifications.markAllAsRead');
    Route::get('/customer/notifications/unread-count', [\App\Http\Controllers\Customer\NotificationController::class, 'getUnreadCount'])->name('customer.notifications.unreadCount');
    Route::get('/management-customer/notifications', [\App\Http\Controllers\ManagementCustomer\NotificationController::class, 'index'])->name('management-customer.notifications.index');
    Route::get('/management-customer/notifications/{notification}', [\App\Http\Controllers\ManagementCustomer\NotificationController::class, 'show'])->name('management-customer.notifications.show');
    Route::post('/management-customer/notifications/{notification}/mark-as-read', [\App\Http\Controllers\ManagementCustomer\NotificationController::class, 'markAsRead'])->name('management-customer.notifications.markAsRead');
    Route::post('/management-customer/notifications/mark-all-read', [\App\Http\Controllers\ManagementCustomer\NotificationController::class, 'markAllAsRead'])->name('management-customer.notifications.markAllAsRead');
    Route::get('/management-customer/notifications/unread-count', [\App\Http\Controllers\ManagementCustomer\NotificationController::class, 'getUnreadCount'])->name('management-customer.notifications.unreadCount');

    Route::get('/management-epp/notifications', [\App\Http\Controllers\ManagementEpp\NotificationController::class, 'index'])->name('management-epp.notifications.index');
    Route::get('/management-epp/notifications/{notification}', [\App\Http\Controllers\ManagementEpp\NotificationController::class, 'show'])->name('management-epp.notifications.show');
    Route::post('/management-epp/notifications/{notification}/mark-as-read', [\App\Http\Controllers\ManagementEpp\NotificationController::class, 'markAsRead'])->name('management-epp.notifications.markAsRead');
    Route::post('/management-epp/notifications/mark-all-read', [\App\Http\Controllers\ManagementEpp\NotificationController::class, 'markAllAsRead'])->name('management-epp.notifications.markAllAsRead');
    Route::get('/management-epp/notifications/unread-count', [\App\Http\Controllers\ManagementEpp\NotificationController::class, 'getUnreadCount'])->name('management-epp.notifications.unreadCount');

    // Job Order (accessible by both roles)
    // Keep generic route for compatibility but redirect to role-specific named routes
    Route::get('/joborders', function () {
        $user = auth()->user();
        if (($user->role ?? null) === 'admin') {
            return redirect()->route('admin.joborder.index');
        }
        if (($user->role ?? null) === 'customer' && $user->isManagementCustomer()) {
            return redirect()->route('management-customer.requests.index');
        }
        if (($user->role ?? null) === 'management-epp' || $user->isManagementEpp()) {
            return redirect()->route('management-epp.requests.index');
        }
        return redirect()->route('customer.joborder.index');
    })->name('joborder.index');

    // Explicit role-specific joborder routes (new namespaced controllers)
    Route::get('/admin/joborders', [\App\Http\Controllers\Admin\JobOrderController::class, 'index'])->name('admin.joborder.index');
    Route::get('/customer/joborders', [\App\Http\Controllers\Customer\JobOrderController::class, 'index'])->name('customer.joborder.index');

    // Customer joborder CRUD
    Route::get('/customer/joborders/create', [\App\Http\Controllers\Customer\JobOrderController::class, 'create'])->name('customer.joborder.create');
    Route::post('/customer/joborders', [\App\Http\Controllers\Customer\JobOrderController::class, 'store'])->name('customer.joborder.store');
    Route::get('/customer/joborders/{joborder}/edit', [\App\Http\Controllers\Customer\JobOrderController::class, 'edit'])->name('customer.joborder.edit');
    Route::put('/customer/joborders/{joborder}', [\App\Http\Controllers\Customer\JobOrderController::class, 'update'])->name('customer.joborder.update');
    Route::delete('/customer/joborders/{joborder}', [\App\Http\Controllers\Customer\JobOrderController::class, 'destroy'])->name('customer.joborder.destroy');
    Route::post('/customer/joborders/{joborder}/update-progress', [\App\Http\Controllers\Customer\JobOrderController::class, 'updateProgress'])->name('customer.joborder.updateProgress');
    Route::post('/customer/joborders/{joborder}/update-actual', [\App\Http\Controllers\Customer\JobOrderController::class, 'updateActual'])->name('customer.joborder.updateActual');

    // Customer PDF export for joborder
    Route::get('/customer/joborders/{joborder}/export-pdf', [\App\Http\Controllers\Customer\JobOrderController::class, 'exportPdf'])->name('customer.joborder.exportPdf');

    // Admin joborder CRUD
    Route::get('/admin/joborders/create', [\App\Http\Controllers\Admin\JobOrderController::class, 'create'])->name('admin.joborder.create');
    Route::post('/admin/joborders', [\App\Http\Controllers\Admin\JobOrderController::class, 'store'])->name('admin.joborder.store');
    Route::get('/admin/joborders/{joborder}', [\App\Http\Controllers\Admin\JobOrderController::class, 'show'])->name('admin.joborder.show');
    Route::get('/admin/joborders/{joborder}/edit', [\App\Http\Controllers\Admin\JobOrderController::class, 'edit'])->name('admin.joborder.edit');
    Route::put('/admin/joborders/{joborder}', [\App\Http\Controllers\Admin\JobOrderController::class, 'update'])->name('admin.joborder.update');
    Route::delete('/admin/joborders/{joborder}', [\App\Http\Controllers\Admin\JobOrderController::class, 'destroy'])->name('admin.joborder.destroy');
    Route::post('/admin/joborders/{joborder}/update-progress', [\App\Http\Controllers\Admin\JobOrderController::class, 'updateProgress'])->name('admin.joborder.updateProgress');
    Route::post('/admin/joborders/{joborder}/update-actual', [\App\Http\Controllers\Admin\JobOrderController::class, 'updateActual'])->name('admin.joborder.updateActual');

    // PDF export for joborder
    Route::get('/admin/joborders/{joborder}/export-pdf', [\App\Http\Controllers\Admin\JobOrderController::class, 'exportPdf'])->name('admin.joborder.exportPdf');

    // Material routes (admin)
    // Export Materials to PDF (must be declared before resource to avoid conflicting with show route)
    Route::get('/admin/materials/export-pdf', [\App\Http\Controllers\MaterialController::class, 'exportPdfAll'])->name('admin.materials.exportPdfAll');
    Route::get('/admin/materials/{material}/export-pdf', [\App\Http\Controllers\MaterialController::class, 'exportPdf'])->name('admin.materials.exportPdf');

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
        // Export Material Movements to PDF (declare before dynamic routes)
        Route::get('/export-pdf', [\App\Http\Controllers\MaterialMovementController::class, 'exportPdfAll'])->name('exportPdfAll');
        Route::get('/{materialMovement}/export-pdf', [\App\Http\Controllers\MaterialMovementController::class, 'exportPdf'])->name('exportPdf');

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

    Route::get('/admin/departement', [\App\Http\Controllers\Admin\DepartementController::class, 'index'])->name('admin.departement.index');
    Route::get('/admin/departement/create', [\App\Http\Controllers\Admin\DepartementController::class, 'create'])->name('admin.departement.create');
    Route::post('/admin/departement', [\App\Http\Controllers\Admin\DepartementController::class, 'store'])->name('admin.departement.store');
    Route::get('/admin/departement/{departement}/edit', [\App\Http\Controllers\Admin\DepartementController::class, 'edit'])->name('admin.departement.edit');
    Route::put('/admin/departement/{departement}', [\App\Http\Controllers\Admin\DepartementController::class, 'update'])->name('admin.departement.update');
    Route::delete('/admin/departement/{departement}', [\App\Http\Controllers\Admin\DepartementController::class, 'destroy'])->name('admin.departement.destroy');

    Route::get('/admin/jabatan', [\App\Http\Controllers\Admin\JabatanController::class, 'index'])->name('admin.jabatan.index');
    Route::get('/admin/jabatan/create', [\App\Http\Controllers\Admin\JabatanController::class, 'create'])->name('admin.jabatan.create');
    Route::post('/admin/jabatan', [\App\Http\Controllers\Admin\JabatanController::class, 'store'])->name('admin.jabatan.store');
    Route::get('/admin/jabatan/{jabatan}/edit', [\App\Http\Controllers\Admin\JabatanController::class, 'edit'])->name('admin.jabatan.edit');
    Route::put('/admin/jabatan/{jabatan}', [\App\Http\Controllers\Admin\JabatanController::class, 'update'])->name('admin.jabatan.update');
    Route::delete('/admin/jabatan/{jabatan}', [\App\Http\Controllers\Admin\JabatanController::class, 'destroy'])->name('admin.jabatan.destroy');

    Route::get('/admin/satuan', [\App\Http\Controllers\Admin\SatuanController::class, 'index'])->name('admin.satuan.index');
    Route::get('/admin/satuan/create', [\App\Http\Controllers\Admin\SatuanController::class, 'create'])->name('admin.satuan.create');
    Route::post('/admin/satuan', [\App\Http\Controllers\Admin\SatuanController::class, 'store'])->name('admin.satuan.store');
    Route::get('/admin/satuan/{satuan}/edit', [\App\Http\Controllers\Admin\SatuanController::class, 'edit'])->name('admin.satuan.edit');
    Route::put('/admin/satuan/{satuan}', [\App\Http\Controllers\Admin\SatuanController::class, 'update'])->name('admin.satuan.update');
    Route::delete('/admin/satuan/{satuan}', [\App\Http\Controllers\Admin\SatuanController::class, 'destroy'])->name('admin.satuan.destroy');

    Route::get('/admin/checklist-quality', [\App\Http\Controllers\Admin\ChecklistQualityItemController::class, 'index'])->name('admin.checklist-quality.index');
    Route::get('/admin/checklist-quality/create', [\App\Http\Controllers\Admin\ChecklistQualityItemController::class, 'create'])->name('admin.checklist-quality.create');
    Route::post('/admin/checklist-quality', [\App\Http\Controllers\Admin\ChecklistQualityItemController::class, 'store'])->name('admin.checklist-quality.store');
    Route::get('/admin/checklist-quality/{checklistQualityItem}/edit', [\App\Http\Controllers\Admin\ChecklistQualityItemController::class, 'edit'])->name('admin.checklist-quality.edit');
    Route::put('/admin/checklist-quality/{checklistQualityItem}', [\App\Http\Controllers\Admin\ChecklistQualityItemController::class, 'update'])->name('admin.checklist-quality.update');
    Route::delete('/admin/checklist-quality/{checklistQualityItem}', [\App\Http\Controllers\Admin\ChecklistQualityItemController::class, 'destroy'])->name('admin.checklist-quality.destroy');



    // Man Power Management
    Route::get('/admin/manpower', [\App\Http\Controllers\Admin\ManpowerController::class, 'index'])->name('admin.manpower.index');
    Route::get('/admin/manpower/create', [\App\Http\Controllers\Admin\ManpowerController::class, 'create'])->name('admin.manpower.create');
    Route::post('/admin/manpower', [\App\Http\Controllers\Admin\ManpowerController::class, 'store'])->name('admin.manpower.store');
    Route::get('/admin/manpower/{manpower}', [\App\Http\Controllers\Admin\ManpowerController::class, 'show'])->name('admin.manpower.show');
    Route::get('/admin/manpower/{manpower}/edit', [\App\Http\Controllers\Admin\ManpowerController::class, 'edit'])->name('admin.manpower.edit');
    Route::put('/admin/manpower/{manpower}', [\App\Http\Controllers\Admin\ManpowerController::class, 'update'])->name('admin.manpower.update');
    Route::delete('/admin/manpower/{manpower}/photo', [\App\Http\Controllers\Admin\ManpowerController::class, 'destroyPhoto'])->name('admin.manpower.photo.destroy');
    Route::delete('/admin/manpower/{manpower}', [\App\Http\Controllers\Admin\ManpowerController::class, 'destroy'])->name('admin.manpower.destroy');

    // Customer account management (admin)
    Route::get('/admin/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/admin/customers/create', [\App\Http\Controllers\Admin\CustomerController::class, 'create'])->name('admin.customers.create');
    Route::post('/admin/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'store'])->name('admin.customers.store');
    Route::get('/admin/customers/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('admin.customers.show');
    Route::get('/admin/customers/{customer}/edit', [\App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('admin.customers.edit');
    Route::put('/admin/customers/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('admin.customers.update');
    Route::delete('/admin/customers/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('admin.customers.destroy');

    // User account management (admin) - manage entries in `users` table (admin only)
    Route::middleware([\App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
        Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // Admin Notifications
    Route::get('/admin/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/admin/notifications/{notification}', [\App\Http\Controllers\Admin\NotificationController::class, 'show'])->name('admin.notifications.show');
    Route::post('/admin/notifications/{notification}/mark-as-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead');
    Route::post('/admin/notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead');
    Route::get('/admin/notifications/unread-count', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount'])->name('admin.notifications.unreadCount');

    // Performance Man Power
    Route::get('/admin/performance', [\App\Http\Controllers\Admin\PerformanceController::class, 'index'])->name('admin.performance.index');
    Route::get('/admin/performance/create', [\App\Http\Controllers\Admin\PerformanceController::class, 'create'])->name('admin.performance.create');
    Route::post('/admin/performance', [\App\Http\Controllers\Admin\PerformanceController::class, 'store'])->name('admin.performance.store');
    // Export Performance to PDF
    Route::get('/admin/performance/export-pdf', [\App\Http\Controllers\Admin\PerformanceController::class, 'exportPdfAll'])->name('admin.performance.exportPdfAll');
    Route::get('/admin/performance/{performance}', [\App\Http\Controllers\Admin\PerformanceController::class, 'show'])->name('admin.performance.show');
    Route::get('/admin/performance/{performance}/export-pdf', [\App\Http\Controllers\Admin\PerformanceController::class, 'exportPdf'])->name('admin.performance.exportPdf');
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

    // Management customer profile routes
    Route::get('/management-customer/profile', [\App\Http\Controllers\ManagementCustomer\ProfileController::class, 'edit'])->name('management-customer.profile.edit');
    Route::put('/management-customer/profile', [\App\Http\Controllers\ManagementCustomer\ProfileController::class, 'update'])->name('management-customer.profile.update');

    // Management EPP profile routes
    Route::get('/management-epp/profile', [\App\Http\Controllers\ManagementEpp\ProfileController::class, 'edit'])->name('management-epp.profile.edit');
    Route::put('/management-epp/profile', [\App\Http\Controllers\ManagementEpp\ProfileController::class, 'update'])->name('management-epp.profile.update');
});
