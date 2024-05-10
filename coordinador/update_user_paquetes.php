<?php 
include('../administrador/config/connection.php');
$id_estado = $_POST['id_estado'];
$observaciones = $_POST['observaciones'];

$id = $_POST['id'];

date_default_timezone_set('America/Lima');
$fechaActual = date('Y-m-d H:i:s');

$sql = "UPDATE `finanzas_paquete_aprobacion` SET `id_estado`='$id_estado', `fecha_aprobacion`='$fechaActual', `observaciones`='$observaciones' WHERE id_paquete='$id' ";

$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);

if($query==true)
{
    $data = array(
        'status'=>'true',
    );
    echo json_encode($data);
}
else
{
   $data = array(
    'status'=>'false',
);
   echo json_encode($data);
} 

?>