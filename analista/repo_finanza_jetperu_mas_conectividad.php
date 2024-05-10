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
  $usuarios = $db_1->select_repo_all("SP_reporte_recarga_jetperu_mas_bono", $codigo);

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setTitle("Users");
  $sheet->setCellValue("A1", "Refeplanilla");
  $sheet->setCellValue("B1", "agencia");
  $sheet->setCellValue("C1", "orden");  
  $sheet->setCellValue("D1", "fecha");
  $sheet->setCellValue("E1", "monto");
  $sheet->setCellValue("F1", "moneda");  
  $sheet->setCellValue("G1", "canalpago");  
  $sheet->setCellValue("H1", "agenciadestino");
  $sheet->setCellValue("I1", "apepatremite");
  $sheet->setCellValue("J1", "apematremite");
  $sheet->setCellValue("K1", "nombremite");
  $sheet->setCellValue("L1", "tipoidremite");
  $sheet->setCellValue("M1", "nroidremite");
  $sheet->setCellValue("N1", "nacionremite");
  $sheet->setCellValue("O1", "resideremite");
  $sheet->setCellValue("P1", "tlffijoremite");
  $sheet->setCellValue("Q1", "tlfmovilremite");
  $sheet->setCellValue("R1", "domicremite");
  $sheet->setCellValue("S1", "ciudadremite");
  $sheet->setCellValue("T1", "estadoremite");
  $sheet->setCellValue("U1", "apepatbenef");
  $sheet->setCellValue("V1", "apematbenef");
  $sheet->setCellValue("W1", "nombbenef");
  $sheet->setCellValue("X1", "tipoidbenef");
  $sheet->setCellValue("Y1", "nroidbenef");
  $sheet->setCellValue("Z1", "nacionbenef");
  $sheet->setCellValue("AA1", "residebenef");
  $sheet->setCellValue("AB1", "tlffijobenef");
  $sheet->setCellValue("AC1", "tlfmovilbenef");
  $sheet->setCellValue("AD1", "domicbenef");
  $sheet->setCellValue("AE1", "ciudadbenef");
  $sheet->setCellValue("AF1", "estadobenef");
  $sheet->setCellValue("AG1", "nombrebanco");
  $sheet->setCellValue("AH1", "cuentabanco");
  $sheet->setCellValue("AI1", "tipocuenta");
  $sheet->setCellValue("AJ1", "emailremite");
  $sheet->setCellValue("AK1", "emailbenef");
  $sheet->setCellValue("AL1", "codint");
  $sheet->setCellValue("AM1", "codseguim");
  $sheet->setCellValue("AN1", "numtjt");

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
    $sheet->setCellValue("AG".$i, $usuario[32]);
    $sheet->setCellValue("AH".$i, $usuario[33]);
    $sheet->setCellValue("AI".$i, $usuario[34]);
    $sheet->setCellValue("AJ".$i, $usuario[35]);
    $sheet->setCellValue("AK".$i, $usuario[36]);
    $sheet->setCellValue("AL".$i, $usuario[37]);
    $sheet->setCellValue("AM".$i, $usuario[38]);
    $sheet->setCellValue("AN".$i, $usuario[39]);

    $i++;
  }
  $writer = new Xlsx($spreadsheet);
  $fileName = "Reporte_recarga_jetperu_mas_conectividad_" . $timestamp1 . ".xlsx";
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
  header('Cache-Control: max-age=0');

  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
  $writer->save('php://output');  


/*}else{
  echo "<script>console.log('No entro: ' );</script>"; 
}*/
?>