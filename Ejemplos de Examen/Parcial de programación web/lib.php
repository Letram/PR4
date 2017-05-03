<?php
class View{
    public static function start($title){
        $html = "<!DOCTYPE html>
<html>
<head>
<meta charset=\"utf-8\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
<title>$title</title>
</head>
<body>";
        User::session_start();
        echo $html;
    }
    public static function navigation(){
        $user=User::getLoggedUser();
        echo '<nav>';
        if($user === false){
            echo '<a href="login.php">Login</a>';
        }else{
            echo '<a href="atencion.php">Atender llamada cliente</a> <a href="logout.php">Logout</a>';
            echo ' Usuario: '.$user['nombre'];
        }
        echo '</nav>';
    }
    public static function end(){
        echo '</body>
</html>';
    }
    
    public static function showClientList(){
        $dbConn = DB::get();
        $query = $dbConn -> prepare("SELECT * FROM clientes");
        $query -> execute();
        if($query){
            $query->setFetchMode(PDO::FETCH_NAMED);
            $headerRow = true;
            echo '<table>';
            foreach($query as $table_row){
                if($headerRow == true){
                    echo '<tr>';
                    foreach($table_row as $table_row_index => $table_row_data){
                        if($table_row_index == 'id')continue;
                        echo '<th>'.$table_row_index.'</th>';
                    }
                    echo '</tr>';
                    $headerRow = false;
                }
                echo '<tr>';
                foreach($table_row as $table_row_index => $table_row_data){
                    if($table_row_index == 'id')continue;
                    echo '<td>'.$table_row_data.'</td>';
                }
                echo '<td><a href="clientCallDetails.php?id='.$table_row['id'].'">Detalles de las llamadas</a></td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }
    public static function lookForClient(){
        echo '<form method="get" action="">
        Nombre: <input type="text" name="clientName" required>
        <input type="submit" value="Buscar por nombre" name="searchByName"></form>';
        echo '<form method="get" action="">
        Número: <input type="number" name"clientNumber" required>
        <input type="submit" value="Buscar por número" name="searchByNumber"></form>';
    }
    public static function showCallDetailsForClient($clientId){
        $dbConn = DB::get();
        $query=$dbConn->prepare("select atenciones.hora, operadores.usuario as operador, atenciones.peticion, atenciones.respuesta from atenciones inner join operadores on atenciones.operador=operadores.id where atenciones.cliente=?");
        //$query=$dbConn -> prepare("Select hora,operador,peticion,respuesta from atenciones where cliente=?");
        $query->execute(array($clientId));
        if($query){
            $query->setFetchMode(PDO::FETCH_NAMED);
            $headerRow = true;
            echo '<table>';
            foreach($query as $table_row){
                if($headerRow == true){
                    echo '<tr>';
                    foreach($table_row as $table_row_index => $table_row_data){
                        echo '<th>'.$table_row_index.'</th>';
                    }
                    echo '</tr>';
                    $headerRow = false;
                }
                echo '<tr>';
                foreach($table_row as $table_row_index => $table_row_data){
                    if($table_row_index == 'hora'){
                        echo '<td>'.date('Y-m-d H:i:s', $table_row_data).'</td>';
                    }
                    else echo '<td>'.$table_row_data.'</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }
    }
    public static function showProblemManagementForm(){
        echo '<form method="post" action="">
        Problema del cliente: <input type="text" name="petition" required>
        <br>
        Respuesta del operador: <input type="text" name="reply" required>
        <br>
        <input type="submit" name="problemManagement" value="Enviar">';
    }
}

class DB{
    private static $connection=null;
    public static function get(){
        if(self::$connection === null){
            self::$connection = $db = new PDO("sqlite:./datos.db");
            self::$connection->exec('PRAGMA foreign_keys = ON;');
        }
        return self::$connection;
    }
}
class User{
    public static function session_start(){
        if(session_status () === PHP_SESSION_NONE){
            session_name('PR4_PAR1');
            session_start();
        }
    }
    public static function getLoggedUser(){ //Devuelve un array con los datos del usuario o false
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }
    public static function login($user,$pass){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM operadores WHERE usuario=? and clave=?');
        $inst->execute(array($user,md5($pass)));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res)==1){
            $_SESSION['user']=$res[0];
            return true;
        }
        return false;
    }
    public static function logout(){
        self::session_start();
        unset($_SESSION['user']);
    }
}
