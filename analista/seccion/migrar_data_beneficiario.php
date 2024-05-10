<?php include("../template/cabecera.php"); ?>

<?php
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

//require_once './administrador/config/bd.php';

require_once ('../config/bdPDObenef.php');


$db_1 = new TransactionSCI();
//$conn_1 = $db_1->Connect();

require_once ('../../vendor/autoload.php');

if (isset($_POST["import"])) {
  $type = "OK";
  $dt = date('Y-m-d H:i:s');
  $timestamp1 = strtotime($dt);
  // recupera todos los registros de tabla STAGE_00
  $usuarios = $db_1->select_beneficiarios("SP_Select_stage_00",$nombreUsuario);

  foreach($usuarios as $usuario) {
    $d01 = (empty($usuario[7])) ? null : $usuario[7];
    $d02 = (empty($usuario[8])) ? null : $usuario[8];
    $d03 = (empty($usuario[9])) ? 0 : $usuario[9];
    $d04 = (empty($usuario[10])) ? null : $usuario[10];
    $d05 = (empty($usuario[11])) ? null : $usuario[11];
    $d06 = (empty($usuario[12])) ? null : $usuario[12];
    $d07 = (empty($usuario[13])) ? null : $usuario[13];
    $d08 = (empty($usuario[14])) ? null : $usuario[14];
    $d09 = (empty($usuario[15])) ? null : $usuario[15];
    $d10 = (empty($usuario[16])) ? null : $usuario[16];
    $d11 = (empty($usuario[17])) ? null : $usuario[17];
    $d12 = (empty($usuario[18])) ? null : $usuario[18];
    $d13 = (empty($usuario[19])) ? null : $usuario[19];
    $d14 = (empty($usuario[20])) ? null : $usuario[20];
    if (empty($usuario[21])) {
      $d15 = '1900/01/01';
      }else{
        $x = $db_1->validar_fecha_espanol($usuario[21]);
          $d15 = ($x) ?  $usuario[21] : '1900/01/01';
      }
    //$d15 = ($db_1->validar_fecha_espanol($usuario[21]) == true) ? $usuario[21] : NULL ;

    $d16 = (empty($usuario[22])) ? 0 : $usuario[22];
    $d17 = (empty($usuario[23])) ? null : $usuario[23];
    //$d18 = ($db_1->validar_fecha_espanol($usuario[24]) == true) ? $usuario[24] : NULL ;
    if (empty($usuario[24])) {
      $d18 = '1900/01/01';
      }else{
        $x = $db_1->validar_fecha_espanol($usuario[24]);
          $d18 = ($x) ?  $usuario[24] : '1900/01/01';
      }
    $d19 = (empty($usuario[25])) ? null : $usuario[25];
    $d20 = (empty($usuario[26])) ? null : $usuario[26];
    //$d21 = ($db_1->validar_fecha_espanol($usuario[27]) == true) ?  $usuario[27] : NULL ;
    if (empty($usuario[27])) {
      $d21 = '1900/01/01';
      }else{
        $x = $db_1->validar_fecha_espanol($usuario[27]);
          $d21 = ($x) ?  $usuario[27] : '1900/01/01';
      }
    $d22 = (empty($usuario[28])) ? null : $usuario[28];    

    $xCod = $db_1->Insert_beneficiario($d01, $d02, $d03, $d04, $d05, $d06, $d07, $d08, $d09, $d10, $d11, $d12, $d13, $d14, $d15, $d16, $d17, $d18, $d19, $d20, $d21, $d22); 
    //echo $xCod."<br>";    
    

    // RUTINA PARA INSERTAR REGISTROS EN TABLA ENCUESTA
    //$d01 = ($usuario[1] == '') ? null : $usuario[1];
    if (empty($usuario[1])) {
      $d01 = '1900/01/01';
      }else{
        $x = $db_1->validar_fecha_espanol($usuario[1]);
          $d01 = ($x) ?  $usuario[1] : '1900/01/01';
      }
    $d02 = (empty($usuario[2])) ? 0 : $usuario[2];
    $d03 = (empty($usuario[3])) ? NULL : $usuario[3];
    $d04 = (empty($usuario[4])) ? NULL : $usuario[4];
    $d05 = (empty($usuario[5])) ? NULL : $usuario[5];
    $d06 = (empty($usuario[6])) ? 0 : $usuario[6];

    $db_1->Insert_encuesta($d01, $d02, $d03, $d04, $d05, $d06, $xCod); 

    // RUTINA PARA INSERTAR REGISTROS EN TABLA COMUNICACION

    $d01 = (empty($usuario[29])) ? null : $usuario[29];
    $d02 = (empty($usuario[30])) ? 0 : $usuario[30];
    $d03 = (empty($usuario[31])) ? 0 : $usuario[31];
    $d04 = (empty($usuario[32])) ? 0 : $usuario[32];
    $d05 = (empty($usuario[33])) ? 0 : $usuario[33];
    $d06 = (empty($usuario[34])) ? null : $usuario[34];
    $d07 = (empty($usuario[35])) ? null : $usuario[35];
    $d08 = (empty($usuario[36])) ? null : $usuario[36];
    $d09 = (empty($usuario[37])) ? 0 : $usuario[37];
    $d10 = (empty($usuario[38])) ? null : $usuario[38];
    $d11 = (empty($usuario[39])) ? null : $usuario[39];
    $d12 = (empty($usuario[40])) ? 0 : $usuario[40];
    $d13 = (empty($usuario[41])) ? null : $usuario[41];
    $d14 = (empty($usuario[42])) ? null : $usuario[42];

    $db_1->Insert_comunicacion($d01, $d02, $d03, $d04, $d05, $d06, $d07, $d08, $d09, $d10, $d11, $d12, $d13, $d14, $xCod); 

    // RUTINA PARA INSERTAR REGISTROS EN TABLA NUTRICION

    $d01 = (empty($usuario[43])) ? 0 : $usuario[43];
    $d02 = (empty($usuario[44])) ? null : $usuario[44];
    $d03 = (empty($usuario[45])) ? 0 : $usuario[45];
    $d04 = (empty($usuario[46])) ? null : $usuario[46];
    $d05 = (empty($usuario[47])) ? 0 : $usuario[47];
    $d06 = (empty($usuario[48])) ? 0 : $usuario[48];
    $d07 = (empty($usuario[49])) ? 0 : $usuario[49];
    $d08 = (empty($usuario[50])) ? 0 : $usuario[50];

    $db_1->Insert_nutricion($d01, $d02, $d03, $d04, $d05, $d06, $d07, $d08, $xCod); 

    // RUTINA PARA INSERTAR REGISTROS EN TABLA EDUCACION

    $d01 = (empty($usuario[51])) ? 0 : $usuario[51];
    $d02 = (empty($usuario[52])) ? 0 : $usuario[52];
    $d03 = (empty($usuario[53])) ? null : $usuario[53];
    $d04 = (empty($usuario[54])) ? 0 : $usuario[54];
    $d05 = (empty($usuario[55])) ? 0 : $usuario[55];
    $d06 = (empty($usuario[56])) ? 0 : $usuario[56];
    $d07 = (empty($usuario[57])) ? 0 : $usuario[57];
    $d08 = (empty($usuario[58])) ? null : $usuario[58];
    $d09 = (empty($usuario[59])) ? 0 : $usuario[59];
    $d10 = (empty($usuario[60])) ? 0 : $usuario[60];
    $d11 = (empty($usuario[61])) ? 0 : $usuario[61];
    $d12 = (empty($usuario[62])) ? 0 : $usuario[62];

    $db_1->Insert_educacion($d01, $d02, $d03, $d04, $d05, $d06, $d07, $d08, $d09, $d10, $d11, $d12, $xCod); 
    // RUTINA PARA INSERTAR REGISTROS EN TABLA SALUD

    $d01 = (empty($usuario[63])) ? null : $usuario[63];
    $d02 = (empty($usuario[64])) ? null : $usuario[64];
    $d03 = (empty($usuario[135])) ? null : $usuario[135];
    $d04 = (empty($usuario[136])) ? null : $usuario[136];

    $db_1->Insert_salud($d01, $d02, $d03, $d04, $xCod); 

    // RUTINA PARA INSERTAR REGISTROS EN TABLA derivacion_sectores

    $d01 = (empty($usuario[137])) ? 0 : $usuario[137];
    $d02 = (empty($usuario[138])) ? 0 : $usuario[138];
    $d03 = (empty($usuario[139])) ? 0 : $usuario[139];
    $d04 = (empty($usuario[140])) ? null : $usuario[140];
    $d05 = (empty($usuario[141])) ? 0 : $usuario[141];
    $d06 = (empty($usuario[142])) ? 0 : $usuario[142];

    $db_1->Insert_derivacion_sectores($d01, $d02, $d03, $d04, $d05, $d06, $xCod); 

    // RUTINA PARA INSERTAR REGISTROS EN TABLA estatus

    $d01 = (empty($usuario[144])) ? null : $usuario[144];
    $d02 = (empty($usuario[143])) ? null : $usuario[143];    
    
    $db_1->Insert_estatus($d01, $d02, $xCod);     

    // RUTINA PARA INSERTAR REGISTROS EN TABLA INTEGRANTES
    // INTEGRANTE 01
    $d01 = (empty($usuario[65])) ? null : $usuario[65];
    $d02 = (empty($usuario[66])) ? null : $usuario[66];
    $d03 = (empty($usuario[67])) ? null : $usuario[67];
    $d04 = (empty($usuario[68])) ? null : $usuario[68];
    $d05 = (empty($usuario[69])) ? null : $usuario[69];
    if (empty($usuario[70])) {
      $d06 = '1900/01/01';
    }else{
      $x = $db_1->validar_fecha_espanol($usuario[70]);
        $d06 = ($x) ?  $usuario[70] : '1900/01/01';
    }
    $d07 = (empty($usuario[71])) ? null : $usuario[71];
    $d08 = (empty($usuario[72])) ? null : $usuario[72];
    $d09 = (empty($usuario[73])) ? null : $usuario[73];
    $d10 = (empty($usuario[74])) ? null : $usuario[74];
    
    // INTEGRANTE 02
    $d11 = (empty($usuario[75])) ? null : $usuario[75];
    $d12 = (empty($usuario[76])) ? null : $usuario[76];
    $d13 = (empty($usuario[77])) ? null : $usuario[77];
    $d14 = (empty($usuario[78])) ? null : $usuario[78];
    $d15 = (empty($usuario[79])) ? null : $usuario[79];
    if (empty($usuario[80])) {
      $d16 = '1900/01/01';
    }else{
      $x = $db_1->validar_fecha_espanol($usuario[80]);
        $d16 = ($x) ?  $usuario[80] : '1900/01/01';
    }
    $d17 = (empty($usuario[81])) ? null : $usuario[81];
    $d18 = (empty($usuario[82])) ? null : $usuario[82];
    $d19 = (empty($usuario[83])) ? null : $usuario[83];
    $d20 = (empty($usuario[84])) ? null : $usuario[84];

    // INTEGRANTE 03
    $d21 = (empty($usuario[85])) ? null : $usuario[85];
    $d22 = (empty($usuario[86])) ? null : $usuario[86];
    $d23 = (empty($usuario[87])) ? null : $usuario[87];
    $d24 = (empty($usuario[88])) ? null : $usuario[88];
    $d25 = (empty($usuario[89])) ? null : $usuario[89];
    if (empty($usuario[90])) {
      $d26 = '1900/01/01';
    }else{
      $x = $db_1->validar_fecha_espanol($usuario[90]);
        $d26 = ($x) ?  $usuario[90] : '1900/01/01';
    }
    $d27 = (empty($usuario[91])) ? null : $usuario[91];
    $d28 = (empty($usuario[92])) ? null : $usuario[92];
    $d29 = (empty($usuario[93])) ? null : $usuario[93];
    $d30 = (empty($usuario[94])) ? null : $usuario[94];

    // INTEGRANTE 04
    $d31 = (empty($usuario[95])) ? null : $usuario[95];
    $d32 = (empty($usuario[96])) ? null : $usuario[96];
    $d33 = (empty($usuario[97])) ? null : $usuario[97];
    $d34 = (empty($usuario[98])) ? null : $usuario[98];
    $d35 = (empty($usuario[99])) ? null : $usuario[99];
    if (empty($usuario[100])) {
      $d36 = '1900/01/01';
    }else{
      $x = $db_1->validar_fecha_espanol($usuario[100]);
        $d36 = ($x) ?  $usuario[100] : '1900/01/01';
    }
    $d37 = (empty($usuario[101])) ? null : $usuario[101];
    $d38 = (empty($usuario[102])) ? null : $usuario[102];
    $d39 = (empty($usuario[103])) ? null : $usuario[103];
    $d40 = (empty($usuario[104])) ? null : $usuario[104];

    // INTEGRANTE 05
    $d41 = (empty($usuario[105])) ? null : $usuario[105];
    $d42 = (empty($usuario[106])) ? null : $usuario[106];
    $d43 = (empty($usuario[107])) ? null : $usuario[107];
    $d44 = (empty($usuario[108])) ? null : $usuario[108];
    $d45 = (empty($usuario[109])) ? null : $usuario[109];
    if (empty($usuario[110])) {
      $d46 = '1900/01/01';
    }else{
      $x = $db_1->validar_fecha_espanol($usuario[110]);
        $d46 = ($x) ?  $usuario[110] : '1900/01/01';
    }
    $d47 = (empty($usuario[111])) ? null : $usuario[111];
    $d48 = (empty($usuario[112])) ? null : $usuario[112];
    $d49 = (empty($usuario[113])) ? null : $usuario[113];
    $d50 = (empty($usuario[114])) ? null : $usuario[114];

    // INTEGRANTE 06
    $d51 = (empty($usuario[115])) ? null : $usuario[115];
    $d52 = (empty($usuario[116])) ? null : $usuario[116];
    $d53 = (empty($usuario[117])) ? null : $usuario[117];
    $d54 = (empty($usuario[118])) ? null : $usuario[118];
    $d55 = (empty($usuario[119])) ? null : $usuario[119];
    if (empty($usuario[120])) {
      $d56 = '1900/01/01';
    }else{
      $x = $db_1->validar_fecha_espanol($usuario[120]);
        $d56 = ($x) ?  $usuario[120] : '1900/01/01';
    }
    $d57 = (empty($usuario[121])) ? null : $usuario[121];
    $d58 = (empty($usuario[122])) ? null : $usuario[122];
    $d59 = (empty($usuario[123])) ? null : $usuario[123];
    $d60 = (empty($usuario[124])) ? null : $usuario[124];

    // INTEGRANTE 07
    $d61 = (empty($usuario[125])) ? null : $usuario[125];
    $d62 = (empty($usuario[126])) ? null : $usuario[126];
    $d63 = (empty($usuario[127])) ? null : $usuario[127];
    $d64 = (empty($usuario[128])) ? null : $usuario[128];
    $d65 = (empty($usuario[129])) ? null : $usuario[129];
    if (empty($usuario[130])) {
      $d66 = '1900/01/01';
    }else{
      $x = $db_1->validar_fecha_espanol($usuario[130]);
        $d66 = ($x) ?  $usuario[130] : '1900/01/01';
    }
    $d67 = (empty($usuario[131])) ? null : $usuario[131];
    $d68 = (empty($usuario[132])) ? null : $usuario[132];
    $d69 = (empty($usuario[133])) ? null : $usuario[133];
    $d70 = (empty($usuario[134])) ? null : $usuario[134];    

    $db_1->Insert_integrantes($d01, $d02, $d03, $d04, $d05, $d06, $d07, $d08, $d09, $d10, $d11, $d12, $d13, $d14, $d15, $d16, $d17, $d18, $d19, $d20, $d21, $d22, $d23, $d24, $d25, $d26, $d27, $d28, $d29, $d30, $d31, $d32, $d33, $d34, $d35, $d36, $d37, $d38, $d39, $d40, $d41, $d42, $d43, $d44, $d45, $d46, $d47, $d48, $d49, $d50, $d51, $d52, $d53, $d54, $d55, $d56, $d57, $d58, $d59, $d60, $d61, $d62, $d63, $d64, $d65, $d66, $d67, $d68, $d69, $d70, $xCod); 
  
  }

  $_delete = $db_1->limpiarTabla("SP_LimpiarTablaStage",$nombreUsuario);

  $var=true;
  if (!empty($var)) {        
    $type = "success";
    $message = "La migración se ha realizado con exito.";
  } else {
    $type = "error";
    $message = "Hubierón problemas al momento de la migración. Intente de nuevo";
  }

}

?>

<div class="col-md-12">

  <div class="card text-dark bg-light">
    <div class="card-header">
      Migrar datos de beneficiarios validados al proyecto actual
    </div>
    <div class="card-body">
      <form method="POST" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
        <div class="form-group">
          <label for="txtImagen">Este proceso realiza la migración de datos de nuevos beneficiarios del ambiente Stage a la tabla de Datos Históricos.</label>
          <br>
          <br>
          <label for="txtImagen">Este proceso borrará cualquier información existente en la tabla de Datos Históricos y la reemplazará con los nuevos datos.</label>
          <br>
          <br>
          <label for="txtImagen">Verificar si realmente desea ejecutar este proceso, ya que los datos eliminados no podrán ser recuperados.</label>
        </div>
        <br>
        <div class="btn-group" role="group" aria-label="Basic example">
          <button type="submit" id="submit" name="import" value="agregar" class="btn btn-success btn-lg">Migrar Datos Beneficiarios Validados</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="col-md-12">
  <div class=card-text>
    <div class="<?php if(!empty($type)) { echo $type . " alert alert-success role=alert"; } ?>"><?php if(!empty($var)) { echo $message; } ?>
  </div>
</div>
</div>

<?php include("../template/pie.php"); ?>