<?php include("../administrador/template/cabecera.php"); 

//use TransactionSCI;
require_once '../administrador/config/bdPDO.php';

$db = new TransactionSCI();
$conn = $db->Connect();

?>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-8">Validación de datos de los Proyectos</h1>
    <p class="lead">Identificación de las principales incidencias presente en los datos.</p>    
    
    <form method="post" action="">
      <br>
      <!--input type="submit" value="Procesar registros" name="submit" -->
      <button type="submit" id="submit" name="submit" value="Submit" class="btn btn-success btn-lg">Procesar registros</button>
    </form>

  </div>

  <?php
  if(isset($_POST['submit'])){
    
    $cod_00 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_13');
    $cod_01 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_15');
    $cod_02 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_17');
    $cod_03 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_21');
    $cod_04 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_22');
    $cod_05 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_23');
    $cod_06 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_24');
    $cod_07 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_25');
    $cod_08 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_26');
    $cod_09 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_27');
    $cod_10 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_28');
    $cod_11 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_29');
    $cod_12 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_30');
    $cod_13 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_31');
    $cod_14 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_32');
    $cod_15 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_33');
    $cod_16 = $db->validarDataGerencia("SP_Gerencia_validar_campos_date", 'dato_34');
    $cod_17 = $db->validarDataGerencia("SP_Gerencia_validar_campos_numericos", 'dato_35');

    if ($cod_00 == 0 && $cod_01 == 0 && $cod_02 == 0 && $cod_03 == 0 && $cod_04 == 0 && $cod_05 == 0 && $cod_06 == 0 && $cod_07 == 0 && $cod_08 == 0 && $cod_09 == 0 && $cod_10 == 0 && $cod_11 == 0 && $cod_12 == 0 && $cod_13 == 0 && $cod_14 == 0 && $cod_15 == 0 && $cod_16 == 0 && $cod_17 == 0) {
      $type = "success";
      $message = "Todos los procesos finalizarón satisfactoriamente.";
      $_SESSION['validaciongerencia'] = 1;
    }else{
      $type = "error";
      $message = "Se encontrarón incidencias en las siguientes variables. Revise e intente de nuevo.<br>
      <table><tr>
        <th>Variable</th>
        <th>&emsp;</th>
        <th>Estado</th>
      </tr>";
      $d01 = "<tr><td>Tipo de documento</td><td>:</td><td>". ($cod_00 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d02 = "<tr><td>Nacionalidad</td><td>:</td><td>". ($cod_01 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.') ."</td></tr>";
      $d03 = "<tr><td>Tipo de organización</td><td>:</td><td>". ($cod_02 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d04 = "<tr><td>Genero</td><td>:</td><td>". ($cod_03 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d05 = "<tr><td>Edad</td><td>:</td><td>". ($cod_04 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d06 = "<tr><td>¿Es adulto?</td><td>:</td><td>". ($cod_05 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d07 = "<tr><td>Indigena </td><td>:</td><td>". ($cod_06 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d08 = "<tr><td>Discapacidad </td><td>:</td><td>". ($cod_07 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d09 = "<tr><td>Tipo discapacidad </td><td>:</td><td>". ($cod_08 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d10 = "<tr><td>Gestante </td><td>:</td><td>". ($cod_09 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.'). "<br>";
      $d11 = "<tr><td>Tiempo de gestación </td><td>:</td><td>". ($cod_10 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d12 = "<tr><td>Tipo de proyecto </td><td>:</td><td>". ($cod_11 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d13 = "<tr><td>Codigo de proyecto </td><td>:</td><td>". ($cod_12 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d14 = "<tr><td>Tema </td><td>:</td><td>". ($cod_13 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d15 = "<tr><td>Subtema </td><td>:</td><td>". ($cod_14 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d16 = "<tr><td>Taller - actividad </td><td>:</td><td>". ($cod_15 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr>";
      $d17 = "<tr><td>Fecha de actividad </td><td>:</td><td>". ($cod_16 == 0 ? 'Ok':'Revisar. Faltan datos o fechas con formato invalido. El formato esperado es dd/mm/aaaa (27/12/2021)')."</td></tr>";
      $d18 = "<tr><td>Persona que registro </td><td>:</td><td>". ($cod_17 == 0 ? 'Ok':'Revisar. Faltan datos o son inconsistentes.')."</td></tr></table>";
      $message .= $d01 . $d02 . $d03 . $d04 .$d05 . $d06 . $d07 . $d08 . $d09 . $d10;
      $message .= $d11 . $d12 . $d13 . $d14 .$d15 . $d16 . $d17 . $d18;
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