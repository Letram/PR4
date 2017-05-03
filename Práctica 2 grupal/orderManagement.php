<?php
    include_once 'lib.php';
    if(User::isAdmin()){
        $userData=User::getLoggedUser();
        View::Start("Gestionar Pedidos");
        echo "<h1 class=\"A\">Bienvenido, ".$_SESSION['user']['nombre']."</h1>";
        echo "<ul class='navBar'>";
            echo "<li class='navBar'><a href='userManagement.php?id=".$userData['id']."'>Gestionar usuarios</a></li>";
            echo "<li class='navBar'><a href='orderManagement.php?id=".$userData['id']."'>Gestionar pedidos</a></li>";
            echo "<li class='navBar' id='logout'><a href='logout.php'> Cerrar sesión</a></li>";
            echo "<li class='navBar' id='logout'><a href='adminIndex.php?id=".$userData['id']."'>Volver</a></li>";
        echo "</ul>";
        echo "<br>";
        View::showDrinkTable(2);
        View::end();
    }
?>