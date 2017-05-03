<?php
class View{
    public static function  start($title){
        $html = "<!DOCTYPE html>
<html>
<head>
<meta charset=\"utf-8\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
<script src=\"scripts.js\"></script>
<title>$title</title>
</head>
<body>";
        User::session_start();
        echo $html;
    }
    public static function navigation(){
        echo '<nav>';
        echo '</nav>';
    }
    public static function end(){
        echo '</body>
</html>';
    }
    
    
    public static function loginForm(){
        $form= "<div class=\"log\">
            <form class=\"a\" method=\"post\" action=\"login.php\">
                Name:<br><input class=\"inputText\" type=\"text\" name=\"name\">
                <br><br>
                Password:<br><input class=\"inputText\" type=\"password\" name=\"pass\">
                <br><br>
                <input class=\"button\" type=\"submit\" name=\"login\" value=\"Login\">  
            </form>
        </div>";

    echo $form;
    }
    
    public static function adminUserTable(){
        $res=DB::execute_sql("select * from usuarios;");
        //Ejemplo de lectura de tabla
        
        echo "<div class=\"centre\"><a href=\"createUser.php\" class=\"button\" id=\"send\"> Crear usuario </a></div>";
        
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            foreach($res as $table_row){
                if($first){
                    echo "<table class=\"a\"><tr>";
                    foreach($table_row as $tableRow_index=>$tableRow_Data){
                        if($tableRow_index != 'id' && $tableRow_index != 'clave'){
                            if($tableRow_index == 'idcliente')echo "<th>Nombre Cliente</th>";
                            else echo "<th>$tableRow_index</th>";
                        }
                    }
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                foreach($table_row as $tableRow_index => $tableRow_Data){
                    if($tableRow_index != 'id' && $tableRow_index != 'clave')echo "<td>$tableRow_Data</td>";
                }
                echo "<td><a class=\"smallButton\" href='modifyUser.php?id=" . $table_row['id'] . "'> Editar </a></td><br><td><a class=\"smallButton\" href='deleteUser.php?id=" . $table_row['id'] . "'>Borrar</a></td>";
                echo "</tr>";
            }
            echo '</table>';
        }
    }
    public static function createUserForm(){
        echo "<form id='userForm' action=\"\" method=\"post\" onsubmit=\"return formValidation()\">
                <div class=\"log a\">
                    <strong>Usuario: *</strong> <input id='user' class=\"inputText\" type=\"text\" name=\"user\"><p id='userError' class='error'></p><br/>
                    
                    <strong>Clave: *</strong> <input id='pass' class=\"inputText\" type=\"password\" name=\"pass\"><p id='passError' class='error'></p><br/>
                    
                    <strong>Nombre: *</strong> <input id='name' class=\"inputText\" type=\"text\" name=\"name\"><p id='nameError' class='error'></p><br/>
                    
                    <strong>Tipo: *</strong> <input id='type' class=\"inputText\" id='type' type=\"number\" name=\"type\" min=\"1\" max=\"3\" onblur=\"checkType()\" required><br/>
                    
                    <div id = 'localidad'>
                        <strong>Población: </strong> <input class=\"inputText\" type=\"text\" name=\"pob\"/><br/>
                        
                        <strong>Dirección: </strong> <input class=\"inputText\" type=\"text\" name=\"addr\"/><br/>
                    </div>
                    <p>* required</p>
                    
                    <input class=\"button\" type=\"submit\" name=\"submit\" value=\"Guardar\">
                </div>
            </form>";
    }
    public static function editUserForm($user, $pass, $name, $type, $pob, $addr){
                echo "<form action=\"\" method=\"post\">
                <div class=\"log a\">
                    <strong>Usuario: *</strong> <input class=\"inputText\" type=\"text\" name=\"user\" value=\"$user\"/ required><br/>
                    
                    <strong>Clave: *</strong> <input class=\"inputText\" type=\"password\" name=\"pass\" value=\"$pass\"/ required><br/>
                    
                    <strong>Nombre: *</strong> <input class=\"inputText\" type=\"text\" name=\"name\" value=\"$name\"/ required><br/>
                    
                    <strong>Tipo: *</strong> <input class=\"inputText\" type=\"number\" name=\"type\" min=\"1\" max=\"3\" value=\"$type\" required/><br/>
                    
                    <strong>Población: </strong> <input class=\"inputText\" type=\"text\" name=\"pob\" value=\"$pob\"/><br/>
                    
                    <strong>Dirección: </strong> <input class=\"inputText\" type=\"text\" name=\"addr\" value=\"$addr\"/><br/>
                    <p>* required</p>
                    
                    <input class=\"button\" type=\"submit\" name=\"submit\" value=\"Submit\">
                </div>
            </form>";
    }
    
