<?php 

session_start();

if (!isset($_SESSION['usuario'])) {
	header("Location:../index.php");	
}else {
	if ($_SESSION['usuario'] == 'ok') {
		$nombreUsuario = $_SESSION['nombreUsuario'];		
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<!--meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administración SCF</title>

	
	
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<!-- jQuery -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

	<!-- libreria para utilizar iconos en nuestras paginas  -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

	<!-- tabla reportes -->
	<style>
		table.dataTable thead {background: linear-gradient(to right, #0575E6, #0575E6);
			color:white;}
			.success {
				background: #c7efd9;
				border: #bbe2cd 1px solid;
			}
			.error {
				background: #fbcfcf;
				border: #f3c6c7 1px solid;
			}
			.firma {
				background: #FFF3CD;
				border: #f3c6c7 1px solid;
			}
			div#response.display-block {
				display: block;
			}
			/* ============ desktop view ============ */
			@media all and (min-width: 992px) {

				.dropdown-menu li{
					position: relative;
				}
				.dropdown-menu .submenu{ 
					display: none;
					position: absolute;
					left:100%; top:-7px;
				}
				.dropdown-menu .submenu-left{ 
					right:100%; left:auto;
				}

				.dropdown-menu > li:hover{ background-color: #f1f1f1 }
				.dropdown-menu > li:hover > .submenu{
					display: block;
				}
			}	
/* ============ desktop view .end// ============ */

/* ============ small devices ============ */
@media (max-width: 991px) {

	.dropdown-menu .dropdown-menu{
		margin-left:0.7rem; margin-right:0.7rem; margin-bottom: .5rem;
	}

}	
/* ============ small devices .end// ============ */
</style>

<script type="text/javascript">
//	window.addEventListener("resize", function() {
//		"use strict"; window.location.reload(); 
//	});


document.addEventListener("DOMContentLoaded", function(){

    	/////// Prevent closing from click inside dropdown
    	document.querySelectorAll('.dropdown-menu').forEach(function(element){
    		element.addEventListener('click', function (e) {
    			e.stopPropagation();
    		});
    	})

		// make it as accordion for smaller screens
		if (window.innerWidth < 992) {

			// close all inner dropdowns when parent is closed
			document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
				everydropdown.addEventListener('hidden.bs.dropdown', function () {
					// after dropdown is hidden, then find all submenus
					this.querySelectorAll('.submenu').forEach(function(everysubmenu){
					  	// hide every submenu as well
					  	everysubmenu.style.display = 'none';
					  });
				})
			});
			
			document.querySelectorAll('.dropdown-menu a').forEach(function(element){
				element.addEventListener('click', function (e) {

					let nextEl = this.nextElementSibling;
					if(nextEl && nextEl.classList.contains('submenu')) {	
				  		// prevent opening link if link needs to open dropdown
				  		e.preventDefault();
				  		console.log(nextEl);
				  		if(nextEl.style.display == 'block'){
				  			nextEl.style.display = 'none';
				  		} else {
				  			nextEl.style.display = 'block';
				  		}
				  	}
				  });
			})
		}
		// end if innerWidth
	}); 
	// DOMContentLoaded  end
</script>

</head>

<body>

	<?php $url="http://".$_SERVER['HTTP_HOST']."/scf" ?>
	<?php 
	if ($_SESSION['rolusuario']==4) { // COORDINADOR FINANZAS
		?>
		<!--nav class="navbar navbar-expand-md navbar-dark bg-primary"-->
		<nav class="navbar navbar-expand-md navbar-light bg-white border border-dark">
			<div class="container-fluid">		
				<a class="navbar-brand" href="<?php echo $url."/administrador/inicio.php" ?>">
					<img src="https://www.savethechildren.org.pe/wp-content/themes/save-the-children/images/logo-save-the-children.svg" alt="" width="" height="">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
					</a>
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div class="navbar-nav">
						<li>
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Tareas</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="<?php echo $url."/coordinador/paquetes_aprobacion.php"?>">Aprobar paquetes</a>
							</div>
						</li>
						<li>
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Bonos</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="<?php echo $url."/coordinador/bono_conectividad.php"?>">Conectividad</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?php echo $url."/coordinador/bono_familiar.php"?>">Familiar</a>
							</div>
						</li>				

						<a class="nav-item nav-link" href="<?php echo $url."/administrador/seccion/cerrar.php"?>">Cerrar</a>
						<a class="nav-item nav-link" href="<?php echo $url;?>">Ver sitio web</a>
					</div>
				</div>
			</div>
		</nav>
		<?php 
	} elseif($_SESSION['rolusuario']==5) { // ANALISTA FINANZAS
		?>
		<nav class="navbar navbar-expand-md navbar-light bg-white border border-dark">
			<div class="container-fluid">		
				<a class="navbar-brand" href="<?php echo $url."/administrador/inicio.php" ?>">
					<img src="https://www.savethechildren.org.pe/wp-content/themes/save-the-children/images/logo-save-the-children.svg" alt="" width="" height="">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
					</a>
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div class="navbar-nav">
						<li>
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Proveedores de Pago</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="<?php echo $url."/analista/finanza_paquete.php" ?>">Recarga Tarjetas</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?php echo $url."/analista/uploadfile_jetperu.php" ?>">Cargar datos JET PERU</a>
								<a class="dropdown-item" href="<?php echo $url."/analista/validacion_datos_jetperu.php" ?>">Limpiar datos</a>
								<a class="dropdown-item" href="<?php echo $url."/analista/migrar_data_jetperu.php" ?>">Migrar datos</a>
								<a class="dropdown-item" href="<?php echo $url."/analista/delete_reporte_jetperu.php" ?>">Depurar datos duplicados</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?php echo $url."/analista/uploadfile_tpp.php" ?>">Cargar datos TPP</a>
								<a class="dropdown-item" href="<?php echo $url."/analista/validacion_datos_tpp.php" ?>">Limpiar datos</a>
								<a class="dropdown-item" href="<?php echo $url."/analista/migrar_data_tpp.php" ?>">Migrar datos</a>
							</div>
						</li>						
						<a class="nav-item nav-link" href="<?php echo $url."/administrador/seccion/cerrar.php"?>">Cerrar</a>
						<a class="nav-item nav-link" href="<?php echo $url;?>">Ver sitio web</a>
					</div>
				</div>
			</div>
		</nav>
		<?php	
	} elseif($_SESSION['rolusuario']==3) { // GERENCIA FINANZAS
		?>
		<nav class="navbar navbar-expand-md navbar-light bg-white border border-dark">
			<div class="container-fluid">		
				<a class="navbar-brand" href="<?php echo $url."/administrador/inicio.php" ?>">
					<img src="https://www.savethechildren.org.pe/wp-content/themes/save-the-children/images/logo-save-the-children.svg" alt="" width="" height="">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
					</a>
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div class="navbar-nav">
						<li>
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Análisis Financiero</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="<?php echo $url."/gerencia/sof.php" ?>">Maestro de Proyectos</a>
								<a class="dropdown-item" href="<?php echo $url."/gerencia/costc.php" ?>">Maestro Centro de Costo</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?php echo $url."/gerencia/dea.php" ?>">Maestro DEA</a>
								<a class="dropdown-item" href="<?php echo $url."/gerencia/uploadfile_dea.php" ?>">Cargar DEA masivos</a>
								<div class="dropdown-divider"></div>
								
								<a class="dropdown-item" href="<?php echo $url."/gerencia/uploadfile_ppto_sof.php" ?>">Cargar datos financieros PPTO SOF</a>
								<a class="dropdown-item" href="<?php echo $url."/gerencia/uploadfile_ppto.php" ?>">Cargar datos financieros PPTO</a>
								<a class="dropdown-item" href="<?php echo $url."/gerencia/uploadfile_gastos.php" ?>">Cargar datos financieros Gastos</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?php echo $url."/gerencia/finanzas_dashboard.php" ?>">Dashboard</a>
							</div>
						</li>
						<a class="nav-item nav-link" href="<?php echo $url."/administrador/seccion/cerrar.php"?>">Cerrar</a>
						<a class="nav-item nav-link" href="<?php echo $url;?>">Ver sitio web</a>
					</div>
				</div>
			</div>
		</nav>
		<?php	
	}
	else{ // ROLES NO FINANZAS
		?>
		<nav class="navbar navbar-expand-md navbar-light bg-white border border-dark">
			<div class="container-fluid">		
				<a class="navbar-brand" href="<?php echo $url."/administrador/inicio.php" ?>">
					<img src="https://www.savethechildren.org.pe/wp-content/themes/save-the-children/images/logo-save-the-children.svg" alt="" width="" height="">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
					</a>
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div class="navbar-nav">
						<a class="nav-item nav-link" href="<?php echo $url."/administrador/seccion/cerrar.php"?>">Cerrar</a>
						<a class="nav-item nav-link" href="<?php echo $url;?>">Ver sitio web</a>
					</div>
				</div>
			</div>
		</nav>
		<?php	
	}
	?>


	<div class="container">
		<br><br>
		<div class="row">