<?php
include_once('lib.php');
    if(User::isDealer()){
        $userID=$_GET['id'];
        View::Start("Repartidor");
        View::showNotAssignedOrders($userID);
        echo "<br><a href='repartIndex.php?id=".$userID."'>Volver.</a>";

        View::end();    
    }
?>