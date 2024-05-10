<?php include("../administrador/template/cabecera.php"); ?>

<?php
use Phppot\DataSource;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

require_once '../administrador/config/bd.php';
require_once '../administrador/config/bdPDO.php';
$db = new DataSource();
$conn = $db->getConnection();

$db_1 = new TransactionSCI();
$conn_1 = $db_1->Connect();

//echo $insertId;

require_once ('../vendor/autoload.php');

if (isset($_POST["import"])) {

    //limpiar tabla stage
    

  $allowedFileType = [
    'application/vnd.ms-excel', 'text/xls', 'text/xlsx',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
  ];

  if (in_array($_FILES["file"]["type"], $allowedFileType)) {

    $targetPath = '../uploads/' . $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

    $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    $spreadSheet = $Reader->load($targetPath);
    $excelSheet = $spreadSheet->getActiveSheet();
    $spreadSheetAry = $excelSheet->toArray();
    $sheetCount = count($spreadSheetAry);

    //$insertId = $db_1->ejecutarstoredprocedure("SP_limpiar_stage_gastos");
    $conta=0;
    //for ($i = 0; $i <= $sheetCount; $i ++) {
    for ($i = 1; $i < $sheetCount; $i ++) {
        $dato_01 = "";
        if (isset($spreadSheetAry[$i][0])) {
            $dato_01  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][0]); }
        $dato_02 = "";
        if (isset($spreadSheetAry[$i][1])) {
            $dato_02  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][1]); }

      if ( !empty($dato_01) || !empty($dato_02) ) {
        $query = "insert into finanzas_dea(dea, descripcion) values(?, ?)";
        $paramType = "ss";
        $paramArray = array($dato_01, $dato_02);
        $insertId = $db->insert($query, $paramType, $paramArray);
        $conta++;

        if (! empty($insertId)) {        
          $type = "success";
          $message = "Datos importados de Excel a la Base de Datos: ".$conta." registros.";
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
      Cargar DEA multiples
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


<?php include("../administrador/template/pie.php"); ?>