<?php

class ClienteController extends BaseController {

	const SUCCESS = 0;
	const FAIL = -1;


	public function listaClientes()
	{
		try{
			return Cliente::all();
		} catch (\Exception $ex){
			Log::error($ex);
		}
		return null;
	}



}
