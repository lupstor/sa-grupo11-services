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
	Route::post('guardar-pago-pedido','PedidoController@guardarPagoPedido');
	Route::post('verificar-pago-tarjeta','PedidoController@verificarPagoTarjeta');
	Route::post('verificar-pago-efectivo','PedidoController@verificarPagoEfectivo');
	
	//Borra pedido
	Route::get('borrar-pedido/{idPedido}','PedidoController@borrarPedido');

	//Lista de compras de farmacia
	Route::get('lista-compras-farmacias','PedidoController@listaComprasFarmacias');

	//Lista de compras call center
	Route::get('lista-pedidos-call-center','PedidoController@listaPedidosCallCenter');

	//Detalle de pedido
	Route::get('detalle-pedido/{idPedido}','PedidoController@detallePedido');

	//Cancelar compra
	Route::get('cancelar-compra/{idPedido}','PedidoController@cancelarCompra');


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
//retorna los datos de los clientes
Route::get('lista-clientes','ClienteController@listarClientes');
//guardar cliente
Route::post('guardar-cliente','ClienteController@guardarCliente');
//eliminar cliente
Route::get('eliminar-cliente/{idCliente}','ClienteController@eliminarCliente');
//actualizar cliente
Route::post('actualizar-cliente','ClienteController@actualizarCliente');
//obtenerCliente
Route::get('obtener-cliente/{idCliente}','ClienteController@obtenerCliente');
});

//Rutas para medicinas
Route::group(array('prefix' => 'medicina'), function()
{
	//Retorna lista de  medicinas
	Route::get('lista-medicinas','MedicinaController@listaMedicinas');

	//Combo  medicinas
	Route::get('combo-medicinas','MedicinaController@comboMedicinas');

	//Combo  proveedores
	Route::get('combo-proveedores','MedicinaController@comboProveedores');

	//guardar cliente
	Route::post('guardar-medicina','MedicinaController@guardarMedicina');

});