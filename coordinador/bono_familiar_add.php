<?php 
include('../administrador/config/connection.php');
$asignacion = $_POST['asignacion'];

$sql = "INSERT INTO `finanzas_bono_familiar` (`asignacion`) values ('$asignacion')";
$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
if($query ==true)
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