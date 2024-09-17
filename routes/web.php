<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManagesController;
use App\Http\Controllers\Admin\Mange\ManageResinAppController;
use App\Http\Controllers\Admin\Mange\SchedulePlanController;
use App\Http\Controllers\Admin\Mange\UserController;
use App\Http\Controllers\Auth\line\LineLoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinesController;
use App\Http\Controllers\MachinesController;
use App\Http\Controllers\NewVersion\ApproveController;
use App\Http\Controllers\NewVersion\ResinController;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\ResinsController;
use App\Http\Controllers\ScheduleCheck\LineApproveController;
use Illuminate\Support\Facades\Route;


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

Auth::routes();

Route::get('/', [HomeController::class, 'index']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin/home', [HomeController::class, 'index'])->name('admin.home')->middleware('is_admin');
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // ===== Resin App =====
    Route::prefix('/department/{department}/{app}')->group(function () {
        Route::get('/', [HomeController::class, 'appSelect'])->name('new.appSelect');
        Route::get('/{schedule}', [ResinController::class, 'line_select'])->name('new.app.resin.line');
        Route::get('/{schedule}/{line}', [ResinController::class, 'machine'])->name('new.app.resin.machine');
        Route::get('/{schedule}/{line}/{machine_id}', [ResinController::class, 'resin'])->name('new.app.resin.schedule.resin');
        Route::post('/{schedule}/{schedulePlan}/{resin_id}', [ResinController::class, 'scheduleRecord'])->name('new.app.resin.schedule.scheduleRecord');


        Route::post('/notUse/{schedule}/{line}/LineUsage', [ResinController::class, 'toggleLineUsage'])->name('toggleLineUsage');
        Route::post('/notUse/{schedule}/{line}/{machine}/MachineUsage', [ResinController::class, 'toggleMachineUsage'])->name('toggleMachineUsage');
    });

    // ===== Admin =====
    Route::prefix('/admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin')->middleware('is_admin');
        Route::get('/{department}', [AdminController::class, 'department'])->name('admin.department');

        Route::prefix('/manage/{department}')->group(function () {

            Route::get('/users', [ManagesController::class, 'users'])->name('admin.department.manage.users');
            Route::post('/user', [UserController::class, 'add_user'])->name('admin.department.manage.addUsers');
            Route::put('/user/{user}', [UserController::class, 'edit_user'])->name('admin.department.manage.editUsers');
            Route::delete('/user/{user}', [UserController::class, 'destroy_user'])->name('admin.department.manage.deleteUser');

            Route::get('/resinApp', [ManagesController::class, 'resinApp'])->name('admin.department.manage.resinApp');
            Route::get('/resinApp/line/', [ManageResinAppController::class, 'line'])->name('admin.department.manage.resinApp.line');
            Route::get('/resinApp/line/{line}/machine/', [ManageResinAppController::class, 'machine'])->name('admin.department.manage.resinApp.machine');
            Route::get('/resinApp/line/{line}/machine/{machine}/resin', [ManageResinAppController::class, 'resin'])->name('admin.department.manage.resinApp.resin');

            Route::get('/schedulePlan', [ManagesController::class, 'schedulePlan'])->name('admin.department.manage.schedulePlan');
            Route::get('/schedulePlan/{line}/machine', [SchedulePlanController::class, 'machine'])->name('admin.department.manage.schedulePlan.machine');
            Route::post('/schedulePlan/{line}/machine/{machine}/schedule_plan', [SchedulePlanController::class, 'schedule_plan'])->name('admin.department.manage.schedulePlan.machine.schedule_plan');


            Route::prefix('/reports')->group(function () {
                Route::get('/', [ReportsController::class, 'index'])->name('admin.department.reports');
                Route::get('/{typeDoc}/view', [ReportsController::class, 'view'])->name('admin.department.reports.view');
                Route::get('/exportExcel/{startDate}/{endDate}', [ReportsController::class, 'exportExcel'])->name('admin.department.reports.exportExcel');
                Route::get('/sendReportEmail/{startDate}/{endDate}', [ReportsController::class, 'sendReportEmail'])->name('admin.department.reports.sendReportEmail');
            });


            Route::prefix('/dashboard')->group(function () {});
            Route::get('/', [DashboardController::class, 'index'])->name('admin.department.dashboard');
        });
    });


    // ===== Department =====
    Route::resource('department', DepartmentsController::class);

    // ===== line =====
    Route::resource('department/{department}/line', LinesController::class);

    // ===== Machine =====
    Route::resource('department/{department}/line/{line}/machines', MachinesController::class);

    // ===== Resin =====
    Route::resource('department/{department}/line/{line}/machine/{machine}/resins', ResinsController::class);
});

// Line Login
// Route::get('approve/line', [LineLoginController::class, 'redirectToProvider'])->name('line.callback');
// Route::get('approve/line/callback', [LineLoginController::class, 'handleProviderCallback'])->name('line.callback');


Route::get('approve/line/scheduleRecord/{scheduleRecord_id}', [LineApproveController::class, 'redirectToProvider']);
Route::get('approve/line/callback', [LineApproveController::class, 'handleProviderCallback']);
Route::get('approve/line/approveSchedule/{scheduleRecord_id}', [LineApproveController::class, 'approveSchedule'])->name('approve.schedule');
Route::post('approve/line/approveSchedule/store/{line_user}/{scheduleRecord_id}', [LineApproveController::class, 'approveStore'])->name('approve.store');

Route::get('/exportExcelDownload/{department}/{startDate}/{endDate}', [ReportsController::class, 'exportExcel'])->name('admin.department.reports.exportExcel.download');
