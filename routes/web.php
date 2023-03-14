<?php

use App\Http\Controllers\Home\PublicController;
use App\Http\Controllers\IndexController;
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
/*前台*/

//Route::get ('/', function () {
//    return view ('welcome');
//});

Route::get('/', [IndexController::class,'nav']);
Route::get('/url/{id}', [IndexController::class,'url']);
Route::get('/seeder', [IndexController::class,'seeder']);

Route::namespace ('Home')->middleware ('home')->group (function () {
    //Route::get ('/', 'IndexController@index');
    Route::post ('/view_browsing', [PublicController::class, 'webViewBrowsing']);
});
