<?php
include_once ('lib.php');
    if(User::isDealer()){
        $orderID=$_GET['id'];
        $userData=User::getLoggedUser();
        $res=DB::execute_sql("update pedidos set horareparto=? where id=?", array(time(), $orderID));
        if($res){
            View::start("Repartidor");
            echo "<div class=\"centre\"><h2 class=\"A\">DATO ACTUALIZADO</h2>";
            echo "<br><div class=\"button\"><a class=\"a\" href='myOrders.php?id=".$userData['id']."'>Volver</a></div></div>";
            View::end();
        }
    }
    
?>