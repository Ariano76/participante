<?php include("../administrador/config/connection.php");

$output= array();
$sql = "SELECT @i := @i + 1 as contador, vf.mes, vf.anio, vf.total_registro FROM vista_finanzas_reporte_jetperu as vf cross join (select @i := 0) r";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(	
	0 => 'contador',
	1 => 'mes',
	2 => 'anio',
	3 => 'total_registro',
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE mes like '%".$search_value."%'";
	$sql .= " OR anio like '%".$search_value."%'";	
	$sql .= " OR total_registro like '%".$search_value."%'";	
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY contador asc";
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
	$sub_array[] = $row['contador'];	
	$sub_array[] = $row['mes'];
	$sub_array[] = $row['anio'];
	$sub_array[] = $row['total_registro'];	
	$sub_array[] = '<a href="#!;" data-id="'.$row['contador'].'" data-mes="'.$row['mes'].'" data-anio="'.$row['anio'].'" class="btn btn-info btn-sm deletebtn" style="text-align: center; display: inline-block; width: 100%; ">Borrar</a>';
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=> $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
