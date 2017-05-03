<?php
include_once 'lib.php';
    if(User::isDealer()){
        $userID=$_GET['id'];
        View::start("Repartidor");
        echo '<a href="logout.php" class="button"> Cerrar sesión</a>';
        echo "<a href='notAssignedList.php?id=".$userID."'>Pedidos no asignados</a>";
        echo "<br><a href='myOrders.php?id= ".$userID."'>Mis pedidos</a>";
        View::end();
    }

?>