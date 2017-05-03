<?php
include_once 'lib.php';
    if(User::isClient()){
        $userID=$_GET['id'];
        View::start("client");
        echo "<h1 class=\"A\">BIENVENIDO, CLIENTE".$userID."</h1>";
        echo "<ul class='navBar'>";
            echo "<li class='navBar'><a href='startOrder.php?id=".$userID."'>Realizar pedido</a></li>";
            echo "<li class='navBar'><a href='orderList.php?id=".$userID."'>Ver pedidos</a></li>";
            echo "<li class='navBar' id='logout'><a href='logout.php'> Cerrar sesión</a></li>";
        echo "</ul>";
        echo "<br>";
        View::showDrinkTable();
        View::end();
    }
?>
