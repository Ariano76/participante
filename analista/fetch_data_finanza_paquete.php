<?php include("../administrador/config/connection.php");

$output= array();
$sql = "SELECT * FROM vista_finanzas_paquetes_aprobados";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(	
	0 => 'id_paquete',
	1 => 'fecha_envio',
	2 => 'estado_aprobacion',
	3 => 'fecha_aprobacion',
	4 => 'numero_beneficiarios',	
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE id_paquete like '%".$search_value."%'";
	$sql .= " OR fecha_envio like '%".$search_value."%'";	
	$sql .= " OR fecha_aprobacion like '%".$search_value."%'";	
	$sql .= " OR estado_aprobacion like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY id_paquete desc";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$query = mysqli_query($con,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while($row = mysqli_fetch_assoc($query))
{
	$sub_array = array();
	$sub_array[] = $row['id_paquete'];	
	$sub_array[] = $row['fecha_envio'];
	$sub_array[] = $row['estado_aprobacion'];
	$sub_array[] = $row['fecha_aprobacion'];
	$sub_array[] = $row['numero_beneficiarios'];
	$sub_array[] = '<a href="#!;" data-id="'.$row['id_paquete'].'" class="btn btn-info btn-sm jetperubtn" style="text-align: center; display: inline-block; width: 100%; ">JET PERU</a>';
	$sub_array[] = '<a href="#!;" data-id="'.$row['id_paquete'].'" class="btn btn-info btn-sm jetperubonobtn" style="text-align: center; display: inline-block; width: 100%; ">JET+Bono</a>';
	$sub_array[] = '<a href="#!;" data-id="'.$row['id_paquete'].'" class="btn btn-info btn-sm tppbtn" style="text-align: center; display: inline-block; width: 100%; ">TPP</a>';
	$sub_array[] = '<a href="#!;" data-id="'.$row['id_paquete'].'" class="btn btn-info btn-sm tppbonobtn" style="text-align: center; display: inline-block; width: 100%; ">TPP+Bono</a>';
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=> $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
