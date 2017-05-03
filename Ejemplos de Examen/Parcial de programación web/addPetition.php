<?php
include_once('lib.php');

$petitionDate = time();
$clientId = $_GET['clientId'];
$operatorId = User::getLoggedUser()['id'];

if(isset($_POST['problemManagement'])){
    $petition = $_POST['petition'];
    $reply = $_POST['reply'];
    $dbConn = DB::get();
    $query = $dbConn -> prepare("insert into atenciones(hora, cliente, operador, peticion, respuesta) values (?,?,?,?,?)");
    $query->execute(array($petitionDate, $clientId, $operatorId, $petition, $reply));
    
    if($query){
        header('Location:clientCallDetails.php?id='.$clientId);
        die;
    }else echo "Ha habido un error gestionando el problema.";
}
View::start("Gestión del problema");
View::showProblemManagementForm();
echo '<br><a href="clientCallDetails.php?id='.$clientId.'">Volver</a>';
View::end();
?>