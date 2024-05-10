<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema SCF</title>
	
	<!--link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css"-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	
	<!-- jQuery -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<!-- DataTables CSS -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">  
  	<!-- libreria para utilizar iconos en nuestras paginas  -->
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">  	
  	<!-- tabla reportes -->
  	<style>
  		table.dataTable thead {
  			background: linear-gradient(to right, #0575E6, #0575E6);
  			color:white;	}

  	</style>  
</head>
  	<body>
  		<?php $url="http://".$_SERVER['HTTP_HOST']."/scf" ?>

  		<nav class="navbar navbar-expand-md navbar-light bg-white border border-dark">
  			<div class="container-fluid">		
  				<a class="navbar-brand" href="<?php echo $url."/index.php"?>">
  				<img src="https://www.savethechildren.org.pe/wp-content/themes/save-the-children/images/logo-save-the-children.svg" alt="" width="" height="">
  				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
  					</a>
  					<span class="navbar-toggler-icon"></span>
  				</button>  				
  				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
  					<div class="navbar-nav">
  						<a class="nav-item nav-link" href="<?php echo $url."/administrador/index.php"?>" tabindex="-1" aria-disabled="true">Ingresar al sistema</a>
  					</div>
  				</div>
  			</div>
  		</nav>

  		<div class="container">
  			<br>
  			<!-- Content here -->
  			<div class="row">
