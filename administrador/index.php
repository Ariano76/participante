<?php 

session_start();

if ($_POST) {
	require_once './config/bdPDO.php';
	$db = new TransactionSCI();

	$codigo = $db->login($_POST['usuario'], $_POST['contrasenia']);

	if($codigo >= 1){
		$_SESSION['usuario'] = 'ok';
		$_SESSION['nombreUsuario'] = strtolower($_POST['usuario']);
		$_SESSION['validaciongerencia'] = '0';
		$codigorol = $db->select_rol($codigo);
		$_SESSION['rolusuario'] = $codigorol;

		header('Location:inicio.php');	
	} else {
		$mensaje = "Error: El usuario o contraseña no coinciden.";
	}
}
?>

<!doctype html>
	<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<title>Login</title>
	</head>

	<body>

		<?php $url="http://".$_SERVER['HTTP_HOST']."/scf" ?>
		
		<div class="container">
			<div class="row">
				<div class="col-md-4">

				</div>

				<div class="col-md-4">
					<br><br><br>
					<div class="card text-left">
						<div class="card-header">
							Login
						</div>
						<div class="card-body">

							<?php
							if (isset($mensaje)) { ?>
								<div class="alert alert-danger" role="alert">
									<?php echo $mensaje; ?>
								</div>
							<?php }
							?>
						
							<form method="POST">
								<div class="form-group">
									<label>Usuario</label>
									<input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">
									<small id="emailHelp" class="form-text text-muted">Nunca compartas tu usuario con nadie.</small>
								</div>
								<div class="form-group">
									<label>Contraseña</label>
									<input type="password" class="form-control" name="contrasenia" placeholder="Escribe tu contraseña">
								</div>
								<button type="submit" class="btn btn-primary">Entrar al Administrador</button>
							</form>
							<a class="nav-item nav-link" href="<?php echo $url;?>">Regresar</a>
							<a class="nav-item nav-link" href="<?php echo $url."/administrador/reset_pass.php";?>">¿Olvido su contraseña?</a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</body>
	</html>