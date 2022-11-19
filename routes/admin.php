<?php
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
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
            ->except(['show'])
            ->names('admin.categories')
        ->parameters(['categorias' => 'category']);

        Route::resource('atributos', AttributeController::class)
            ->except(['show'])
            ->names('admin.attributes')
        ->parameters(['atributos' => 'attribute']);

        Route::group(['prefix' => 'atributos'], function(){
            Route::post('/get-values', [AttributeValueController::class, 'getValues']);
            Route::post('/add-values', [AttributeValueController::class, 'addValues']);
            Route::post('/update-values', [AttributeValueController::class, 'updateValues']);
            Route::post('/delete-values', [AttributeValueController::class, 'deleteValues']);
        });

    });

});
