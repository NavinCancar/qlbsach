<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*-----------------------------------*\
  #FRONTEND
\*-----------------------------------*/
Route::get('/','App\Http\Controllers\HomeController@index'); ///ok
Route::get('/trang-chu', 'App\Http\Controllers\HomeController@index'); ///ok
Route::get('/danh-muc-san-pham/tat-ca', 'App\Http\Controllers\HomeController@all_product'); ///ok
Route::post('/tim-kiem', 'App\Http\Controllers\HomeController@search'); ///ok

//Home Product Categories
Route::get('/danh-muc-san-pham/{TLS_MA}', 'App\Http\Controllers\CategoryProduct@show_category_home'); ///ok
Route::get('/chi-tiet-san-pham/{SACH_MA}', 'App\Http\Controllers\ProductController@detail_product'); ///ok

Route::post('/danh-gia/{SACH_MA}', 'App\Http\Controllers\ProductController@danh_gia'); ///ok

//Login
Route::get('/dang-nhap','App\Http\Controllers\CostumerController@dang_nhap'); ///ok
Route::get('/dang-xuat', 'App\Http\Controllers\CostumerController@logout'); ///ok
Route::post('/costumer-check', 'App\Http\Controllers\CostumerController@trang_chu'); ///ok

//Sign up
Route::post('/dang-ky', 'App\Http\Controllers\CostumerController@signup'); ///ok

//Cart
Route::post('/save-cart','App\Http\Controllers\CartController@save_cart'); ///ok
Route::get('/show-cart','App\Http\Controllers\CartController@show_cart'); ///ok
Route::post('/update-cart', 'App\Http\Controllers\CartController@update_cart'); ///ok
Route::get('/delete-cart/{SACH_MA}', 'App\Http\Controllers\CartController@delete_cart'); ///ok

//---------------------------------------------------



/*-----------------------------------*\
  #BACKEND
\*-----------------------------------*/

Route::get('/admin', 'App\Http\Controllers\AdminController@index'); ///ok
Route::get('/dashboard', 'App\Http\Controllers\AdminController@show_dashboard'); ///ok
Route::get('/logout', 'App\Http\Controllers\AdminController@logout'); ///ok
Route::post('/admin-dashboard', 'App\Http\Controllers\AdminController@dashboard'); ///ok

//Category Product: Thể loại sách
Route::get('/add-category-product', 'App\Http\Controllers\CategoryProduct@add_category_product'); ///ok
Route::get('/edit-category-product/{TLS_MA}', 'App\Http\Controllers\CategoryProduct@edit_category_product'); ///ok
Route::get('/delete-category-product/{TLS_MA}', 'App\Http\Controllers\CategoryProduct@delete_category_product'); ///ok
Route::get('/all-category-product', 'App\Http\Controllers\CategoryProduct@all_category_product'); ///ok

Route::post('/save-category-product', 'App\Http\Controllers\CategoryProduct@save_category_product'); ///ok
Route::post('/update-category-product/{TLS_MA}', 'App\Http\Controllers\CategoryProduct@update_category_product'); ///ok