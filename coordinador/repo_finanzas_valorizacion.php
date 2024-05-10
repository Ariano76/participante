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
  //echo "<script>console.log('Codigo: " . $codigo . "' );</script>"; 
  
  $type = "OK";
  $dt = date('Y-m-d H:i:s');
  $timestamp1 = strtotime($dt);
  //$db_1->cotejo($timestamp1);
  $usuarios = $db_1->select_repo_all("SP_reporte_finanzas_valorizacion", $codigo);

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setTitle("Users");
  $sheet->setCellValue("A1", "Id_Beneficiario");
  $sheet->setCellValue("B1", "Id_Paquete");
  $sheet->setCellValue("C1", "Estado Aprobacion");  
  $sheet->setCellValue("D1", "Fecha Encuesta");
  $sheet->setCellValue("E1", "Región");
  $sheet->setCellValue("F1", "Provincia");  
  $sheet->setCellValue("G1", "Distrito");  
  $sheet->setCellValue("H1", "Tipo de Transferencia");
  $sheet->setCellValue("I1", "Primer Nombre");
  $sheet->setCellValue("J1", "Segundo Nombre");
  $sheet->setCellValue("K1", "Primer Apellido");
  $sheet->setCellValue("L1", "Segundo Apellido");
  $sheet->setCellValue("M1", "Tipo de Identificación");
  $sheet->setCellValue("N1", "Número de identificación");
  $sheet->setCellValue("O1", "Documento Fisico y Original");
  $sheet->setCellValue("P1", "Número de WhatsApp");
  $sheet->setCellValue("Q1", "Número de Teléfono Alternativo");
  $sheet->setCellValue("R1", "Direccion");
  $sheet->setCellValue("S1", "# de personas en la familia");
  $sheet->setCellValue("T1", "¿Le interesaría y autoriza ser contactado a su celular con información de nutrición?");
  $sheet->setCellValue("U1", "Nutrición BONO");
  $sheet->setCellValue("V1", "¿Cómo accede a internet..?");
  $sheet->setCellValue("W1", "Usted cuenta con..");
  $sheet->setCellValue("X1", "Bono Conectividad");
  $sheet->setCellValue("Y1", "Fecha Estadia 1");
  $sheet->setCellValue("Z1", "Importe Estadia 1");
  $sheet->setCellValue("AA1", "Fecha Estadia 2");
  $sheet->setCellValue("AB1", "Importe Estadia 2");
  $sheet->setCellValue("AC1", "Fecha Estadia 3");
  $sheet->setCellValue("AD1", "Importe Estadia 3");
  $sheet->setCellValue("AE1", "Fecha Estadia 4");
  $sheet->setCellValue("AF1", "Importe Estadia 4");

  $i = 2;
  foreach($usuarios as $usuario) {
    $sheet->setCellValue("A".$i, $usuario[0]);
    $sheet->setCellValue("B".$i, $usuario[1]);
    $sheet->setCellValue("C".$i, $usuario[2]);
    $sheet->setCellValue("D".$i, $usuario[3]);
    $sheet->setCellValue("E".$i, $usuario[4]);
    $sheet->setCellValue("F".$i, $usuario[5]);
    $sheet->setCellValue("G".$i, $usuario[6]);
    $sheet->setCellValue("H".$i, $usuario[7]);
    $sheet->setCellValue("I".$i, $usuario[8]);
    $sheet->setCellValue("J".$i, $usuario[9]);
    $sheet->setCellValue("K".$i, $usuario[10]);
    $sheet->setCellValue("L".$i, $usuario[11]);
    $sheet->setCellValue("M".$i, $usuario[12]);
    $sheet->setCellValue("N".$i, $usuario[13]);
    $sheet->setCellValue("O".$i, $usuario[14]);
    $sheet->setCellValue("P".$i, $usuario[15]);
    $sheet->setCellValue("Q".$i, $usuario[16]);
    $sheet->setCellValue("R".$i, $usuario[17]);
    $sheet->setCellValue("S".$i, $usuario[18]);
    $sheet->setCellValue("T".$i, $usuario[19]);
    $sheet->setCellValue("U".$i, $usuario[20]);
    $sheet->setCellValue("V".$i, $usuario[21]);
    $sheet->setCellValue("W".$i, $usuario[22]);
    $sheet->setCellValue("X".$i, $usuario[23]);
    $sheet->setCellValue("Y".$i, $usuario[24]);
    $sheet->setCellValue("Z".$i, $usuario[25]);
    $sheet->setCellValue("AA".$i, $usuario[26]);
    $sheet->setCellValue("AB".$i, $usuario[27]);
    $sheet->setCellValue("AC".$i, $usuario[28]);
    $sheet->setCellValue("AD".$i, $usuario[29]);
    $sheet->setCellValue("AE".$i, $usuario[30]);
    $sheet->setCellValue("AF".$i, $usuario[31]);

    $i++;
  }
  $writer = new Xlsx($spreadsheet);
  $fileName = "Reporte_Finanzas_Valorizacion_" . $timestamp1 . ".xlsx";
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
  header('Cache-Control: max-age=0');

  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
  $writer->save('php://output');  


/*}else{
  echo "<script>console.log('No entro: ' );</script>"; 
}*/
?>