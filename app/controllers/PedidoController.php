<?php

class PedidoController extends BaseController {



	public function getPedido($idPedido)
	{
		$pedidos = Pedido::find($idPedido);
		return $pedidos;
	}

}
