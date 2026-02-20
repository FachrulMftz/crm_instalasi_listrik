    <?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Auth\RegisterController;
    use App\Http\Controllers\Admin\UserController;
    use App\Http\Controllers\InstallationController;
    use App\Http\Controllers\OpportunityController;
    use App\Http\Controllers\ActivityController;
    use App\Http\Controllers\CustomerController;
    use App\Http\Controllers\KaryawanController;
    use App\Http\Controllers\Teknisi\ReportController;
    use App\Http\Controllers\Teknisi\DashboardController as TeknisiDashboardController;
    use App\Http\Controllers\SalesDashboardController;

    /*
    |--------------------------------------------------------------------------
    | GUEST (BELUM LOGIN)
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])
            ->name('login');

        Route::post('/login', [LoginController::class, 'login']);

        Route::get('/register', [RegisterController::class, 'show'])
            ->name('register');

        Route::post('/register', [RegisterController::class, 'store']);
    });

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [LoginController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    /*
    |--------------------------------------------------------------------------
    | ROOT
    |--------------------------------------------------------------------------
    */
    Route::get('/', function () {
        return auth()->check()
            ? redirect()->route('dashboard.redirect')
            : redirect()->route('login');
    });

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD REDIRECT BY ROLE
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'sales'      => redirect()->route('sales.dashboard'),
            'teknisi'    => redirect()->route('teknisi.dashboard'),
            default      => abort(403),
        };
    })->name('dashboard.redirect');

    /*
    |--------------------------------------------------------------------------
    | SUPERADMIN AREA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:superadmin'])
        ->prefix('superadmin')
        ->name('superadmin.')
        ->group(function () {
            Route::get('/dashboard', fn () => view('dashboard.superadmin'))
                ->name('dashboard');
        });

    /*
    |--------------------------------------------------------------------------
    | ADMIN AREA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:admin,superadmin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', fn () => view('dashboard.admin'))
                ->name('dashboard');

            Route::resource('users', UserController::class);
        });

    /*
   /*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/
// SEMUA ROLE - VIEW
Route::middleware(['auth', 'role:admin,sales'])->group(function () {
    Route::get('/karyawan', [KaryawanController::class, 'index'])
        ->name('karyawan.index');

    Route::get('/karyawan/{user}', [KaryawanController::class, 'show'])
        ->name('karyawan.show');

// ADMIN ONLY - CRUD
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])
        ->name('karyawan.create');

    Route::post('/karyawan', [KaryawanController::class, 'store'])
        ->name('karyawan.store');

    Route::get('/karyawan/{user}/edit', [KaryawanController::class, 'edit'])
        ->name('karyawan.edit');

    Route::put('/karyawan/{user}', [KaryawanController::class, 'update'])
        ->name('karyawan.update');

    Route::delete('/karyawan/{user}', [KaryawanController::class, 'destroy'])
        ->name('karyawan.destroy');
});
    
    /*
    |--------------------------------------------------------------------------
    | SALES AREA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:sales'])
    ->prefix('sales')
    ->name('sales.')
    ->group(function () {
        Route::get('/dashboard', [SalesDashboardController::class, 'index'])
            ->name('dashboard');
    });
    /*
    |--------------------------------------------------------------------------
    | TEKNISI AREA
    |--------------------------------------------------------------------------
    */
Route::middleware(['auth', 'role:teknisi,admin,sales'])
    ->prefix('teknisi')
    ->name('teknisi.')
    ->group(function () {
        
        Route::get('/dashboard', [TeknisiDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/report', [InstallationController::class, 'reportIndex'])
            ->name('report');

        Route::get('/report/create/{installation}',
            [ReportController::class, 'create']
        )->name('report.create');
        /*
        |=================================================
        | DELETE FOTO 
        |=================================================
        */
        Route::delete('/report/photo/{installation}',
            [ReportController::class, 'deletePhoto']
        )->name('report.photo.delete');

        /*
        |=================================================
        | STORE / UPDATE LAPORAN
        |=================================================
        */
        Route::post('/report/store/{installation}',
            [ReportController::class, 'store']
        )->name('report.store');

    });

    /*
    |--------------------------------------------------------------------------
    | INSTALLATION (READ ONLY)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:teknisi,admin,sales'])
        ->prefix('installation')
        ->name('installation.')
        ->group(function () {

            Route::get('/', [InstallationController::class, 'myInstallations'])
                ->name('index');

            // ROUTE LAMA (TETAP ADA)
            Route::get('/my', [InstallationController::class, 'myInstallations'])
                ->name('my');

            Route::get('/{installation}', [InstallationController::class, 'show'])
                ->name('show');
        });

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER (SALES, ADMIN, SUPERADMIN)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:sales,admin,superadmin'])
        ->prefix('customer')
        ->name('customer.')
        ->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/create', [CustomerController::class, 'create'])->name('create');
            Route::post('/', [CustomerController::class, 'store'])->name('store');
            Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
            Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
            Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
            Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | OPPORTUNITIES (SALES, ADMIN, SUPERADMIN)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:sales,admin,superadmin'])
        ->prefix('opportunities')
        ->name('opportunities.')
        ->group(function () {
            Route::resource('/', OpportunityController::class)
                ->parameters(['' => 'opportunity']);
        });

    /*
    |--------------------------------------------------------------------------
    | ACTIVITY (SALES, ADMIN, SUPERADMIN)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:sales,admin,superadmin'])
        ->prefix('activity')
        ->name('activity.')
        ->group(function () {
            Route::get('/', [ActivityController::class, 'index'])->name('index');
            Route::get('/create', [ActivityController::class, 'create'])->name('create');
            Route::post('/', [ActivityController::class, 'store'])->name('store');
            Route::get('/{activity}/edit', [ActivityController::class, 'edit'])->name('edit');
            Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');
            Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
            Route::get('/{activity}', function ($id) {
            return redirect()->route('activity.index', $id);
        });
        });
    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');
    });

    //php -S 127.0.0.1:8000 -t public