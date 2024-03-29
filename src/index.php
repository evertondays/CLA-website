<?php
header('Content-Type: text/html; charset=utf-8');
include("server-functions/connect.php");

if(!isset($_GET["search"])) {
	$query = sprintf("SELECT * FROM veiculos");
	$tipo = " veículo";
} else {
	$search = $_GET["search"];

	if($search == "carro") {
		$query = sprintf("SELECT * FROM veiculos WHERE tipo = 'Carro'");
		$tipo = " carro";
	} elseif ($search == "moto"){
		$query = sprintf("SELECT * FROM veiculos WHERE tipo = 'Moto'");
		$tipo = "a moto";
	} elseif ($search == "caminhao"){
		$query = sprintf("SELECT * FROM veiculos WHERE tipo = 'Caminhao'");
		$tipo = " caminhão";
	} else{
		$query = sprintf("SELECT * FROM veiculos");
		$tipo = " veículo";
	}
}

$dados = mysql_query($query, $con) or die(mysql_error());
$linha = mysql_fetch_assoc($dados);
$total = mysql_num_rows($dados);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<!-- Google -->
		<meta name="description" content="Site com catálogo para compra de veículos">
		<meta name="author" content="">

		<!-- Meta tags Obrigatórias -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- CSS -->
		<link href="../vendor/bootstrap-4/bootstrap.min.css" rel="stylesheet">
		<link href="../css/default.css" rel="stylesheet">
		<link href="../css/style.css" rel="stylesheet">

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

		<title>CLA - Caminhões e Veículos</title>
		<link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon" />
	</head>
	<body>
		<!-- Conteúdo -->
		<div class="content">
			<?php include("modules/nav-bar.php"); ?>
			
			<!-- Container -->
			<div class="container">
				<!-- BarraPesquisa -->
				<center>
				<div id="divBarraPesquisa">
					<form>
						<input id="barraPesquisa" type="text" class="form-control form-control-underlined border-danger"
							placeholder="&#xf002 Procure por um<?=$tipo?>" style="font-family:Roboto, FontAwesome" autocomplete="off">
					</form>
				</div>
				</center>
				<!-- /BarraPesquisa -->

				<!-- CardsVeículos -->
				<div class="row">
				<?php
					if($total > 0) {
						do {
				?>
				<div class="col-md-6 col-xl-4 mb-3 mb-md-4 veiculo">
					<div id="car-<?=$linha['id']?>" class="card">
						<a href="car-details.php?id=<?php echo $linha['id'] ?>">
							<div class="card-body">
								<h5 class="card-title"><?=$linha['nome']?></h5>
						</a>
						<!-- Imagem -->
						<div id="carousel-<?=$linha['id']?>" class="carousel slide carousel-fade">
							<div class="carousel-inner">
						<?php
						$id = $linha['id'];
						$primeiraImg = True;
						$res = mysql_query("SELECT * FROM imagens WHERE id = '$id'");
						while($row = mysql_fetch_array($res)){
						
							if($primeiraImg == True)
							{
								echo '
									<div class="carousel-item active">
										<img class="card-img" src="data:image/jpeg;base64,'.base64_encode($row['image']).'">
									</div>
								';
								$primeiraImg = False;
							} else {
								echo '
									<div class="carousel-item">
										<img class="card-img" src="data:image/jpeg;base64,'.base64_encode($row['image']).'">
									</div>
								';
							}
						}
						?>
					</div>
				</a>
					<a class="carousel-control-prev" href="#carousel-<?=$linha['id']?>" role="button" data-slide="prev">
						<i class="fas fa-arrow-left"></i>
					</a>
					<a class="carousel-control-next" href="#carousel-<?=$linha['id']?>" role="button" data-slide="next">
						<i class="fas fa-arrow-right"></i>
					</a>
					</div>
					<!-- Fim Imagem -->
					<a href="car-details.php?id=<?php echo $linha['id'] ?>">
							<p class="card-text"><?=$linha['descricao']?></p>
							<p class="card-text-secondary">Ano: <?=$linha['ano']?> - <?=$linha['km']?> Km</p>
							<p class="card-text-type"><?=$linha['tipo']?></p>
							<p class="card-text-value">R$ <?=$linha['valor']?></p>
						</div>
					</div>
					</a>
				</div>
				<?php
						}while($linha = mysql_fetch_assoc($dados));
					}
				?>
				</div>
				<!-- /CardsVeículos -->
				
				<!-- Sem resultados -->
				<div class="sem-resultados">
					<center>
						<h1><i class="fas fa-exclamation-triangle"></i></h1>
						<h4>Ops! Sem resultados . . .</h4>
						<h6>(tente buscar por outros termos ou volte mais tarde ;D)</h6>
					</center>
				</div>
				<!-- Fim Sem resultados -->

			</div>
			<!-- /Container -->
		</div>
		<!-- Fim Conteúdo -->

		<?php include("modules/footer.php") ?>

		<!-- Scripts Obrigatórios -->
		<!-- Jquery JS -->
		<script src="../vendor/jquery/3.4.1.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="../vendor/bootstrap-4/bootstrap.min.js"></script>
		<!-- Sistema de Busca -->
		<script src="../js/busca-veiculos.js"></script>
		<!-- FontAwesome JS -->
		<script src="https://kit.fontawesome.com/04be2c50c3.js" crossorigin="anonymous"></script>

		<script>
			$('.carousel').carousel('pause');
		</script>
	</body>
</html>