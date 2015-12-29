<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


//Rutas para pedidos
Route::group(array('prefix' => 'pedido'), function()
{

	//Retorna pedido por id
	Route::get('obtener-por-id/{idPedido}','PedidoController@getPedido');

});