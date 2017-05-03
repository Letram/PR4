<?php
include_once('lib.php');
if(User::isDealer()){
        $userID=$_GET['delivid'];
        $orderID=$_GET['orderid'];
        $res=DB::execute_sql("update pedidos set idrepartidor=?, horaasignacion=? where id=?", (array($userID, time(), $orderID)));
        if($res->rowCount() == 1){
            View::start("nada");
            echo "<div class=\"centre\"><h2 class=\"A\">DATO ACTUALIZADO</h2>";
            echo "<br><div class=\"button\"><a class=\"a\" href='notAssignedList.php?id=".$userID."'>Volver</a></div></div>";
            View::end();
        }
}

?>