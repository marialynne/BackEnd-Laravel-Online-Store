<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*
    Verb	   |  URI	                 |  Action   |  Route Name
    ———————————————————————————————————————————————————————————————————
    GET	       |  /photos	             |  index	 |  photos.index
    GET	       |  /photos/create	     |  create	 |  photos.create
    POST	   |  /photos	             |  store	 |  photos.store
    GET	       |  /photos/{photo}	     |  show     |  photos.show
    GET	       |  /photos/{photo}/edit   |	edit	 |  photos.edit
    PUT/PATCH  |  /photos/{photo}	     |  update	 |  photos.update
    DELETE	   |  /photos/{photo}	     |  destroy	 |  photos.destroy
*/

// CRUD
Route::resources([
    'brands' => 'BrandController',
    'categories' => 'CategoryController',
    'notifications' => 'NotificationController',
    'notification-types' => 'NotificationTypeController',
    'orders' => 'OrderController',
    'ordered-products' => 'OrderedProductController',
    'ordered-services' => 'OrderedServiceController',
    'order-statuses' => 'OrderStatusController',
    'order-types' => 'OrderTypeController',
    'products' => 'ProductController',
    'services' => 'ServiceController',
    'shipments' => 'ShipmentController',
    'type-of-users' => 'TypeOfUserController',
    'units' => 'UnitController',
    'users' => 'UserController'
]);

// Brands
Route::group(['prefix' => 'brands'], function () {
    Route::post('/select2', 'BrandController@select2')->name('brands.select2');
});
// Categories
Route::group(['prefix' => 'categories'], function () {
    Route::post('/select2', 'CategoryController@select2')->name('categories.select2');
});
// Notifications
Route::group(['prefix' => 'notifications'], function () {
    Route::post('/select2', 'NotificationController@select2')->name('notifications.select2');
});
// Notification Types
Route::group(['prefix' => 'notification-types'], function () {
    Route::post('/select2', 'NotificationTypeController@select2')->name('notification-types.select2');
});
// Orders
Route::group(['prefix' => 'orders'], function () {
    Route::post('/select2', 'OrderController@select2')->name('orders.select2');
});
// Ordered Products
Route::group(['prefix' => 'ordered-products'], function () {
    Route::post('/select2', 'OrderedProductController@select2')->name('ordered-products.select2');
});
// Ordered Services
Route::group(['prefix' => 'ordered-services'], function () {
    Route::post('/select2', 'OrderedServiceController@select2')->name('ordered-services.select2');
});
// Order Statuses
Route::group(['prefix' => 'order-statuses'], function () {
    Route::post('/select2', 'OrderStatusController@select2')->name('order-tatuses.select2');
});
// Order Types
Route::group(['prefix' => 'order-types'], function () {
    Route::post('/select2', 'OrderTypeController@select2')->name('order-types.select2');
});
// Products
Route::group(['prefix' => 'products'], function () {
    Route::post('/select2', 'ProductController@select2')->name('products.select2');
});
// Services
Route::group(['prefix' => 'services'], function () {
    Route::post('/select2', 'ServiceController@select2')->name('services.select2');
});
// Type Of Users
Route::group(['prefix' => 'type-of-users'], function () {
    Route::post('/select2', 'TypeOfUserController@select2')->name('type-of-users.select2');
});
// Units
Route::group(['prefix' => 'units'], function () {
    Route::post('/select2', 'UnitController@select2')->name('units.select2');
});
// Users
Route::group(['prefix' => 'users'], function () {
    Route::post('/select2', 'UserController@select2')->name('users.select2');
});



