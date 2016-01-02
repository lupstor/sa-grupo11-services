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

	//Retorna lista completa de pedidos
	Route::get('lista-pedidos','PedidoController@listaPedidos');

	//Cancela un pedido para un id dado
	Route::get('cancelar-pedido/{idPedido}','PedidoController@cancelarPedido');

	//Guarda un pedido y su detalle
	Route::post('guardar-pedido-presencial','PedidoController@guardarPedidoPresencial');
	Route::post('guardar-pedido-call-center','PedidoController@guardarPedidoCallCenter');
	Route::post('guardar-detalle-pedido','PedidoController@guardarDetallePedido');

	//Borra pedido
	Route::get('borrar-pedido/{idPedido}','PedidoController@borrarPedido');

	//Lista de compras de farmacia
	Route::get('lista-compras-farmacias','PedidoController@listaComprasFarmacias');

	//Lista de compras call center
	Route::get('lista-pedidos-call-center','PedidoController@listaPedidosCallCenter');

	//Detalle de pedido
	Route::get('detalle-pedido/{idPedido}','PedidoController@detallePedido');


});

//Rutas para empleados
Route::group(array('prefix' => 'empleado'), function()
{
	//Retorna lista de empleados para un tipo de empleado dado
	Route::get('lista/{tipoEmpleado}','EmpleadoController@listaEmpleados');
});


//Rutas para clientes
Route::group(array('prefix' => 'cliente'), function()
{
	//Retorna lista de clientes
	Route::get('lista','ClienteController@listaClientes');
});

//Rutas para medicinas
Route::group(array('prefix' => 'medicina'), function()
{
	//Retorna lista de medicinas
	Route::get('lista','MedicinaController@listaMedicinas');
});