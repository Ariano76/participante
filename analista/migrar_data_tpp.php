<?php include("../administrador/template/cabecera.php"); ?>

<?php
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once ('../administrador/config/bdPDO.php');

$db_1 = new TransactionSCI();

require_once ('../vendor/autoload.php');

if (isset($_POST["import"])) {
  $type = "success";
  
  $var = $db_1->migrar_data_reporte_tarjetas("SP_migrar_data_tpp", $nombreUsuario);
  //echo "<script>console.log('entre al IF var: " . $var . "');</script>"; 
  if (!empty($var) && $var == 1) { 
      //echo "<script>console.log('entre al IF 1: " . $var . "');</script>"; 
    $type = "success";
    $message = "La migración se ha realizado con exito.";
  } else {
      //echo "<script>console.log('entre al IF 2: " . $var . "');</script>"; 
    $type = "error";
    $message = "No existen datos por migrar. Verifique e intente de nuevo";           
  }       

}
?>

<div class="col-md-12">
  <div class="card text-dark bg-light">
    <div class="card-header">
      Migrar datos TPP
    </div>
    <div class="card-body">
      <form method="POST" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
        <div class="form-group">
          <label for="txtImagen">Este proceso realiza la migración de los datos del ambiente Stage a la tabla de Reporte TPP que contiene los datos validados para su posterior análisis.</label>
          <br>
        </div>        
        <br>
        <br>
        <div class="btn-group" role="group" aria-label="Basic example">
          <button type="submit" id="submit" name="import" value="agregar" class="btn btn-success btn-lg">Migrar Datos</button>
        </div>

      </form>
    </div>
  </div>
</div>
<div class="col-md-12">
  <div class=card-text>
    <div class="<?php if(!empty($type)){ echo $type . " alert alert-success role=alert"; } ?>
    <?php if(!empty($message1) && $_SESSION['validaciongerencia'] == 0){ echo "error alert alert-success role=alert"; } ?>
    ">
    <?php if(!empty($var)) { echo $message; } 
    if(!empty($message1) && $_SESSION['validaciongerencia'] == 1 ) { echo $message1; } 
    ?>
  </div>
</div>
</div>

<?php include("../administrador/template/pie.php"); ?>