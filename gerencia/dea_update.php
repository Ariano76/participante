<?php 
include('../administrador/config/connection.php');
$dea = $_POST['dea'];
$descripcion = $_POST['descripcion'];

$id = $_POST['id'];

$sql = "UPDATE `finanzas_dea` SET  `dea`= '$dea', `descripcion`='$descripcion'
   WHERE id_dea='$id' ";

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