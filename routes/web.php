<?php

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

Route::get('/', 'ProductController@index');

Route::get('cart', 'ProductController@cart');

Route::get('add-to-cart/{id}', 'ProductController@addToCart');

Route::patch('update-cart', 'ProductController@update2');

Route::delete('remove-from-cart', 'ProductController@remove');

