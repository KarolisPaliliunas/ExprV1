<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpertSystemProjectController;
use App\Http\Controllers\ExpertSystemAttributeController;
use App\Http\Controllers\ExpertSystemValueController;
use App\Http\Controllers\ExpertSystemConclusionController;
use App\Http\Controllers\UserGroupController;
use Illuminate\Http\Client\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Project
Route::middleware(['auth', 'verified'])->group(function ($project_id = null) { // applies to all route groups
    Route::get('/projects', [ExpertSystemProjectController::class, 'index'])->name('project.list');
    Route::post('/projects', [ExpertSystemProjectController::class, 'index'])->name('project.listFiltered');
    Route::get('/projects-create', [ExpertSystemProjectController::class, 'create'])->name('project.create');
    Route::get('/projects-edit/{project_id}', [ExpertSystemProjectController::class, 'edit'])->name('project.edit');
    Route::get('/projects-es-editor/{project_id}', [ExpertSystemProjectController::class, 'buildExpertSystemTree'])->name('project.generateTreeEditor');
    Route::post('/projects-new', [ExpertSystemProjectController::class, 'store'])->name('project.new');
    Route::post('/projects-update/{project_id}', [ExpertSystemProjectController::class, 'update'])->name('project.update');
    Route::post('/projects-delete/{project_id}', [ExpertSystemProjectController::class, 'destroy'])->name('project.delete');
    
    //excecution
    Route::get('/projects-execute/{project_id}/current-attr/{currentAttributeId}/picked-val/{pickedValueId}', [ExpertSystemProjectController::class, 'execute'])->name('project.execute');
    Route::get('/projects-execute/{project_id}', [ExpertSystemProjectController::class, 'execute'])->name('project.executeNoData');
});

//Attribute
Route::middleware(['auth', 'verified'])->group(function ($item_id=null, $createForProject = false) {
    Route::post('/attribute-create/{item_id}/project/{project_id}/create/{createForProject?}', [ExpertSystemAttributeController::class, 'store'])->name('attribute.new');
    Route::post('/attribute-update/{item_id}/project/{project_id}', [ExpertSystemAttributeController::class, 'update'])->name('attribute.update');
    Route::post('/attribute-delete/{item_id}/project/{project_id}', [ExpertSystemAttributeController::class, 'destroy'])->name('attribute.delete');
});

//Value
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/value-create/{item_id}/project/{project_id}', [ExpertSystemValueController::class, 'store'])->name('value.new');
    Route::post('/value-update/{item_id}/project/{project_id}', [ExpertSystemValueController::class, 'update'])->name('value.update');
    Route::post('/value-delete/{item_id}/project/{project_id}', [ExpertSystemValueController::class, 'destroy'])->name('value.delete');
});

//Conclusion
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/conclusion-create/{item_id}/project/{project_id}', [ExpertSystemConclusionController::class, 'store'])->name('conclusion.new');
    Route::post('/conclusion-update/{item_id}/project/{project_id}', [ExpertSystemConclusionController::class, 'update'])->name('conclusion.update');
    Route::post('/conclusion-delete/{item_id}/project/{project_id}', [ExpertSystemConclusionController::class, 'destroy'])->name('conclusion.delete');
});

//Group
Route::middleware(['auth', 'verified'])->group(function ($project_id = null) {
    Route::get('/user-group', [UserGroupController::class, 'show'])->name('ugroups.list');
    Route::get('/user-group-create', [UserGroupController::class, 'create'])->name('ugroups.create');
    Route::get('/user-group-edit/{user_group_id}', [UserGroupController::class, 'edit'])->name('ugroups.edit');
    Route::get('/user-group/{user_group_id}/user-list', [UserGroupController::class, 'userList'])->name('ugroups.userList');
    Route::post('/user-group-new', [UserGroupController::class, 'store'])->name('ugroups.new');
    Route::post('/user-group-update/{user_group_id}', [UserGroupController::class, 'update'])->name('ugroups.update');
    Route::post('/user-group-delete/{user_group_id}', [UserGroupController::class, 'destroy'])->name('ugroups.delete');
    Route::post('/user-group-join/create-link', [UserGroupController::class, 'joinGroup'])->name('ugroups.joinGroup');
    Route::get('/user-group-join', [UserGroupController::class, 'joinGroupView'])->name('ugroups.joinGroupView');
    Route::post('/user-group/{user_group_id}/remove-user/{user_id}', [UserGroupController::class, 'removeUserFromGroup'])->name('ugroups.removeUser');
});

//Auth routes (include)
require __DIR__.'/auth.php';
