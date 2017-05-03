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
        $form= "<form method=\"post\" action=\"login.php\">  
        Name: <input type=\"text\" name=\"name\">
    <br>
        Password: <input type=\"password\" name=\"pass\">
        <input type=\"submit\" name=\"login\" value=\"Login\">  
</form>";

    echo $form;
    }
    
    public static function adminFunctions(){
        echo '<a href="userManagement.php">Gestionar usuarios</a> <br> <a href="orderManagement.php">Gestionar pedidos</a>';
    }
    public static function adminUserTable(){
        $res=DB::execute_sql("select * from usuarios;");
        //Ejemplo de lectura de tabla
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            echo '<a href="createUser.php" class="button" id="send"> Crear usuario </a>';
            foreach($res as $table_row){
                if($first){
                    echo "<table><caption>Usuarios</caption><tr>";
                    foreach($table_row as $tableRow_index=>$tableRow_Data){
                        echo "<th>$tableRow_index</th>";
                    }
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                foreach($table_row as $tableRow_Data){
                    echo "<td>$tableRow_Data</td>";
                }
                echo "<td><a href='modifyUser.php?id=" . $table_row['id'] . "'> Editar </a></td><br><td><a href='deleteUser.php?id=" . $table_row['id'] . "'>Borrar</a></td>";
                echo "</tr>";
            }
            echo '</table>';
        }
    }
    public static function createUserForm(){
        echo "<form action=\"\" method=\"post\">
                <div>
                    <strong>Usuario: *</strong> <input type=\"text\" name=\"user\"/ required><br/>
                    
                    <strong>Clave: *</strong> <input type=\"password\" name=\"pass\"/ required><br/>
                    
                    <strong>Nombre: *</strong> <input type=\"text\" name=\"name\"/ required><br/>
                    
                    <strong>Tipo: *</strong> <input type=\"number\" name=\"type\" min=\"1\" max=\"3\" value=\"1\" / required><br/>
                    
                    <strong>Población: </strong> <input type=\"text\" name=\"pob\"/><br/>
                    
                    <strong>Dirección: </strong> <input type=\"text\" name=\"addr\"/><br/>
                    <p>* required</p>
                    
                    <input type=\"submit\" name=\"submit\" value=\"Submit\">
                </div>
            </form>";
    }
    public static function editUserForm($user, $pass, $name, $type, $pob, $addr){
                echo "<form action=\"\" method=\"post\">
                <div>
                    <strong>Usuario: *</strong> <input type=\"text\" name=\"user\" value=\"$user\"/ required><br/>
                    
                    <strong>Clave: *</strong> <input type=\"password\" name=\"pass\" value=\"$pass\"/ required><br/>
                    
                    <strong>Nombre: *</strong> <input type=\"text\" name=\"name\" value=\"$name\"/ required><br/>
                    
                    <strong>Tipo: *</strong> <input type=\"number\" name=\"type\" min=\"1\" max=\"3\" value=\"$type\" required/><br/>
                    
                    <strong>Población: </strong> <input type=\"text\" name=\"pob\" value=\"$pob\"/><br/>
                    
                    <strong>Dirección: </strong> <input type=\"text\" name=\"addr\" value=\"$addr\"/><br/>
                    <p>* required</p>
                    
                    <input type=\"submit\" name=\"submit\" value=\"Submit\">
                </div>
            </form>";
    }
    
    public static function showDrinkTable(){
        $res=DB::execute_sql('select id, marca, stock, pvp from bebidas');
        $res->setFetchMode(PDO::FETCH_NAMED);
        $first=true;
        echo '<table><tr>';
        foreach ($res as $table_row) {
            if($first){
                $first=false;
                foreach ($table_row as $row_index => $row_data) {
                    echo "<th>$row_index</th>";
                }
                
            }
            echo '</tr>';
            echo '<tr>';
            foreach ($table_row as $row_data) {
                echo "<td>$row_data</td>";
            }
            echo '</tr>';
        }
        echo '</table>';
    }
    public static function showOrderTable($id){
        $datesIndex=array("horacreacion", "horaasignacion", "horaentrega", "horareparto");
        $res=DB::execute_sql("select id, horacreacion, poblacionentrega, direccionentrega, horaasignacion, horareparto, horaentrega, pvp from pedidos where idcliente=?", array($id));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            echo "<table><tr>";
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
                echo "<td><a href='orderDetails.php?id= " . $table_row['id'] . "'>Detalles</a></td></tr>";
            }
            echo "</table>";
        }
    }
    public static function showOrderDetails($id){
        $res=DB::execute_sql('select idbebida, unidades, pvp from lineaspedido where idpedido=?', array($id));
        if($res){
            $res -> setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            echo '<table><tr>';
            foreach ($res as $table_row) {
                if($first){
                    $first=false;
                    foreach ($table_row as $row_index => $row_data) {
                        echo "<th>$row_index</th>";
                    }
                }
                echo '</tr>';
                echo '<tr>';
                foreach ($table_row as $row_data) {
                    echo "<td>$row_data</td>";
                }
                echo '</tr>';
            }
            echo '</table>';
        }
        echo "<a href='clientIndex.php?id=".$_SESSION['user']['id']."'>Volver a inicio.</a>";
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
        $datesIndex=array('horacreacion', 'horaasignacion', 'horaentrega', 'horareparto');
        $res = DB::execute_sql("select * from pedidos where idrepartidor=?", array($id));
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
                    echo "<table><caption>Mis Pedidos</caption><tr>";
                    foreach($table_row as $tableRow_index=>$tableRow_Data){
                        echo "<th>$tableRow_index</th>";
                    }
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                foreach($table_row as $tableRow_Data){
                    echo "<td>$tableRow_Data</td>";
                }
                if($table_row["horareparto"] == 0){
                    $data3=$table_row["horareparto"];
                    echo "HOLIREPARTO, $data3";
                    echo "<td><a href='orderDistribution.php?id=" . $table_row['id'] . "'>Repartir pedido</a></td>";
                }else if($table_row["horaentrega"] == 0){
                    echo "HOLIENTREGA";
                    echo "<td><a href='orderDelivery.php?id=" . $table_row['id'] . "'>Entregar pedido</a></td>";
                }else{
                    echo "<td>ENTREGADO</td>";
                }
                echo "</tr>";
            }
            echo '</table>';
        }
    }
    public static function showNotAssignedOrders($id){
        $datesIndex=array('horacreacion', 'horaasignacion', 'horareparto', 'horaentrega');
        $res=DB::execute_sql("select * from pedidos where idrepartidor IS NULL;");
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
                    echo "<table><caption>Pedidos no asignados</caption><tr>";
                    foreach($table_row as $tableRow_index=>$tableRow_Data){
                        echo "<th>$tableRow_index</th>";
                    }
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                foreach($table_row as $tableRow_Data){
                    echo "<td>$tableRow_Data</td>";
                }
                echo "<td><a href='assignOrder.php?orderid=".$table_row['id']."&delivid=".$id."'>Asignar pedido</a></td>";
                echo "</tr>";
            }
            echo '</table>';
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
    public static function checkStock($drink, $amount){
        $res=self::execute_sql("select stock from bebidas where marca=?", array("$drink"));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $availableStock=$res->fetchAll()[0];
            if($availableStock['stock'] > $amount)return true;
        }
        echo "HA PASADO ALGO";
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
