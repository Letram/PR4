<?php
include_once('lib.php');
    View::start("Iniciar sesión");

    //Logueamos el usuario iniciando su sesión
    if(User::login($_POST['name'], $_POST['pass'])){
        /**
         * Conseguimos los datos del usuario con sesión abierta en forma de un
         * array asociativo [CampoDB] => [DatoDB].
         * */
        $userData = User::getLoggedUser();
        switch ($userData['tipo']) {
            case 1:
                echo "<a href='adminIndex.php?id= ". $userData['id'] ."' >Click aquí</a>";
                break;
            case 2:
                echo "<a href='clientIndex.php?id= ". $userData['id'] ."' >Click aquí</a>";
                break;
            default:
                echo "<a href='repartIndex.php?id= ". $userData['id'] ."' >Click aquí</a>";
                break;
        }
    } else {
        echo '<h1> ERROR </h1><a href="index.php"> Volver </a>';
    }
    View::end();
?>