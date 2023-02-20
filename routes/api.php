<?php
use App\Http\Controllers\Api\V1\Admin\RolesApiController;
use App\Http\Controllers\Api\V1\UsersApiController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Admin\UsersController;
Route::get('home', [HomeController::class,'index']);


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1'], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    Route::get('fetch', [UsersApiController::class,'fetchUser'])->name('fetch.user');
    Route::delete('delete/{id}', [UsersApiController::class,'deleteUser'])->name('user.delete');
    Route::get('show/{id}', [UsersApiController::class,'showUser'])->name('user.showUser');
    Route::get('edit/{id}', [UsersApiController::class,'editUser'])->name('user.editUser');
    Route::put('update/{id}', [UsersApiController::class,'updateUser'])->name('user.updateUser');
   
    

});
