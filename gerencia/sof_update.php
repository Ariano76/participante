<?php 
include('../administrador/config/connection.php');
$sof = $_POST['sof'];
$descripcion = $_POST['descripcion'];

$id = $_POST['id'];

$sql = "UPDATE `finanzas_sof` SET  `cod_sof`= '$sof', `descripcion`='$descripcion'
   WHERE id_sof='$id' ";

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