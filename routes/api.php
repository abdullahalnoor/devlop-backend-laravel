<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test',function(){
    return response()->json([
        'user' =>[
            'first_name' => 'Abdullah',
            'last_name' => 'Al Noor',
        ]
    ]);
});

Route::group(['middleware'=>'auth:api'],function(){
   

Route::resource('/product','ProductController');
Route::get('/product/detail/{id}','ProductController@detail');
Route::resource('/category','CategoryController');
Route::get('/published/category','CategoryController@publishedCategory');
});