    public static function showDrinkTable($opt=1, $orderid=0){
        $res=DB::execute_sql('select id, marca, stock, pvp from bebidas');
        $res->setFetchMode(PDO::FETCH_NAMED);
        $first=true;
        $i=0;
        echo '<table><tr>';
        foreach ($res as $table_row) {
            
            if($first){
                $first=false;
                foreach ($table_row as $row_index => $row_data) {
                    if($row_index != 'id')echo "<th>$row_index</th>";
                }
            }
            echo '</tr>';
            echo '<tr>';
            foreach ($table_row as $row_index => $row_data) {
                if($row_index != 'id')echo "<td>$row_data</td>";
            }
            if($opt == 0 || $opt == 2){
                
                echo "<td><input class='inputText' id='cantidad".$i."' type='number' value='0' min='0' max='".$table_row['stock']."'></td>
                      <td><button class='smallButton' onclick=\"addOrderLine(".$table_row['id'].", ".$table_row['PVP'].", ".$orderid.", ".$i.")\">Añadir</button></td>";
                $i = $i+1;
                
                /*
                echo "<td><form method=\"post\" action=\"\">
                            <input class=\"inputText\" name=\"cantidad\" type=\"number\" value=\"0\" min=\"0\" max=\"".$table_row['stock']."\">
                            <input name=\"id\" type=\"hidden\" value=\"".$table_row['id']."\">
                            <input name=\"price\" type=\"hidden\" value=\"".$table_row['PVP']."\">
                            <input class=\"smallButton\" type=\"submit\" name=\"add\" value=\"Añadir\">";
                if($opt==2) echo "<input class=\"smallButton\" type=\"submit\" name=\"substract\" value=\"Disminuir\">";

                echo    "</form></td>";
                */
            }
            echo "</tr>";
        }
        if($opt == 0){
            echo "<tr colspan='6'><td><form method='post' action=''>
                        Población: <input class=\"inputText\" type='text' name='poblation' required><br>
                        Dirección: <input class=\"inputText\" type='text' name='address' required><br><br>
                        <input class=\"smallButton\" type='submit' name='endOrder' value='Finalizar pedido'>
                  </form></td></tr>";
        }
    }
    public static function showOrderTable($id){
        $datesIndex=array("hora de creacion", "hora de asignacion", "hora de entrega", "hora de reparto");
        $res=DB::execute_sql("select id, idcliente, horacreacion as [hora de creacion], poblacionentrega as [poblacion], direccionentrega as [direccion], horaasignacion as [hora de asignacion], horareparto as [hora de reparto], horaentrega as [hora de entrega], pvp from pedidos where idcliente=?", array($id));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            echo "<br><br><table><tr>";
            foreach ($res as $table_row) {
                //damos formato a los campos que queremos
                foreach ($datesIndex as $dates) {
                    if(isset($table_row["$dates"])){
                        if($table_row[$dates] == 0 || $table_row[$dates] == null)continue;
                        $table_row["$dates"]=date('j-M-Y H:i:s', ($table_row[$dates]));
                    }
                }
                if($first){
                     foreach ($table_row as $row_index => $row_data) {
                         echo "<th>$row_index</th>";
                     }
                     $first=false;
                }
                echo '</tr><tr>';
                foreach ($table_row as $row_data) {
                    echo "<td>$row_data</td>";
                }
                if($table_row['hora de creacion'] != 0){
                    echo "<td><a class=\"aForm\" href='orderDetails.php?id= " . $table_row['id'] . "'>Detalles</a></td></tr>";
                }else{
                    echo "<td><a class=\"aForm\" href='placeOrder.php?id=".$table_row['idcliente']."&orderid=".$table_row['id']."'>Sin finalizar</a></td></tr>";
                }
            }
            echo "</table><br>";
        }
    }
    public static function showOrderDetails($id, $opt=1){
        $i=0;
        $res=DB::execute_sql("select id, idbebida, unidades, pvp from lineaspedido where idpedido=?", array($id));
        if($res){
            $res -> setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            echo '<table id="tablaBebidas"><tr>';
            foreach ($res as $table_row) {
                if($first){
                    $first=false;
                    foreach ($table_row as $row_index => $row_data) {
                        if($row_index == 'idbebida'){
                            echo "<th>Bebida</th>";
                        } else if($row_index != 'id')echo "<th>$row_index</th>";
                    }
                }
                echo '</tr>';
                echo '<tr id=fila'.$i.'>';
                foreach ($table_row as $row_index => $row_data) {
                    if($row_index == 'idbebida'){
                        $res=DB::execute_sql("select marca from bebidas where id=?;", array($row_data));
                        $res->setFetchMode(PDO::FETCH_NAMED);
                        $drinkName=$res->fetchAll()[0]['marca'];
                        echo "<td>$drinkName</td>";
                    }else if($row_index != 'id')echo "<td>$row_data</td>";
                }
                if($opt != 1){
                    echo "<td><button class=\"smallButton\" onclick=\"deleteOrderLine(".$table_row['idbebida'].", ".$table_row['PVP'].", ".$table_row['unidades'].", ".$id.", ".$i.")\">Borrar</button></td>";
                    $i = $i + 1;                    
                }

                /*
                echo "<td><form method=\"post\" action=\"\">
                            <input name=\"cantidad\" type=\"hidden\" value=\"".$table_row['unidades']."\">
                            <input name=\"id\" type=\"hidden\" value=\"".$table_row['idbebida']."\">
                            <input name=\"price\" type=\"hidden\" value=\"".$table_row['PVP']."\">
                            <input class=\"smallButton\" type=\"submit\" name=\"delete\" onclick=\"deleteOrderLine(".$table_row['id'], $id.")\" value=\"Eliminar\">";
                echo "</form></tr>";
                */
            }
            echo '</table>';
        }
        echo "<br><div class=\"centre\"><div class=\"button\"><a class=\"a\" href='clientIndex.php?id=".$_SESSION['user']['id']."'>Volver a inicio</a></div></div>";
    }
    public static function createOrderForm(){
        echo "<form action='' method='post'>
                <div>";
                        $res=DB::execute_sql('select id, marca, PVP, stock from bebidas;');
                        if($res){
                            $res->setFetchMode(PDO::FETCH_NAMED);
                            $aux=$res->fetchAll();
                            //nos devuelve los datos en forma de un array QUE HAY QUE RECORRER AUN
                            foreach($aux as $row_data){
                                echo "<input name='drinks[]' type='number' placeholder='".$row_data['marca']."' min='0' max='".$row_data['stock']."' required><br>";
                                echo "<input name='names[]' type='hidden' value='".$row_data['marca']."'>";
                                echo "<input name='ids[]' type='hidden' value='".$row_data['id']."'>";
                                echo "<input name='pvps[]' type='hidden' value='".$row_data['PVP']."'>";
                            }
                        }
                echo "<input type=\"submit\" name=\"submit\" value=\"Submit\">";
                echo "</div></form>";
    }
    
    public static function showAssignedOrders($id){
        $datesIndex=array("hora de creacion", "hora de asignacion", "hora de entrega", "hora de reparto");
        $res=DB::execute_sql("select id, idcliente, horacreacion as [hora de creacion], poblacionentrega as [poblacion], direccionentrega as [direccion], horaasignacion as [hora de asignacion], horareparto as [hora de reparto], horaentrega as [hora de entrega], pvp from pedidos where idrepartidor=?", array($id));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first = true;
            foreach($res as $table_row){
                //damos formato a los campos que queremos
                foreach ($datesIndex as $dates) {
                    if(isset($table_row[$dates])){
                        if($table_row[$dates] == 0 || $table_row[$dates] == null)continue;
                        $table_row[$dates]=date('j-M-Y H:i:s', ($table_row[$dates]));
                    }
                }
                if($first){
                    echo "<br><br><table><tr>";
                    foreach($table_row as $tableRow_index=>$tableRow_Data){
                        if($tableRow_index != 'id'){
                            if($tableRow_index == 'idcliente')echo "<th>Nombre Cliente</th>";
                            else echo "<th>$tableRow_index</th>";
                        }
                    }
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                foreach($table_row as $tableRow_index => $tableRow_Data){
                    if($tableRow_index != 'id'){
                        if($tableRow_index == 'idcliente'){
                            $res=DB::execute_sql("select nombre from usuarios where id=?", array($tableRow_Data));
                            $res->setFetchMode(PDO::FETCH_NAMED);
                            $name=$res->fetchAll()[0]['nombre'];
                            echo "<td>$name</td>";
                        } else echo "<td>$tableRow_Data</td>";
                    }
                }
                if($table_row["hora de reparto"] == 0){
                    echo "<td><a class=\"aForm\" href='orderDistribution.php?id=" . $table_row['id'] . "'>Repartir pedido</a></td>";
                }else if($table_row["hora de entrega"] == 0){
                    echo "<td><a class=\"aForm\" href='orderDelivery.php?id=" . $table_row['id'] . "'>Entregar pedido</a></td>";
                }else{
                    echo "<td>ENTREGADO</td>";
                }
                echo "</tr>";
            }
            echo '</table>';
        } else {
            echo "<div class=\"centre\"><h1 class=\"A\">NO HAY PEDIDOS ASIGNADOS</h1></div>";
        }
    }
    public static function showNotAssignedOrders($id){
        $datesIndex=array("hora de creacion", "hora de asignacion", "hora de entrega", "hora de reparto");
        $res=DB::execute_sql("select id, idcliente, horacreacion as [hora de creacion], poblacionentrega as [poblacion], direccionentrega as [direccion], horaasignacion as [hora de asignacion], horareparto as [hora de reparto], horaentrega as [hora de entrega], pvp from pedidos where idrepartidor IS NULL and PVP <> 0;");
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first = true;
            foreach($res as $table_row){
                //damos formato a los campos que queremos
                foreach ($datesIndex as $dates) {
                    if(isset($table_row[$dates])){
                        if($table_row[$dates] == 0 || $table_row[$dates] == null)continue;
                        $table_row[$dates] = date('j-M-Y H:i:s', ($table_row[$dates]));
                    }
                }
                if($first){
                    echo "<br><br><table><tr>";
                    foreach($table_row as $tableRow_index=>$tableRow_Data){
                        if($tableRow_index != 'id'){
                            if($tableRow_index == 'idcliente')echo "<th>Nombre Cliente</th>";
                            else echo "<th>$tableRow_index</th>";
                        }
                    }
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                foreach($table_row as $tableRow_index => $tableRow_Data){
                    if($tableRow_index != 'id'){
                        if($tableRow_index == 'idcliente'){
                            $res=DB::execute_sql("select nombre from usuarios where id=?", array($tableRow_Data));
                            $res->setFetchMode(PDO::FETCH_NAMED);
                            $name=$res->fetchAll()[0]['nombre'];
                            echo "<td>$name</td>";
                        } else echo "<td>$tableRow_Data</td>";
                    }
                }
                echo "<td><a class=\"aForm\" href='assignOrder.php?orderid=".$table_row['id']."&delivid=".$id."'>Asignar pedido</a></td>";
                echo "</tr>";
            }
            echo '</table>';
        } else {
            echo "<div class=\"centre\"><h1 class=\"A\">NO QUEDAN PEDIDOS POR ASIGNAR</h1></div>";
        }
    }
}
class DB{
    private static $connection=null;
    public static function get(){
        if(self::$connection === null){
            self::$connection = $db = new PDO("sqlite:./datos.db");
            self::$connection->exec('PRAGMA foreign_keys = ON;');
            self::$connection->exec('PRAGMA encoding="UTF-8";');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
    public static function execute_sql($sql,$parms=null){
        try {
            $db = self::get();
            $ints= $db->prepare ( $sql );
            if ($ints->execute($parms)) {
                return $ints;
            }
        }
        catch (PDOException $e) {
            echo '<h1>Error en la DB: ' . $e->getMessage() . '</h1>';
        }
        return false;
    }
    
    public static function getPVP($drink, $amount){
        $res=self::execute_sql("select pvp from bebidas where marca=?", array($drink));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $individualPVP=$res->fetchAll()[0];
            return $individualPVP['PVP']*$amount;
        }
        return false;
    }
    public static function getStockLeft($drink, $amount){
        $res=self::execute_sql("select stock from bebidas where marca=?", array($drink));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $availableStock=$res->fetchAll()[0];
            return $availableStock['stock']-$amount;
        }
        return false;
    }
    public static function updatePVP($orderid, $drinkid, $amount, $price){
        $res=self::execute_sql("select PVP from pedidos where id=?;", array($orderid));
        $res->setFetchMode(PDO::FETCH_NAMED);
        $orderpvp=$res->fetchAll()[0]['PVP'];

        $res=self::execute_sql("update pedidos set PVP=? where id=?", array($orderpvp+($price*$amount), $orderid));
    }
    public static function updateDrinkTable($drinkid, $amount){
        $res=self::execute_sql("select stock from bebidas where id=?;", array($drinkid));
        $res->setFetchMode(PDO::FETCH_NAMED);
        $drinkamount=$res->fetchAll()[0]['stock'];
        
        DB::execute_sql("update bebidas set stock=? where id=?", array($drinkamount-$amount, $drinkid));
    }
    public static function orderLineExists($orderid, $id){
        $res=self::execute_sql("select unidades from lineaspedido where idbebida=? and idpedido=?;", array($id, $orderid));
        $res->setFetchMode(PDO::FETCH_NAMED);
        $algo=$res->fetchAll();
        if(count($algo) != 0)return $algo[0]['unidades'];
        return false;
    }
}
class User{
    public static function session_start(){
        if(session_status () === PHP_SESSION_NONE){
            session_start();
        }
    }
    public static function getLoggedUser(){ //Devuelve un array con los datos del cuenta o false
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }
    public static function login($usuario,$pass){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM usuarios WHERE usuario=? and clave=?');
        $inst->execute(array($usuario,md5($pass)));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res)==1){
            $_SESSION['user']=$res[0]; //Almacena datos del usuario en la sesión
            return true;
        }
        return false;
    }
    public static function isAdmin(){
        $userData = self::getLoggedUser();
        if($userData['tipo'] == 1)return true;
        return false;
    }
    public static function isClient(){
        $userData = self::getLoggedUser();
        if($userData['tipo'] == 2)return true;
        return false;
    }
    public static function isDealer(){
        $userData = self::getLoggedUser();
        if($userData['tipo'] == 3)return true;
        return false;
    }
    public static function logout(){
        self::session_start();
        unset($_SESSION['user']);
    }
}
