<?php
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

//require_once './administrador/config/bd.php';
require_once './administrador/config/bdPDO.php';

$db_1 = new TransactionSCI();

require_once ('./vendor/autoload.php');

if (isset($_POST["import"])) {
  $depa = $_POST["selectdepa"];
  $type = "OK";
  $dt = date('Y-m-d H:i:s');
  $timestamp1 = strtotime($dt);
  //$db_1->cotejo($timestamp1);
  $usuarios = $db_1->select_repo_all("SP_Select_Finanzas", $depa);

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setTitle("Users");
  $sheet->setCellValue("A1", "Fecha Encuesta");
  $sheet->setCellValue("B1", "Región");
  $sheet->setCellValue("C1", "Provincia");  
  $sheet->setCellValue("D1", "Tipo de Transferencia");
  $sheet->setCellValue("E1", "Primer Nombre");
  $sheet->setCellValue("F1", "Segundo Nombre");
  $sheet->setCellValue("G1", "Primer Apellido");
  $sheet->setCellValue("H1", "Segundo Apellido");
  $sheet->setCellValue("I1", "Tipo de Identificación");
  $sheet->setCellValue("J1", "Número de identificación");
  $sheet->setCellValue("K1", "Número de WhatsApp");
  $sheet->setCellValue("L1", "Número de Teléfono Alternativo");
  $sheet->setCellValue("M1", "Direccion");
  $sheet->setCellValue("N1", "# de personas en la familia");
  $sheet->setCellValue("O1", "Usted cuenta con..");
  $sheet->setCellValue("P1", "¿Cómo accede a internet..?");
  $sheet->setCellValue("Q1", "¿Le interesaría y autoriza ser contactado a su celular con información de nutrición?");
  $sheet->setCellValue("R1", "Nutrición BONO");
  $sheet->setCellValue("S1", "IdBeneficiario");

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

    $i++;
  }
  $writer = new Xlsx($spreadsheet);
  $fileName = "Reporte_Finanzas_" . $timestamp1 . ".xlsx";
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
  header('Cache-Control: max-age=0');

  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
  $writer->save('php://output');  

}
?>