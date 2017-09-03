<?php 

	function startConnection(){
		$strcon = mysqli_connect('localhost', 'root', '', 'carrinho_compras')or die('Erro ao conectar ao banco de dados.');
		return $strcon;
	}

?>