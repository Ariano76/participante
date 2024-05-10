<?php

require_once '../config/bdPDO.php';
$db_1 = new TransactionSCI();
$codigo = $_POST['empid'];
//include_once("db_connect.php");

if($_POST['empid']) {

	if ($_POST['accion'] == 0) {
		$resultset = $db_1->delete_usuario($codigo);
		if($resultset) {
			echo 1;
		}
	}

	if ($_POST['accion'] == 1) {
		$resultset = $db_1->update_password($codigo,$_POST['clave']);
		if($resultset) {
			echo 1;
		}

	}
}
?>
