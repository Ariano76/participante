<?php include("template/cabecera.php");
?>

<div class="col-md-12">
	<div class="jumbotron">
		<h1 class="display-3">Bienvenido <?php echo $nombreUsuario ; ?> !</h1>
		<p class="lead">Estamos en la sección de administración del sistema web.</p>
		<hr class="m-y-md">
		<p>Desde esta sección podrá realizar tareas de mantenimiento sobre cuentas existentes, crear nuevos usuarios para acceder al sistema, eliminar cuentas, así como la migración de datos, si cuenta con los permisos respectivos.</p>
		<!--p class="lead">
			<a class="btn btn-primary btn-lg" href="seccion/usuarios.php?id=null" role="button">Administrar Beneficiarios</a>
		</p-->
	</div>
</div>

<?php include("template/pie.php");
?>