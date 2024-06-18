<?php
Route::group(['middleware' => 'can:is_admin'], function () {
    Route::get('/users', [UsersController::class, 'users'])->name('adminusers');
  });
