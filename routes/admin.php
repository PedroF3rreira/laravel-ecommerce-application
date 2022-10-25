<?php
use App\Http\Controllers\Admin\LoginController;

Route::group(['prefix' => 'admin'], function(){
    Route::get('/login', [LoginController::class, 'showFormLogin'])->name('admin.login');
    Route::post('/login/do', [LoginController::class, 'login'])->name('admin.login.do');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

Route::group([ 'middleware' => [ 'auth:admin' ]], function  ()  {

    Route::get( '/admin' , function  ()  {
         return view( 'admin.dashboard.index' );
    } )->name( 'admin.dashboard' );

});
