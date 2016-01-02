<?php

class MedicinaController extends BaseController
{

	const SUCCESS = 0;
	const FAIL = -1;


	public function listaMedicinas()
	{
		try {
			return Medicina::where("cantidad",">",0)->lists('nombre', 'id');
		} catch (\Exception $ex) {
			Log::error($ex);
		}
		return null;
	}
}
