<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homecontroller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\TwoFactorAuthController;
Route::get('/', function () {
    return view('auth.login');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [homecontroller::class, 'destroy'])->name('profile.destroy');
});
Route::post('/enable-2fa', function (Request $request) {
    $user = $request->user();
    $user->two_factor_enabled = true;
    $user->save();
    return back()->with('message', 'Two-factor authentication enabled.');
})->middleware('auth');


// Admin Routes

require __DIR__.'/auth.php';
Route::get('/admin/dashboard', [homecontroller::class, 'adminDash'])->name('admin.dashboard');
Route::get('/Coodinator/dashboard', [homecontroller::class, 'editorDash'])->name('editor.dashboard');
Route::get('/admin/addDep', [AdminController::class, 'addDep'])->name('admin.addDep');
Route::post('/admin/addDepartment', [AdminController::class, 'storeDepartment'])->name('admin.storeDep');
Route::get('admin/editDepartment/{id}', [adminController::class, 'editCatogary'])->name('admin.editCatogary');
Route::post('admin/updateDepartment/{id}', [adminController::class, 'updateCatogary'])->name('admin.updateCatogary');
Route::get('admin/deleteDepartment/{id}', [adminController::class, 'deleteCategory'])
    ->name('admin.destroyCatogary');
Route::get('admin/viewuser', [adminController::class, 'userView'])->name('admin.viewUser');
Route::get('admin/addUser', [ProfileController::class, 'addUser'])->name('admin.addUser');

Route::post('/abc', [ProfileController::class, 'abc']);

Route::post('/registerUser', [RegisteredUserController::class, 'store']);
Route::get('/admin/assignTask', [AdminController::class, 'assignTask'])->name('admin.assignTask');
Route::get('admin/deleteUser/{id}',[AdminController::class, 'deleteUser'])->name('admin.deleteUser');
Route::get('/users-by-department', [AdminController::class, 'getUsersByDepartment'])->name('users.by.department');
Route::get('/get-all-users', [AdminController::class, 'getAllUsers'])->name('get.all.users');
Route::get('/user/details', [AdminController::class, 'getUserDetails'])->name('user.details');
Route::get('/admin/view/{id}', [AdminController::class, 'adminView'])->name('admin.view');
Route::post('admin/TaskStore', [AdminController::class, 'taskStore'])->name('task.store');
Route::get('admin/showUserActivity', [AdminController::class, 'Activity'])->name('admin.showUserActivity');
Route::get('admin/getUser/{id}', [AdminController::class, 'userActivity'])->name('admin.getUser');
Route::get('admin/editUser/{id}', [AdminController::class, 'userEdit'])->name('admin.editUser');
Route::post('admin/updateUser/{id}', [AdminController::class, 'userEditFunc'])->name('admin.updateUser');
Route::get('admin/deleteTask/{id}', [AdminController::class, 'taskDelete'])->name('admin.deleteTask');
Route::get('admin/taskUpdateView/{id}', [AdminController::class, 'updateTaskview'])->name('admin.taskUpdate');
Route::post('admin/taskUpdate/{id}', [AdminController::class, 'UpdateTask'])->name('admin.taskUpdateSAVE');
Route::post('admin/secondTask', [AdminController::class, 'secondTask'])->name('admin.secondTask');
Route::post('admin/extratime/{id}',[AdminController::class,'extraTime'])->name('admin.extratime');
Route::post('admin/extratime2/{id}',[AdminController::class,'extraTime2'])->name('admin.extratime2');
Route::post('/tasks/store', [AdminController::class, 'oneTaskstore'])->name('general.store');

// Coodinator Routes
Route::put('/Coodinatortask/{task}/update-status', [CoordinatorController::class, 'updateStatus'])->name('task.update.status');
Route::get('user/login',[UserController::class,'userView'])->name('dashboard');
Route::get('Coodinator/jobAssign', [CoordinatorController::class, 'CoodinatorJob'])->name('coordinator.jobAssign');
Route::put('user/{task}/update-status',[UserController::class,'AddTask'])->name('userTask');
Route::get('Coodinator/CoodinatorView/{id}', [CoordinatorController::class, 'CoordinatorView'])->name('coordinator.view');
Route::post('Coodinator/TaskStore', [CoordinatorController::class, 'CoodinatorAsignTask'])->name('Coodinator.task.store');
Route::get('Coodinator/DeleteTask/{id}', [CoordinatorController::class, 'CoodinatortaskDelete'])->name('Coodinator.task.delete');
Route::get('Coodinator/ViewUpdate/{id}', [CoordinatorController::class, 'updateTaskview'])->name('coordinator.view.update');
Route::post('Coodinator/taskUpdate/{id}', [CoordinatorController::class, 'UpdateTask'])->name('Coodinator.taskUpdateSAVE');

Route::get('/tasks/refresh', [TaskController::class, 'refreshTasks'])->name('tasks.refresh');
Route::get('pendingTask', [TaskController::class, 'pendingTask'])->name('pendingTask');
// routes/web.php
Route::get('/tasks/notifications', [TaskController::class, 'fetchNotifications']);
Route::get('pendingTaskCoodinator', [TaskController::class, 'CoodinatorPendingTask'])->name('pendingTask.coordinator');

// ALL USER ACess codes 
Route::get('/tasks', [TaskController::class, 'headerActivity'])->name('tasks.index');
Route::get('admin/dashboard', [TaskController::class, 'MainDashBoard'])->name('adminView.Dashboard');
Route::get('coodinator/dashboard', [TaskController::class, 'CoordinatorDashBoard'])->name('Coordinator.DashBoard');
Route::get('user/dashboard',[TaskController::class,'userDashboard'])->name('user.dashboard');
Route::get('admin/tasks/filter', [TaskController::class, 'filterTasks'])->name('filter.tasks');
Route::get('/tasks/filter', [TaskController::class, 'filterCoordinatorTasks'])->name('coordinator.filter.tasks');


// User Routes
Route::post('user/reason/{task}',[UserController::class,'userReason'])->name('user.reason');
Route::post('user/profile_pic/{id}',[UserController::class,'user_profile'])->name('upload.image');
Route::get('user/done', [UserController::class, 'doneView'])->name('done');
Route::get('user/update/{id}',[UserController::class, 'userUpdate'])->name('selfUpdate');
// Reset Password
Route::get('/expire-mail', [PasswordResetLinkController::class, 'emailRsetBlade'])
    ->name('expire-mail-password');
Route::post('user/updateUser/{id}',[UserController::class, 'userEditFunc'])->name('by.user');

Route::post('/update_password', [PasswordResetLinkController::class, 'passwordUpdate'])->name('password.update');
Route::get('/2fa-verify', [TwoFactorAuthController::class, 'showVerifyForm'])->name('2fa.verify');
Route::post('/2fa-verify', [TwoFactorAuthController::class, 'verify']);