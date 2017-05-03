<?php
include_once 'lib.php';
    if(User::isClient()){
        $userID=$_GET['id'];
        View::start("client");
        View::showDrinkTable();
        echo "<a href='placeOrder.php?id=" . $userID . "'>Realizar pedido</a><br><a href='orderList.php?id= ". $userID ."'>Ver pedidos.</a>";
        echo '<brb><a href="logout.php" class="button"> Cerrar sesión</a>';

        View::end();
    }
?>
