<?php 
include('../administrador/config/connection.php');
$anio = $_POST['anio'];
$mes = $_POST['mes'];
$id = $_POST['id'];

$sql = "DELETE FROM finanzas_reporte_jetperu WHERE year(fecha) ='$anio' AND month(fecha)='$mes' ";

$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);

if($query==true)
{
  $data = array('status'=>'true',);
  echo json_encode($data);
}
else
{
   $data = array('status'=>'false',);
   echo json_encode($data);
} 

?>