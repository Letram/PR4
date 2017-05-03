<?php
include_once 'lib.php';
    if(User::isDealer()){
        $userID=$_GET['id'];
        View::start("Repartidor");
        echo "<h1>BIENVENIDO, ".$_SESSION['user']['nombre']."</h1>";
        echo "<ul class='navBar'>";
            echo "<li class='navBar'><a href='notAssignedList.php?id=".$userID."'>Pedidos no asignados</a></li>";
            echo "<li class='navBar'><a href='myOrders.php?id= ".$userID."'>Mis pedidos</a></li>";
            echo "<li class='navBar' id='logout'><a href='logout.php'> Cerrar sesión</a></li>";
        echo "</ul>";
        View::end();
    }

?>