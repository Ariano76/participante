<?php 
include('../administrador/config/connection.php');
$asignacion = $_POST['asignacion'];

$id = $_POST['id'];

$sql = "UPDATE `finanzas_bono_conectividad` SET  `asignacion`= '$asignacion' 
WHERE id_conectividad='$id' ";

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