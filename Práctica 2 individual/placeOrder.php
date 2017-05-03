<?php
    include_once('lib.php');
    if(User::isClient()){
        View::Start("Crear pedido");
        $userID=$_GET['id'];
        View::createOrderForm($userID);
        if (isset($_POST['submit'])){
            $res=DB::execute_sql('insert into pedidos (idcliente, horacreacion, poblacionentrega, direccionentrega, pvp) values (?, ?, ?, ?, ?);',
                                            array($userID, time(), User::getLoggedUser()['poblacion'], User::getLoggedUser()['direccion'], 0.0));
            $amount = $_POST['drinks'];
            $names = $_POST['names'];
            $ids = $_POST['ids'];
            $pvps = $_POST['pvps'];
            $totalPVP=0.0;
            $err=false;
            for ($i = 0; $i < count($amount); $i++) {
                $pvp=DB::getPVP($names[$i], $amount[$i]);
                if($pvp || $pvp == 0.0){
                    $totalPVP += $pvp;
                    $res=DB::execute_sql("select MAX(id) from pedidos;");
                    $res->setFetchMode(PDO::FETCH_NAMED);
                    $id=$res->fetchAll()[0];
                    $res=DB::execute_sql("insert into lineaspedido (idpedido, idbebida, unidades, pvp) values (?, ?, ?, ?);",
                                        array($id['MAX(id)'], $ids[$i], $amount[$i], $pvps[$i]));
                    $stockLeft=DB::getStockLeft($names[$i], $amount[$i]);
                    if($stockLeft){
                        $res=DB::execute_sql('update bebidas set stock=? where marca=?', array($stockLeft, $names[$i]));
                        if(!$res){
                            echo "ERROR";
                            $err=true;
                        }
                    }else{
                        $aux=$names[$i];
                        echo "<h2>ERROR AL CALCULAR EL STOCK RESTANTE DE $aux</h2>";
                        $err=true;
                    }
                }else{
                    $aux=$names[$i];
                    echo "<h2>ERROR AL CALCULAR EL PVP TOTAL DE $aux</h2>";
                    $err=true;
                }
            }
            $res=DB::execute_sql('update pedidos set pvp=? where id=(select max(id) from pedidos);', array($totalPVP));
            if($res && !$err){
                echo "<h1>PEDIDO REALIZADO</h1><br><a href='clientIndex.php?id=".$userID."'>Volver a inicio</a>";
            }else{
                echo "<h1>HA HABIDO UN PROBLEMA EN EL PEDIDO. POR FAVOR, REVISE LOS DATOS.</h1><br><a href='orderList.php?id= ".$userID."'>Ver pedidos.</a>";
            }
        }
        echo "<a href='orderList.php?id= ".$userID."'>Ver pedidos.</a>";
        View::end();
    }
?>
