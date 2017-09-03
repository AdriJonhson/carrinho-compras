<?php 
	session_start();

	if(!isset($_SESSION['carrinho'])){
		$_SESSION['carrinho'] = array();
	}

	if(isset($_GET['acao'])){

		//ADICIONA CARRINHO
		if($_GET['acao'] == 'add'){
			$id = intval($_GET['id']);
			if(!isset($_SESSION['carrinho'][$id])){
				$_SESSION['carrinho'][$id] = 1;
			}else{
				$_SESSION['carrinho'][$id] += 1;
			}
		}

		//REMOVER; 
		if($_GET['acao'] == 'del'){
			$id = intval($_GET['id']);
			if($_SESSION['carrinho'][$id]){
				unset($_SESSION['carrinho'][$id]);
			}
		}

		//ALTERAR QUANTIDADE;
		if($_GET['acao'] == 'up'){
			if(is_array($_POST['prod'])){
				foreach($_POST['prod'] as $id => $qtd){
					$id = intval($id);
					$qtd = intval($qtd);
					if(!empty($qtd) || $qtd <> 0){
						$_SESSION['carrinho'][$id] = $qtd;
					}else{
						unset($_SESSION['carrinho'][$id]);
					}
				}
			}
		}

	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Consoles.com</title>
	<meta charset="utf-8">
</head>
<body>
	<table border="1">

		<thead>
			<caption>Carrinho de compras</caption>
			<tr>
				<th width="150">Produto</th>
				<th width="49">Quantidade</th>
				<th width="100">Preço</th>
				<th width="100">SubTotal</th>
				<th width="70">Remover</th>
			</tr>
		</thead>
		
		<form action="?acao=up" method="post">

			<tfoot>
				<tr>
					<td colspan="5"><input type="submit" value="Atualizar Carrinho"></td>
				</tr>
				<tr>
					<td colspan="5"><a href="index.php">Adicionar mais produtos</a></td>
				</tr>
			</tfoot>

			<tbody>
				<?php 
					include 'conexao.php';
					if(count($_SESSION['carrinho']) == 0){
						echo "<tr><td colspan = 5 align = 'center'>Não há produto no carrinho</td></tr>";
					}else{
						$total = 0;
						foreach($_SESSION['carrinho'] as $id => $qtd){
							$banco = startConnection();
							$sql = "SELECT * FROM produtos WHERE id = '$id'";
							$qr = mysqli_query($banco,$sql);
							$row = mysqli_fetch_assoc($qr);

							$nome = $row['nome'];
							$preco = number_format($row['preco'], '2',',','.');
							$sub = number_format($row['preco'] * $qtd, '2',',','.');
							$total += $sub;

							echo '<tr>
									<td>'.$nome.'</td>
									<td><input type = "text" size = "7" name = "prod['.$id.']" value = "'.$qtd.'"></td>
									<td>R$ '.$preco.'</td>
									<td>R$ '.$sub.'</td>
									<td><a href = "carrinho.php?acao=del&id='.$id.'">Remove</td>
								</tr>';
						}

						echo '<tr>
						<td colspan = 4>Total</td>
						<td>R$'.$total.'</td>
						</tr>';
					}

				?>

				<!--<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>-->
			</tbody>

		</form>
	</table>
</body>
</html>