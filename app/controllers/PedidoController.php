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
		$response = self::SUCCESS;
		try {
			$data = Input::all();

			$pedido = new Pedido();
			$pedido->cliente = $data["cliente"];
			$pedido->gestionado_por = $data["empleado"];
			$pedido->tipo_pago = $data["tipo_pago"];
			$pedido->total = $data["total"];
			$pedido->save();

		} catch (\Exception $ex) {
			Log::error($ex);
			$response = self::FAIL;
		}
		return array("responseCode" => $response);
	}



	public  function  guardarPedidoCallCenter(){
		$response = self::SUCCESS;
		try {
			$data = Input::all();

			$pedido = new Pedido();
			$pedido->cliente = $data["cliente"];
			$pedido->gestionado_por = $data["empleado"];
			$pedido->status = $data["status"];
			$pedido->direccion_entrega = $data["direccion_entrega"];
			$pedido->nombre_recibe = $data["nombre_recibe"];
			$pedido->total = $data["total"];
			$pedido->repartidor = $data["repartidor"];
			$pedido->call_center = $data["call_center"];
			$pedido->creado_por = $data["creado_por"];
			$pedido->hora_salida = (new DateTime())->format("Y-m-d h:m:i");;
			$pedido->save();

		} catch (\Exception $ex) {
			Log::error($ex);
			$response = self::FAIL;
		}
		return array("responseCode" => $response);
	}



	public function  guardarDetallePedido(){
		$response = self::SUCCESS;
		try {
			$data = Input::all();

			$detallePedido = new DetallePedido();
			$detallePedido->pedido_id = $data["pedido_id"];
			$detallePedido->medicina = $data["medicina"];
			$detallePedido->cantidad = $data["cantidad"];
			$detallePedido->subtotal = $data["subtotal"];
			$detallePedido->save();
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
				->join('Empleado', 'Pedido.gestionado_por', '=', 'Empleado.id')
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
					'Pedido.status',
					'Pedido.repartidor',
					'Pedido.cliente',
					'Pedido.creado_por',
					'Pedido.gestionado_por',
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


}
