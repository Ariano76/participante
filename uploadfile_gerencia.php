<?php include("administrador/template/cabecera.php"); ?>

<?php
use Phppot\DataSource;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

require_once './administrador/config/bd.php';
require_once './administrador/config/bdPDO.php';
$db = new DataSource();
$conn = $db->getConnection();

$db_1 = new TransactionSCI();
$conn_1 = $db_1->Connect();

//echo $insertId;

require_once ('./vendor/autoload.php');

if (isset($_POST["import"])) {

    //limpiar tabla stage
    

  $allowedFileType = [
    'application/vnd.ms-excel', 'text/xls', 'text/xlsx',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
  ];

  if (in_array($_FILES["file"]["type"], $allowedFileType)) {

    $targetPath = 'uploads/' . $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

    $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    $spreadSheet = $Reader->load($targetPath);
    $excelSheet = $spreadSheet->getActiveSheet();
    $spreadSheetAry = $excelSheet->toArray();
    $sheetCount = count($spreadSheetAry);

    $insertId = $db_1->limpiarStageDataProyecto("SP_LimpiarTablaStage_dataproyecto");
    $conta=0;
    //echo "<script>console.log('Numero de hojas: " . $sheetCount . "' );</script>"; 
    //for ($i = 0; $i <= $sheetCount; $i ++) {
    for ($i = 1; $i < $sheetCount; $i ++) {
        $dato_01 = "";
        if (isset($spreadSheetAry[$i][0])) {
            $dato_01  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][0]); }
        $dato_02 = "";
        if (isset($spreadSheetAry[$i][1])) {
            $dato_02  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][1]); }
        $dato_03 = "";
        if (isset($spreadSheetAry[$i][2])) {
            $dato_03  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][2]); }
        $dato_04 = "";
        if (isset($spreadSheetAry[$i][3])) {
            $dato_04  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][3]); }
        $dato_05 = "";
        if (isset($spreadSheetAry[$i][4])) {
            $dato_05  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][4]); }
        $dato_06 = "";
        if (isset($spreadSheetAry[$i][5])) {
            $dato_06  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][5]); }
        $dato_07 = "";
        if (isset($spreadSheetAry[$i][6])) {
            $dato_07  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][6]); }
        $dato_08 = "";
        if (isset($spreadSheetAry[$i][7])) {
            $dato_08  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][7]); }
        $dato_09 = "";
        if (isset($spreadSheetAry[$i][8])) {
            $dato_09  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][8]); }
        $dato_10 = "";
        if (isset($spreadSheetAry[$i][9])) {
            $dato_10  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][9]); }
        $dato_11 = "";
        if (isset($spreadSheetAry[$i][10])) {
            $dato_11  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][10]); }
        $dato_12 = "";
        if (isset($spreadSheetAry[$i][11])) {
            $dato_12  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][11]); }
        $dato_13 = "";
        if (isset($spreadSheetAry[$i][12])) {
            $dato_13  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][12]); }
        $dato_14 = "";
        if (isset($spreadSheetAry[$i][13])) {
            $dato_14  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][13]); }
        $dato_15 = "";
        if (isset($spreadSheetAry[$i][14])) {
            $dato_15  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][14]); }
        $dato_16 = "";
        if (isset($spreadSheetAry[$i][15])) {
            $dato_16  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][15]); }
        $dato_17 = "";
        if (isset($spreadSheetAry[$i][16])) {
            $dato_17  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][16]); }
        $dato_18 = "";
        if (isset($spreadSheetAry[$i][17])) {
            $dato_18  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][17]); }
        $dato_19 = "";
        if (isset($spreadSheetAry[$i][18])) {
            $dato_19  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][18]); }
        $dato_20 = "";
        if (isset($spreadSheetAry[$i][19])) {
            $dato_20  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][19]); }
        $dato_21 = "";
        if (isset($spreadSheetAry[$i][20])) {
            $dato_21  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][20]); }
        $dato_22 = "";
        if (isset($spreadSheetAry[$i][21])) {
            $dato_22  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][21]); }
        $dato_23 = "";
        if (isset($spreadSheetAry[$i][22])) {
            $dato_23  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][22]); }
        $dato_24 = "";
        if (isset($spreadSheetAry[$i][23])) {
            $dato_24  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][23]); }
        $dato_25 = "";
        if (isset($spreadSheetAry[$i][24])) {
            $dato_25  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][24]); }
        $dato_26 = "";
        if (isset($spreadSheetAry[$i][25])) {
            $dato_26  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][25]); }
        $dato_27 = "";
        if (isset($spreadSheetAry[$i][26])) {
            $dato_27  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][26]); }
        $dato_28 = "";
        if (isset($spreadSheetAry[$i][27])) {
            $dato_28  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][27]); }
        $dato_29 = "";
        if (isset($spreadSheetAry[$i][28])) {
            $dato_29  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][28]); }
        $dato_30 = "";
        if (isset($spreadSheetAry[$i][29])) {
            $dato_30  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][29]); }
        $dato_31 = "";
        if (isset($spreadSheetAry[$i][30])) {
            $dato_31  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][30]); }
        $dato_32 = "";
        if (isset($spreadSheetAry[$i][31])) {
            $dato_32  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][31]); }
        $dato_33 = "";
        if (isset($spreadSheetAry[$i][32])) {
            $dato_33  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][32]); }
        $dato_34 = "";
        if (isset($spreadSheetAry[$i][33])) {
            $dato_34  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][33]); }
        $dato_35 = "";
        if (isset($spreadSheetAry[$i][34])) {
            $dato_35  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][34]); }
      
      if (
        ! empty($dato_01) || ! empty($dato_02) || ! empty($dato_03) || ! empty($dato_04) || ! empty($dato_05) || ! empty($dato_06) || ! empty($dato_07) || ! empty($dato_08) || ! empty($dato_09) || ! empty($dato_10) || ! empty($dato_11) || ! empty($dato_12) || ! empty($dato_13) || ! empty($dato_14) || ! empty($dato_15) || ! empty($dato_16) || ! empty($dato_17) || ! empty($dato_18) || ! empty($dato_19) || ! empty($dato_20) || ! empty($dato_21) || ! empty($dato_22) || ! empty($dato_23) || ! empty($dato_24) || ! empty($dato_25) || ! empty($dato_26) || ! empty($dato_27) || ! empty($dato_28) || ! empty($dato_29) || ! empty($dato_30) || ! empty($dato_31) || ! empty($dato_32) || ! empty($dato_33) || ! empty($dato_34) || ! empty($dato_35) ) {
        $query = "insert into stage_data_proyectos (dato_01, dato_02, dato_03, dato_04, dato_05, dato_06, dato_07, dato_08, dato_09, dato_10, dato_11, dato_12, dato_13, dato_14, dato_15, dato_16, dato_17, dato_18, dato_19, dato_20, dato_21, dato_22, dato_23, dato_24, dato_25, dato_26, dato_27, dato_28, dato_29, dato_30, dato_31, dato_32, dato_33, dato_34, dato_35) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $paramType = "sssssssssssssssssssssssssssssssssss";
        $paramArray = array(
          $dato_01, $dato_02, $dato_03, $dato_04, $dato_05, $dato_06, $dato_07, $dato_08, $dato_09, $dato_10, $dato_11, $dato_12, $dato_13, $dato_14, $dato_15, $dato_16, $dato_17, $dato_18, $dato_19, $dato_20, $dato_21, $dato_22, $dato_23, $dato_24, $dato_25, $dato_26, $dato_27, $dato_28, $dato_29, $dato_30, $dato_31, $dato_32, $dato_33, $dato_34, $dato_35
        );
        $insertId = $db->insert($query, $paramType, $paramArray);
        $conta++;

        if (! empty($insertId)) {        
          $type = "success";
          $message = "Datos importados de Excel a la Base de Datos: ".$conta." registros.";
          $_SESSION['validaciongerencia'] = '0';
        } else {
          $type = "error";
          $message = "Problemas al importar los datos de Excel. Intente de nuevo";
        }
      }
    }

  } else {
    $type = "error";
    $message = "El tipo de archivo seleccionado es invalido. Solo puede subir archivos de Excel.";
  }
}
?>

<div class="col-md-12">

  <div class="card text-dark bg-light">
    <div class="card-header">
      Datos de los Proyectos en ejecución.
    </div>
    <div class="card-body">
      <form method="POST" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
        <div class="form-group">
          <label for="txtImagen">Seleccione el archivo Excel a cargar:</label>
          <br>
          <br>
          <input type="file" class="form-control" name="file" id="file" accept=".xls,.xlsx"> 
        </div>
        <br>
        <div class="btn-group" role="group" aria-label="Basic example">
          <button type="submit" id="submit" name="import" value="agregar" class="btn btn-success btn-lg">Importar registros</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="col-md-12">
  <div class=card-text>
      <div class="<?php if(!empty($type)) { echo $type . " alert alert-success role=alert"; } ?>"><?php if(!empty($message)) { echo $message; } ?>
      </div>
  </div>
</div>


<?php include("administrador/template/pie.php"); ?>