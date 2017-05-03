<?php
include_once("lib.php");

    $res = new stdClass();
    $res->deleted=false; //Formato objeto con propiedad deleted (por defecto a false)
    $res->message=''; //Mensaje en caso de error
    try{
        $datoscrudos = file_get_contents("php://input"); //Leemos los datos
        $datos = json_decode($datoscrudos);
        $db = DB::execute_sql("delete from lineaspedido where idbebida=? and idpedido=?", array($datos->drinkid, $datos->orderid));
        if($db->rowCount()>0){
            $res->deleted=true;
        }
        DB::updatePVP($datos->orderid, $datos->drinkid, $datos->amount, ($datos->pvp)*-1);
        DB::updateDrinkTable($datos->drinkid, ($datos->amount)*-1);
    }catch(Exception $e){
       $res->message=$e->getMessage(); //En caso de error se envia la información de error al navegador
    }
    header('Content-type: application/json');
    echo json_encode($res);
?>