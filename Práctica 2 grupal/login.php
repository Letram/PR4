<?php
include_once('lib.php');
    View::start("Iniciar sesión");
    echo "<div class=\"log a\">";
    //Logueamos el usuario iniciando su sesión
    if(User::login($_POST['name'], $_POST['pass'])){
        /**
         * Conseguimos los datos del usuario con sesión abierta en forma de un
         * array asociativo [CampoDB] => [DatoDB].
         * */
        $userData = User::getLoggedUser();
        switch ($userData['tipo']) {
            case 1:
                echo "<a class=\"a\" href='adminIndex.php?id= ". $userData['id'] ."' >Haga click aquí para continuar</a>";
                break;
            case 2:
                echo "<a class=\"a\" href='clientIndex.php?id= ". $userData['id'] ."' >Haga click aquí para continuar</a>";
                break;
            default:
                echo "<a class=\"a\" href='repartIndex.php?id= ". $userData['id'] ."' >Haga click aquí para continuar</a>";
                break;
        }
    } else {
        echo "Ha ocurrido un error durante el proceso de login, por favor, haga click <a href=\"index.php\"><b>aquí</b></a> para continuar.";
    }
    echo "</div>";
    View::end();
?>