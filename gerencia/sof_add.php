<?php 
include('../administrador/config/connection.php');
$sof = $_POST['sof'];
$descripcion = $_POST['descripcion'];

$sql = "INSERT INTO `finanzas_sof` (`cod_sof`,`descripcion`) values ('$sof', '$descripcion' )";
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