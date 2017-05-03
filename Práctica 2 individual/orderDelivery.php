<?php
include_once ('lib.php');
    if(User::isDealer()){
        $orderID=$_GET['id'];
        $userData=User::getLoggedUser();
        $res=DB::execute_sql("update pedidos set horaentrega=? where id=?", array(time(), $orderID));
        if($res){
            View::start("Repartidor");
            echo "<h2>DATO ACTUALIZADO</h2>";
            echo "<a href='myOrders.php?id=".$userData['id']."'>Volver</a>";
            View::end();
        }
    }

?>