<?php
use App\Core\Route;

// Root = home
Route::get('/home', 'HomeController@index');

// Auth
Route::get('/auth/login', 'AuthController@login');
Route::post('/auth/login', 'AuthController@login');
Route::get('/auth/logout', 'AuthController@logout');

// Register
Route::get('/register/store', 'RegisterController@store');
Route::post('/register/store', 'RegisterController@store');

// Products
Route::get('/product/index', 'ProductController@index');
Route::get('/product/detail/{id}', 'ProductController@detail');

// Admin Giriş / Çıkış

Route::get('/admin/login', 'AdminAuthController@login');    // Login formu
Route::post('/admin/login', 'AdminAuthController@login');   // Form POST
Route::get('/admin/logout', 'AdminAuthController@logout');  // Çıkış

// Admin Paneli
Route::get('/admin/dashboard', 'AdminController@dashboard'); // Dashboard
Route::get('/admin/products', 'AdminController@dashboard');

// Admin Kullanıcı Yönetimi

Route::get('/admin/user/edit/{id}', 'AdminController@editOrUpdateUser');    // Düzenleme formu
Route::post('/admin/user/update/{id}', 'AdminController@editOrUpdateUser');   // Form POST
Route::get('/admin/user/delete/{id}', 'AdminController@deleteUser');    // Sil

// Admin Ürün Yönetimi

Route::get('/admin/products/edit/{id}', 'AdminController@editOrUpdateProduct');   // Düzenleme formu
Route::post('/admin/products/update/{id}', 'AdminController@editOrUpdateProduct');  // Form POST
Route::get('/admin/products/delete/{id}', 'AdminController@deleteProduct');

//Admin ürün ekleme
Route::get('/admin/addProduct','AdminController@addProduct');
Route::post('/admin/addProduct','AdminController@addProduct');


// Sepeti görüntüleme
Route::get('/cart', 'CartController@index');
// Sepete ürün ekleme
Route::get('/cart/add/(\d+)', 'CartController@add');
//Sepete Ürün Kaldırma
Route::get('/cart/remove/(\d+)', 'CartController@remove');
//Sepet alışveriş yaptıldıktan sonra stok
Route::post('/cart/order','CartController@order');
//+- artırma 
Route::post('cart/update','CartController@update');
//Toplu Sipariş
Route::post('/cart/bulkOrder', 'CartController@bulkOrder');



