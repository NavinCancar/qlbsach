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

//Location
Route::get('/dia-chi-giao-hang','App\Http\Controllers\CostumerController@all_location'); ///ok
Route::get('/them-dia-chi-giao-hang','App\Http\Controllers\CostumerController@add_location'); ///ok
Route::get('/sua-dia-chi-giao-hang/{DCGH_MA}', 'App\Http\Controllers\CostumerController@edit_location'); ///ok
Route::get('/xoa-dia-chi-giao-hang/{DCGH_MA}', 'App\Http\Controllers\CostumerController@delete_location'); ///ok

Route::post('/save-location', 'App\Http\Controllers\CostumerController@save_location'); ///ok
Route::post('/update-location/{DCGH_MA}', 'App\Http\Controllers\CostumerController@update_location'); ///ok

//Don dat hang
Route::get('/show-all-bill','App\Http\Controllers\CartController@show_all_bill'); ///ok
Route::get('/show-detail-bill/{DDH_MA}','App\Http\Controllers\CartController@show_detail_bill'); ///ok
Route::get('/show-detail-order','App\Http\Controllers\CartController@show_detail_order'); ///ok
Route::get('/huy-don/{DDH_MA}','App\Http\Controllers\CartController@cancel_order'); ///ok

Route::post('/order','App\Http\Controllers\CartController@order'); ///ok
Route::post('/search-in-order', 'App\Http\Controllers\CartController@search_in_order'); ///ok

//Account
Route::get('/tai-khoan', 'App\Http\Controllers\CostumerController@show_account'); ///ok
Route::get('/cap-nhat-tai-khoan', 'App\Http\Controllers\CostumerController@edit_account'); ///ok
Route::get('/doi-mat-khau', 'App\Http\Controllers\CostumerController@change_password_account'); ///ok

Route::post('/update-tai-khoan', 'App\Http\Controllers\CostumerController@update_account');///ok
Route::post('/update-mat-khau', 'App\Http\Controllers\CostumerController@update_password_account'); ///ok
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

//Author: Tác giả
Route::get('/add-author', 'App\Http\Controllers\AuthorController@add_author'); ///ok
Route::get('/edit-author/{TLS_MA}', 'App\Http\Controllers\AuthorController@edit_author'); ///ok
Route::get('/delete-author/{TLS_MA}', 'App\Http\Controllers\AuthorController@delete_author'); ///ok
Route::get('/all-author', 'App\Http\Controllers\AuthorController@all_author'); ///ok

Route::post('/save-author', 'App\Http\Controllers\AuthorController@save_author'); ///ok
Route::post('/update-author/{TLS_MA}', 'App\Http\Controllers\AuthorController@update_author'); ///ok


//chức vụ
Route::get('/add-chuc-vu', 'App\Http\Controllers\Chucvu@add_chuc_vu'); ///ok
Route::get('/edit-chuc-vu/{CV_MA}', 'App\Http\Controllers\Chucvu@edit_chuc_vu'); ///ok
Route::get('/delete-chuc-vu/{CV_MA}', 'App\Http\Controllers\Chucvu@delete_chuc_vu'); ///ok
Route::get('/all-chuc-vu', 'App\Http\Controllers\Chucvu@all_chuc_vu'); ///ok

Route::post('/save-chuc-vu', 'App\Http\Controllers\Chucvu@save_chuc_vu'); ///ok
Route::post('/update-chuc-vu/{CV_MA}', 'App\Http\Controllers\Chucvu@update_chuc_vu'); ///ok

//lô nhập
Route::get('/add-lo-nhap', 'App\Http\Controllers\Lonhap@add_lo_nhap'); ///ok
Route::get('/edit-lo-nhap/{LN_MA}', 'App\Http\Controllers\Lonhap@edit_lo_nhap'); ///ok
Route::get('/delete-lo-nhap/{LN_MA}', 'App\Http\Controllers\Lonhap@delete_lo_nhap'); ///ok
Route::get('/all-lo-nhap', 'App\Http\Controllers\Lonhap@all_lo_nhap'); ///ok

Route::post('/save-lo-nhap', 'App\Http\Controllers\Lonhap@save_lo_nhap'); ///ok
Route::post('/update-lo-nhap/{LN_MA}', 'App\Http\Controllers\Lonhap@update_lo_nhap'); ///ok

//lô nhập
Route::get('/add-lo-xuat', 'App\Http\Controllers\Loxuat@add_lo_xuat'); ///ok
Route::get('/edit-lo-xuat/{LX_MA}', 'App\Http\Controllers\Loxuat@edit_lo_xuat'); ///ok
Route::get('/delete-lo-xuat/{LX_MA}', 'App\Http\Controllers\Loxuat@delete_lo_xuat'); ///ok
Route::get('/all-lo-xuat', 'App\Http\Controllers\Loxuat@all_lo_xuat'); ///ok

Route::post('/save-lo-xuat', 'App\Http\Controllers\Loxuat@save_lo_xuat'); ///ok
Route::post('/update-lo-xuat/{LX_MA}', 'App\Http\Controllers\Loxuat@update_lo_xuat'); ///ok




//đánh giá
Route::get('/danh-gia', 'App\Http\Controllers\AdminController@danh_gia');
Route::get('/delete-danh-gia/{DG_MA}', 'App\Http\Controllers\AdminController@delete_danh_gia'); 

//khách hàng
Route::get('/khach-hang', 'App\Http\Controllers\AdminController@khach_hang');
