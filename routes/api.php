<?php

use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\CategoriesController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    //Akun
    // Route::controller(UserController::class)->group(function(){
    //     Route::get('/user', 'index');
    //     Route::post('/user/store', 'store');
    //     Route::patch('/user/{id}/update', 'update');
    //     Route::get('/user/{id}','show');
    //     Route::delete('/user/{id}', 'destroy');
    // });


    Route::apiResource('user', UserController::class);
    Route::apiResource('customers', CustomersController::class);
    Route::apiResource('orders', OrdersController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('order-items', OrderItemController::class);    
    Route::apiResource('categories', CategoriesController::class);

    Route::get('/dashboard-counts', function () {
        return response()->json([
            'users' => \App\Models\User::count(),
            'customers' => \App\Models\Customers::count(),
            'product' => \App\Models\product::count(),
            'orders' => \App\Models\Orders::count(),
            'order-item' => \App\Models\OrderItem::count(),
            'categories' => \App\Models\categories::count(),
        ]);
    });
});
