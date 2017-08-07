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

Route::get('/orders', function () {
  $orders = App\Order::all();

  return $orders;
});

Route::put('/orders', function (Request $request) {
  forEach($request->json()->all() as $data) {
    $order = App\Order::find($data['id']);
    $order->completed = $data['completed'];
    $order->save();
  }
});
