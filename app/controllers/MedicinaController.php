<?php

class MedicinaController extends BaseController
{

	const SUCCESS = 0;
	const FAIL = -1;

public function comboMedicinas()
	{
		try {
			return Medicina::where("cantidad",">",0)->lists('nombre', 'id');
		} catch (\Exception $ex) {
			Log::error($ex);
		}
		return null;
	}


	public function listaMedicinas()
	{
		Log::debug(__METHOD__ . " - lista Medicina -" );
		try{
			return DB::table('Medicina')
				->join('Proveedor', 'Medicina.proveedor_id', '=', 'Proveedor.id')
				->select('Medicina.id as id', 'Medicina.nombre as nombre', 'Medicina.descripcion as descripcion','Medicina.cantidad as cantidad','Medicina.precio as precio','Proveedor.nombre as proveedor_id')				
				->orderBy('id','asc')
				->get();
		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;
	}


	public function comboProveedores()
	{
		try {
			Log::debug(__METHOD__ . " - cmb prov -" );

			return Proveedor::lists('nombre', 'id');
		} catch (\Exception $ex) {
			Log::error($ex);
		}
		return null;
	}


 

	public function  guardarMedicina(){
		$response = self::SUCCESS;
		try {
			$data = Input::all();

			Log::error($data);
		
		
			$detalle = new Medicina();
			$detalle->nombre = $data["nombre"];
			$detalle->descripcion =$data["descripcion"];
			$detalle->proveedor_id =$data["proveedor_id"];
			$detalle->cantidad = $data["cantidad"];
			$detalle->precio = $data["precio"];
			$detalle->save();


		} catch (\Exception $ex) {
			Log::error($ex);
			$response = self::FAIL;
		}
		return array("responseCode" => $response);
	}

}
