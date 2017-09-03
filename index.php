<!DOCTYPE html>
<html>
<head>
	<title>Consoles.com</title>
	<meta charset="utf-8">
</head>
<body>
	<?php 
		include 'conexao.php';
		$banco = startConnection();
		$sql = "SELECT * FROM produtos";
		$qr = mysqli_query($banco,$sql);
		
		while($row = mysqli_fetch_array($qr)){
			echo '<h2>'.$row['nome'].'</h2><br/>';
			echo 'Preço : R$'.number_format($row['preco'], 2, ',', '.').'<br>';
			echo '<img src = "images/'.$row['imagem'].'" width = 200px/><br>';
			echo '<a href = "carrinho.php?acao=add&id='.$row['id'].'">Adicionar ao Carrinho</a>';
			echo '<br><hr>';
		}

	?>
</body>
</html>