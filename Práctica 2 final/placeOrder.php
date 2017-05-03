<?php
    include_once('lib.php');
    if(User::isClient()){
        View::Start("Crear pedido");
        $userID=$_GET['id'];
        $orderid=$_GET['orderid'];
        
        echo "<div class=\"centre\"><h1 class=\"A\">HACER PEDIDO</h1></div>";
        /*
        if(isset($_POST['add'])){

            $drinkid=$_POST['id'];
            $price=$_POST['price'];
            $amount=$_POST['cantidad'];
            
            $aux=DB::orderLineExists($orderid, $drinkid);
            if($aux || $aux == 0){
                DB::execute_sql("delete from lineaspedido where idbebida=? and idpedido=?", array($drinkid, $orderid));
                DB::updatePVP($orderid, $drinkid, $amount, $price*-1);
                DB::updateDrinkTable($drinkid, $aux*-1);
            }
            DB::execute_sql("insert into lineaspedido (idpedido, idbebida, unidades, PVP) values (?,?,?,?);", array($orderid, $drinkid, $amount, $price));
            DB::updatePVP($orderid, $drinkid, $amount, $price);
            DB::updateDrinkTable($drinkid, $amount);

        }
        */
        if(isset($_POST['endOrder'])){
            $totalPVP=0;
            $res = DB::execute_sql("select unidades, pvp from lineaspedido where idpedido=?;", array($orderid));
            $res->setFetchMode(PDO::FETCH_NAMED);
            foreach($res as $row){
                $totalPVP = $totalPVP + ($row['unidades']*$row['PVP']);
            }
            if(DB::execute_sql("update pedidos set horacreacion=?, poblacionentrega=?, direccionentrega=?, PVP=? where id=?", array(time(), $_POST['poblation'], $_POST['address'], $totalPVP, $orderid))){
                header('Location: orderDetails.php?id='.$orderid);
                //echo "<div class=\"centre\"><h2 class=\"a\">PEDIDO REALIZADO</h2></div>";
            }
        }
        /*
        if(isset($_POST['delete'])){
            print_r($_POST);
            DB::execute_sql("delete from lineaspedido where idbebida=? and idpedido=?", array($_POST['id'], $orderid));
            DB::updatePVP($orderid, $_POST['id'], $_POST['cantidad'], $_POST['price']*-1);
            DB::updateDrinkTable($_POST['id'], $_POST['cantidad']*-1);
        }
        */
        View::showDrinkTable(0, $orderid);
        View::showOrderDetails($orderid, 0);
        echo "<script src=\"scripts.js\"></script>";
        View::end();
    }
?>
