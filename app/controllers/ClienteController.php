<?php

class ClienteController extends BaseController {

	const SUCCESS = 0;
	const FAIL = -1;


	public function listarClientes()
	{
		try{
			
			return Cliente::all();

		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;
	}

	public function listaClientes()
	{
		try{
			return Cliente::lists('nombre', 'id');
			
		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;
	}


	public function guardarCliente()
	{

		$responseCode= self::SUCCESS;
		$response = array();
		try {

			$data = Input::all();
			$cliente = new Cliente();
			$cliente-> nombre = $data["nombre"];
			$cliente-> telefono = $data["telefono"];
			$cliente-> direccion = $data["direccion"];
			$cliente-> email = $data["email"];
			$cliente->save();
			$response["id"] = $cliente->id;
			
		} catch (\Exception $ex) {
			Log::error($ex);
			$responseCode = self::FAIL;
		}
		$response["responseCode"] = $responseCode;
		return $response;

	}

}
