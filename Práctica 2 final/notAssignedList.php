<?php
include_once('lib.php');
    if(User::isDealer()){
        $userID=$_GET['id'];
        View::Start("Repartidor");
        View::showNotAssignedOrders($userID);
        echo "<br><br><div class=\"centre\"><div class=\"button\"><a class=\"a\" href='repartIndex.php?id=".$userID."'>Volver</a></div></div>";

        View::end();    
    }
?>