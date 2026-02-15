<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AjaxController;
use Auth;
use Illuminate\Support\Facades\Route;

#001f8e
#0716AD
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

Route::get('/', function () {
    return view('auth.login');
})->name("welcome");

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'prefix'     => 'portal/admin',
    'middleware' => ['webauthenticated', 'g2fa'],

], function ($router) {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/change-password', [AdminController::class, 'changePassword'])->name("admin.changePassword");

    Route::post('/update-password', [AdminController::class, 'updatePassword'])->name("admin.updatePassword");

    Route::get('/view-profile', [AdminController::class, 'viewProfile'])->name("admin.viewProfile");

    Route::post('/update-profile', [AdminController::class, 'updateProfile'])->name("admin.updateProfile");

    Route::get('/security', [AdminController::class, 'security'])->name("admin.security");

    Route::post('/select2FA', [AdminController::class, 'select2FA'])->name("admin.select2FA");

    Route::post('/enableGA', [AdminController::class, 'enableGA'])->name("admin.enableGA");

    Route::get('/user-roles', [AdminController::class, 'userRoles'])->name("admin.userRoles");

    Route::post('/storeUserRole', [AdminController::class, 'storeUserRole'])->name("admin.storeUserRole");

    Route::post('/updateUserRole', [AdminController::class, 'updateUserRole'])->name("admin.updateUserRole");

    Route::get('/roles/permissions/{id}', [AdminController::class, 'managePermissions'])->name("admin.managePermissions");

    Route::get('/agent-management', [AdminController::class, 'agentManagement'])->name("admin.agentManagement");

    Route::post('/storeUser', [AdminController::class, 'storeUser'])->name('admin.storeUser');

    Route::post('/updateUser', [AdminController::class, 'updateUser'])->name('admin.updateUser');

    Route::get('/suspend-user/{id}', [AdminController::class, 'suspendUser'])->name('admin.suspendUser');

    Route::get('/activate-user/{id}', [AdminController::class, 'activateUser'])->name('admin.activateUser');

    Route::get('/platform-features', [AdminController::class, 'platformFeatures'])->name("admin.platformFeatures");

    Route::get('/grant-feature-permission/{role}/{feature}', [AdminController::class, 'grantFeaturePermission'])->name('admin.grantFeaturePermission');

    Route::get('/revoke-feature-permission/{role}/{feature}', [AdminController::class, 'revokeFeaturePermission'])->name('admin.revokeFeaturePermission');

    Route::get('/grant-create-permission/{role}/{feature}', [AdminController::class, 'grantCreatePermission'])->name('admin.grantCreatePermission');

    Route::get('/revoke-create-permission/{role}/{feature}', [AdminController::class, 'revokeCreatePermission'])->name('admin.revokeCreatePermission');

    Route::get('/grant-edit-permission/{role}/{feature}', [AdminController::class, 'grantEditPermission'])->name('admin.grantEditPermission');

    Route::get('/revoke-edit-permission/{role}/{feature}', [AdminController::class, 'revokeEditPermission'])->name('admin.revokeEditPermission');

    Route::get('/grant-delete-permission/{role}/{feature}', [AdminController::class, 'grantDeletePermission'])->name('admin.grantDeletePermission');

    Route::get('/revoke-delete-permission/{role}/{feature}', [AdminController::class, 'revokeDeletePermission'])->name('admin.revokeDeletePermission');

    Route::get('/member-management', [AdminController::class, 'memberManagement'])->name("admin.memberManagement");

    Route::get('/member-savings/{id}', [AdminController::class, 'memberSavings'])->name("admin.memberSavings");

    Route::get('/member-Loans/{id}', [AdminController::class, 'memberLoans'])->name("admin.memberLoans");

    Route::post('/storeMember', [AdminController::class, 'storeMember'])->name('admin.storeMember');

    Route::post('/updateMember', [AdminController::class, 'updateMember'])->name('admin.updateMember');

    Route::get('/savings-records', [AdminController::class, 'savingsRecords'])->name("admin.savingsRecords");

    Route::post('/storeMemberSavings', [AdminController::class, 'storeMemberSavings'])->name('admin.storeMemberSavings');

    Route::get('/loan-applications', [AdminController::class, 'loanApplications'])->name("admin.loanApplications");

    Route::get('/loan-records', [AdminController::class, 'loanRecords'])->name("admin.loanRecords");

    Route::get('/new-loan', [AdminController::class, 'newLoan'])->name("admin.newLoan");

    Route::post('/storeLoanApplication', [AdminController::class, 'storeLoanApplication'])->name('admin.storeLoanApplication');

    Route::get('/administrative-reports', [AdminController::class, 'adminReports'])->name("admin.reports");

});

Route::group([
    'prefix' => 'ajax',
], function ($router) {
    Route::get('/getMemberName/{cardno}', [AjaxController::class, 'getMemberName'])->name('ajax.memberName');

    Route::get('/getGuarantorName/{cardno}', [AjaxController::class, 'getGuarantorName'])->name('ajax.guarantorName');
});
