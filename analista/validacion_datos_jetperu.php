<?php include("../administrador/template/cabecera.php"); 

//use TransactionSCI;
require_once '../administrador/config/bdPDO.php';

$db = new TransactionSCI();
$conn = $db->Connect();

?>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-8">Limpiar datos JETPERU</h1>
    <p class="lead">Identificación de las principales incidencias presente en los datos y su corrección.</p>    
    
    <form method="post" action="">
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name='opciones[]' value="Opcion_01" checked>
        <label class="form-check-label" for="flexSwitchCheckDefault">Limpiar espacios en blanco</label>
      </div>
      <br>
      <!--input type="submit" value="Procesar registros" name="submit" -->
      <button type="submit" id="submit" name="submit" value="Submit" class="btn btn-success btn-lg">Procesar registros</button>
    </form>

  </div>

  <?php
  if(isset($_POST['submit'])){
    
    $cod_00 = $db->ejecutarstoredprocedure("SP_finanzas_clean_jetperu");

    if ($cod_00 == 1 ) {
      $type = "success";
      $message = "Todos los procesos finalizarón satisfactoriamente.";
    }else{
      $type = "error";
      $message = "Problemas al ejecutar los procesos de validacón. Intente de nuevo.". $cod_00 ;
    }
  }
  ?>

  <div class="col-md-12">
    <div class=card-text>&nbsp;</div>
  </div>
  <div class="col-md-12">
    <div class=card-text>
      <div class="<?php if(!empty($type)) { echo $type . " alert alert-success role=alert"; } ?>"><?php if(!empty($message)) { echo $message; } ?>
    </div>
  </div>
</div>


<?php include("../administrador/template/pie.php"); ?>