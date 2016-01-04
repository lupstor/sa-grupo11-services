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


	public function eliminarCliente($idCliente)
	{

		$responseCode= self::SUCCESS;
		$response = array();
		
		try{

			$cliente = Cliente::find($idCliente);
			$cliente -> delete();

		}catch (\Exception $ex) {
			Log::error($ex);
			$responseCode = self::FAIL;
		}

		$response["responseCode"] = $responseCode;
		return $response;
	}

	public function actualizarCliente()
	{


		$responseCode= self::SUCCESS;
		$response = array();

		//Get request data
		$postData = Input::all();
		
		try{

			$cliente = Cliente::find($postData["id"]);
			$cliente -> nombre = $postData["nombre"];
			$cliente -> telefono = $postData["telefono"];
			$cliente -> direccion = $postData["direccion"];
			$cliente -> email = $postData["email"];
			$cliente -> save();

		}catch (\Exception $ex) {
			Log::error($ex);
			$responseCode = self::FAIL;
		}

		$response["responseCode"] = $responseCode;
		return $response;

		//Log::debug(__METHOD__ ." - Cliente a modificar id: ". print_r($cliente -> id ,true));


	}

	public function obtenerCliente($idCliente)
	{

		try{
			
			$cliente =  Cliente::find($idCliente);
			return $cliente;
			
		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;

	}

}
