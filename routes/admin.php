<?php
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Http\Request;

Route::group(['prefix' => 'admin'], function(){
    Route::get('/login', [LoginController::class, 'showFormLogin'])->name('admin.login');
    Route::post('/login/do', [LoginController::class, 'login'])->name('admin.login.do');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

Route::group([ 'middleware' => [ 'auth:admin' ]], function  ()  {

    Route::get( '/admin' , function(Request $request)  {
         return view( 'admin.dashboard.index', [
            'admin' => $request->user(),
         ]);
    } )->name( 'admin.dashboard' );

});
