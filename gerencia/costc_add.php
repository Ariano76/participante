<?php 
include('../administrador/config/connection.php');
$cod_costc = $_POST['cod_costc'];
$descripcion = $_POST['descripcion'];

$sql = "INSERT INTO `finanzas_costc` (`cod_costc`,`descripcion`) values ('$cod_costc', '$descripcion' )";
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