<?php


class PedidoController extends BaseController {

	const SUCCESS = 0;
	const FAIL = -1;

	/**
	 * Retorna pedido para un id dado
	 * @param int $idPedido
	 * @return array
	 */
	public function getPedido($idPedido)
	{
		try{
			return Pedido::find($idPedido);
		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;
	}


	/**
	 * Retorna lista completa de pedidos
	 * @return array|null
	 */
	public function listaPedidos()
	{
		try{
			return Pedido::all();
		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;
	}

	/**
	 * Cancela un pedido para un id dado
	 * @param int $idPedido
	 * @return array
	 */
	public  function  cancelarPedido($idPedido){
		$response = self::SUCCESS;
		try{
			$pedido = Pedido::find($idPedido);
			if (empty($pedido)) throw new Exception("Error al intentar recuperar el pedido # [$idPedido]");
			$pedido->status = 'cancelado';
			$pedido->save();
		}catch (\Exception $ex){
			Log::error($ex);
			$response = self::FAIL;
		}
		return array("responseCode" => $response);
	}

	public  function guardarPedidoPresencial()
	{
		$response = array();
		$responseCode= self::SUCCESS;

		try {
			$data = Input::all();

			$pedido = new Pedido();
			$pedido->cliente = $data["cliente"];
			$pedido->creado_por = $data["empleado"];
			$pedido->save();
			$response["id_pedido"] = $pedido->id;

		} catch (\Exception $ex) {
			Log::error($ex);
			$responseCode = self::FAIL;
		}
		$response["responseCode"] = $responseCode;
		return $response;
	}



	public  function  guardarPedidoCallCenter(){
		$responseCode= self::SUCCESS;
		$response = array();
		try {
			$data = Input::all();

			$pedido = new Pedido();
			$pedido->cliente = $data["cliente"];
			$pedido->creado_por = $data["creado_por"];
			$pedido->direccion_entrega = $data["direccion_entrega"];
			$pedido->nombre_recibe = $data["nombre_recibe"];
			$pedido->call_center = $data["call_center"];
			$pedido->status = $data["status"];
			$pedido->save();
			$response["id_pedido"] = $pedido->id;
		} catch (\Exception $ex) {
			Log::error($ex);
			$responseCode = self::FAIL;
		}
		$response["responseCode"] = $responseCode;
		return $response;
	}

	public function  guardarDetallePedido(){
		$response = self::SUCCESS;
		try {
			$data = Input::all();

			$medicina = Medicina::find($data["medicina"]);
			$cantidadRestante = $medicina->cantidad - $data["cantidad"];

			if($data["cantidad"] == 0) throw new \Exception("Se tiene que agregar por lo menos un medicamento");
			if($cantidadRestante <= 0) throw new \Exception("No hay disponbilidad suficiente de medicina");

			//Guardar detalle
			$subtotal = $medicina->precio * (int) $data["cantidad"];
			$detallePedido = new DetallePedido();
			$detallePedido->pedido_id = $data["pedido_id"];
			$detallePedido->medicina = $data["medicina"];
			$detallePedido->cantidad = $data["cantidad"];
			$detallePedido->subtotal = $subtotal;
			$detallePedido->save();

			//Actualizar total
			$pedido = Pedido::find($data["pedido_id"]);
			$pedido->total = $pedido->total+ $subtotal;
			$pedido->save();

			//Restar de el catalogo
			$medicina->cantidad = $cantidadRestante;
			$medicina->save();

		} catch (\Exception $ex) {
			Log::error($ex);
			$response = self::FAIL;
		}
		return array("responseCode" => $response);
	}



	public function  borrarPedido($idPedido){
		$response = self::SUCCESS;
		try {
			DetallePedido::where('pedido_id', '=', $idPedido)->delete();
			Pedido::where('id', '=', $idPedido)->delete();
		} catch (\Exception $ex) {
			Log::error($ex);
			$response = self::FAIL;
		}
		return array("responseCode" => $response);
	}

	public function listaComprasFarmacias(){
		try{
			return DB::table('Pedido')
				->join('Empleado', 'Pedido.creado_por', '=', 'Empleado.id')
				->join('Cliente', 'Pedido.cliente', '=', 'Cliente.id')
				->join('PuntoVenta', 'Empleado.punto_venta_id', '=', 'PuntoVenta.id')
				->select('Pedido.id', 'Cliente.nombre as cliente',
					'Empleado.nombre as empleado',
					'PuntoVenta.nombre as farmacia',
					'Pedido.tipo_pago',
					'Pedido.total',
					'Pedido.created_at')
				->where('PuntoVenta.tipo_punto_venta', '=', "farmacia")
				->get();
		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;

	}

	public  function  listaPedidosCallCenter(){
		try{
			return DB::table('Pedido')
				->select('Pedido.id',
					'Pedido.created_at as fecha_hora',
					'Pedido.cliente',
					'Pedido.creado_por',
					'Pedido.status',
					'Pedido.call_center',
					'Pedido.nombre_recibe',
					'Pedido.direccion_entrega',
					'Pedido.tipo_pago',
					'Pedido.total'
					)
				->where('Pedido.call_center', '!=', "")
				->get();
		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;

	}

	public  function  detallePedido($pedidoId){
		try{
			return DB::table('DetallePedido')
				->where('DetallePedido.pedido_id', '=', $pedidoId)
				->get();
		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;

	}

	public function guardarPagoPedido(){
		$response = self::SUCCESS;
		try {
			$data = Input::all();
			$pedido = Pedido::find($data["idPedido"]);
			$pedido->tipo_pago = $data["tipo_pago"];
			$pedido->status = $data["status"];
			$pedido->recargo = $data["ocultoRecargo"];
			$pedido->save();
		}  catch (\Exception $ex) {
			Log::error($ex);
			$response = self::FAIL;
		}	
		return array("responseCode" => $response);
	}
	
	public function verificarPagoTarjeta(){
		$response = self::SUCCESS;
		try {
			$data = Input::all();
			if($data["NoTarjeta"] <= 0) throw new \Exception("Debe Agregar un numero de Tarjeta Valido");
			if($data['CodigoSeguridad'] <= 0) throw new \Exception("Debe Agregar un codigo de Tarjeta Valido");
		}  catch (\Exception $ex) {
			Log::error($ex);
			$response = self::FAIL;
		}	
		return array("responseCode" => $response);
	}
	
	public function verificarPagoEfectivo(){
		$response = self::SUCCESS;
		try {
			$data = Input::all();
			if($data["ocultoCambio"] < 0) throw new \Exception("El pago debe ser mayor al total de la compra");
		}  catch (\Exception $ex) {
			Log::error($ex);
			$response = self::FAIL;
		}	
		return array("responseCode" => $response);
	}
}
