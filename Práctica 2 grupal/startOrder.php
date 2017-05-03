<?php
include_once ('lib.php');

    $id=$_GET['id'];
    
    $res=DB::execute_sql("insert into pedidos (idcliente, horacreacion) values (?, ?);", array($id, 0));
    $res=DB::execute_sql("select MAX(id) from pedidos;");
    $res->setFetchMode(PDO::FETCH_NAMED);
    $orderid=$res->fetchAll()[0]['MAX(id)'];
    if($res){
        View::start("Empezar pedido");
        header("Location:placeOrder.php?id=".$id."&orderid=".$orderid);
        View::end();
    }else{
        View::start("Empezar pedido");
        echo "<h1>ERROR</h1>";
        echo "<br><a href='clientIndex.php?id=".$id."'>Volver</a>";
        View::end();
    }
?>