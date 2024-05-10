<?php
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once '../administrador/config/bdPDO.php';

$db_1 = new TransactionSCI();

require_once ('../vendor/autoload.php');

//if (isset($_POST['id'])) {
  //$codigo = 1;
  //$codigo = $_POST['id'];
  $codigo = $_GET['id'];
  $type = "OK";
  $dt = date('Y-m-d H:i:s');
  $timestamp1 = strtotime($dt);
  $usuarios = $db_1->select_repo_all("SP_reporte_recarga_tpp_mas_bono", $codigo);

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setTitle("Users");
  $sheet->setCellValue("A1", "Numero Documento");
  $sheet->setCellValue("B1", "Apellido Paterno");
  $sheet->setCellValue("C1", "Apellido Materno");  
  $sheet->setCellValue("D1", "Nombres");
  $sheet->setCellValue("E1", "Numero de Tarjeta");
  $sheet->setCellValue("F1", "Monto");  
  $sheet->setCellValue("G1", "Numero de Operacion");  

  $i = 2;
  foreach($usuarios as $usuario) {
    $sheet->setCellValue("A".$i, $usuario[0]);
    $sheet->setCellValue("B".$i, $usuario[1]);
    $sheet->setCellValue("C".$i, $usuario[2]);
    $sheet->setCellValue("D".$i, $usuario[3]);
    $sheet->setCellValue("E".$i, $usuario[4]);
    $sheet->setCellValue("F".$i, $usuario[5]);
    $sheet->setCellValue("G".$i, $usuario[6]);

    $i++;
  }
  $writer = new Xlsx($spreadsheet);
  $fileName = "Reporte_recarga_tpp_mas_conectividad_" . $timestamp1 . ".xlsx";
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
  header('Cache-Control: max-age=0');

  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
  $writer->save('php://output');  


/*}else{
  echo "<script>console.log('No entro: ' );</script>"; 
}*/
?>