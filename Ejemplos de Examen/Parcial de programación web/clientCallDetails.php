<?php
//TODO
include_once('lib.php');
$clientId = $_GET['id'];

View::start("Detalles");
View::showCallDetailsForClient($clientId);

echo '<a href="addPetition.php?clientId='.$clientId.'">Añadir gestión del problema.</a>';
View::end();
?>