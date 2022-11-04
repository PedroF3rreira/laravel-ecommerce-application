<?php
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Http\Request;

Route::group(['prefix' => 'admin'], function(){
    Route::get('/login', [LoginController::class, 'showFormLogin'])->name('admin.login');
    Route::post('/login/do', [LoginController::class, 'login'])->name('admin.login.do');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::group([ 'middleware' => [ 'auth:admin' ]], function  ()  {

        Route::get( '/' , function(Request $request)  {

           return view( 'admin.dashboard.index', [
            'admin' => $request->user(),

        ]);
       })->name( 'admin.dashboard' );

        Route::get('/configuraçoes', [SettingController::class, 'index'])
            ->name('admin.settings');

        Route::post('/configuraçoes', [SettingController::class, 'update'])
            ->name('admin.settings.update');

        Route::resource('categorias', CategoryController::class)
            ->names('admin.categories')
        ->parameters(['categorias' => 'category']);

    });

});
