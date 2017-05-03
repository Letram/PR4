<?php
include_once('lib.php');
$res = new stdClass();
$res->exists=false;
$res->aux="";
$res->message='';
try{
    $datosCrudos = file_get_contents("php://input");
    $datos = json_decode($datosCrudos);
    
    $dbConn = DB::get();
    $query = $dbConn->prepare("select * from usuarios where cuenta=?;");
    if($query){
        $query->execute(array($datos->userName));
        if($query->fetchColumn() > 0)$res->exists=true;
    }
    
}catch(Exception $e){
    $res->message = $e->getMessage();
}
header('Content-Type: appplication/json');
echo json_encode($res);
?>