<?php

class EmpleadoController extends BaseController {

	const SUCCESS = 0;
	const FAIL = -1;


	public function listaEmpleados($tipoPuntoVenta)
	{
		Log::debug(__METHOD__ . " - Tipo punto venta[$tipoPuntoVenta]" );
		try{
			return DB::table('Empleado')
				->join('PuntoVenta', 'Empleado.punto_venta_id', '=', 'PuntoVenta.id')
				->select('Empleado.id', 'Empleado.nombre', 'Empleado.tipo_empleado','Empleado.email','PuntoVenta.nombre','PuntoVenta.tipo_punto_venta')
				->where('PuntoVenta.tipo_punto_venta', '=', "$tipoPuntoVenta")
				->get();
		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;
	}

}
