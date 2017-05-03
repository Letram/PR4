<?php
include_once('lib.php');
	$res = new stdClass();
	$res->added = false; //Formato objeto con propiedad deleted (por defecto a false)
	$res->message = ''; //Mensaje en caso de error
	try {
	    $datoscrudos = file_get_contents("php://input"); //Leemos los datos
	    $datos = json_decode($datoscrudos);
	    $db = DB::execute_sql("insert into lineaspedido (idpedido, idbebida, unidades, PVP) values (?,?,?,?);", array(($datos->orderid), ($datos->idbebida), ($datos->unidades), ($datos->pvp)));
	    DB::updatePVP($datos->orderid, $datos->idbebida, $datos->unidades, $datos->pvp);
	    DB::updateDrinkTable($datos->idbebida, $datos->unidades);
	    $db = DB::execute_sql("select marca from bebidas where id=?;", array($datos->idbebida));
	    $db ->setFetchMode(PDO::FETCH_NAMED);
	    $res->marca = $db->fetchAll()[0]['marca'];
	    $res->added = true;
	} catch(Exception $e) {
	    $res->message = $e->getMessage(); //En caso de error se envia la información de error al navegador
	    $res->added = false;
	}
	header('Content-type: application/json');
	echo json_encode($res);
?>