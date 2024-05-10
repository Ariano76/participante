<?php 
include('../administrador/config/connection.php');
$cod_costc = $_POST['cod_costc'];
$descripcion = $_POST['descripcion'];

$id = $_POST['id'];

$sql = "UPDATE `finanzas_costc` SET  `cod_costc`= '$cod_costc', `descripcion`='$descripcion'
   WHERE id_costc='$id' ";

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