<?php
class View{
    public static function  start($title){
        $html = "<!DOCTYPE html>
<html>
<head>
<meta charset=\"utf-8\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
<script type=\"text/javascript\" src=\"scripts.js\"></script>
<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js\"></script>
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
            echo '<a href="usuarios.php">Lista usuarios</a> ';
            echo '<a href="sentMessages.php">Mensajes enviados</a> ';
            echo '<a href="receivedMessages.php">Mensajes recibidos</a> ';
            echo '<a href="logout.php">Logout</a> ';
            echo 'Usuario: '.$user['nombre'];
        }
        echo '</nav>';
    }
    public static function end(){
        echo '</body>
</html>';
    }
    public static function showUserList(){
        $dbConn = DB::get();
        $query = $dbConn -> prepare("SELECT id, cuenta, nombre FROM usuarios WHERE id<>?;");
        $query -> execute(array($_SESSION['user']['id']));
        if($query){
            $query -> setFetchMode(PDO::FETCH_NAMED);
            $headerRow = true;
            echo '<table>';
            foreach($query as $table_row){
                if($headerRow){
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
                echo '<td><a href="sendMessage.php?to='.$table_row['id'].'&from='.$_SESSION['user']['id'].'">Mandar mensaje</a></td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }
    public static function showMessageForm(){
        echo '<form action="" method="post" onsubmit="return formValidation()" id="messageForm">
        Mensaje:<textarea name="message" form="messageForm" id="messageSent" placeholder="Escriba su texto aquí" cols="50" rows="5"></textarea>
        <input type="submit" value="Enviar" name="sendMessage">
        </form>';
    }
    public static function showDirectMessageForm(){
        echo '<form action="" method="post" id="directMessageForm" onsubmit="return checkName()">
        Destino:<input type="text" name="recipient" placeholder="nombre del usuario remitente" id="recipient" onblur="checkName()">
        <p class="error" id="nameNotExists">Esa cuenta es incorrecta o no existe.</p>
        Mensaje:<textarea name="messageText" form="directMessageForm" id="directMessageSent" placeholder="Escriba su texto aquí." cols="50" rows="5"></textarea>
        <input type="submit" value="Enviar" name="sendDirectMessage">
        </form>';
    }
    public static function showSentMessages($opt){
        $dbConn = DB::get();
        $objQuery = "SELECT usuarios.nombre, mensajes.hora, mensajes.mensaje FROM mensajes, usuarios WHERE remitente=? and mensajes.destinatario=usuarios.id;";
        if($opt)$objQuery="SELECT usuarios.nombre, mensajes.hora, mensajes.mensaje FROM mensajes, usuarios WHERE remitente=? and mensajes.destinatario=usuarios.id ORDER BY mensajes.hora DESC;";
        $query = $dbConn -> prepare($objQuery);
        $query -> execute(array($_SESSION['user']['id']));
        if($query){
            $query -> setFetchMode(PDO::FETCH_NAMED);
            $headerRow = true;
            echo '<table>';
            foreach($query as $table_row){
                if($headerRow){
                    echo '<tr>';
                    foreach($table_row as $table_row_index => $table_row_data)echo '<th>'.$table_row_index.'</th>';
                    echo '</tr>';
                    $headerRow = false;
                }
                echo '<tr>';
                foreach($table_row as $table_row_index => $table_row_data){
                    if($table_row_index == 'hora')echo '<td>'.date('Y-m-d H:i:s',$table_row_data);
                    else echo '<td>'.$table_row_data.'</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }
    }
    public static function showReceivedMessages($opt){
        $dbConn = DB::get();
        $objQuery = "SELECT usuarios.nombre, mensajes.hora, mensajes.mensaje FROM mensajes, usuarios WHERE remitente=? and mensajes.destinatario=usuarios.id;";
        if($opt==1)$objQuery="SELECT usuarios.nombre, mensajes.hora, mensajes.mensaje FROM mensajes, usuarios WHERE destinatario=? and mensajes.remitente=usuarios.id ORDER BY mensajes.hora;";
        $query = $dbConn -> prepare($objQuery);
        $query -> execute(array($_SESSION['user']['id']));
        if($query){
            $query -> setFetchMode(PDO::FETCH_NAMED);
            $headerRow = true;
            echo '<table>';
            foreach($query as $table_row){
                if($headerRow){
                    echo '<tr>';
                    foreach($table_row as $table_row_index => $table_row_data)echo '<th>'.$table_row_index.'</th>';
                    echo '</tr>';
                    $headerRow = false;
                }
                echo '<tr>';
                foreach($table_row as $table_row_index => $table_row_data){
                    if($table_row_index == 'hora')echo '<td>'.date('Y-m-d H:i:s',$table_row_data);
                    else echo '<td>'.$table_row_data.'</td>';
                }
                echo '</tr>';
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
        }
        return self::$connection;
    }
    public static function getIdbyAccount($account){
        $dbConn=self::get();
        $query=$dbConn->prepare("select id from usuarios where cuenta=?;");
        $query->execute(array($account));
        
        if($query){
            return $query->fetchAll()[0]['id'];
        }
    }
}
class User{
    public static function session_start(){
        if(session_status () === PHP_SESSION_NONE){
            session_name('PR4_ORD');
            session_start();
        }
    }
    public static function getLoggedUser(){ //Devuelve un array con los datos del cuenta o false
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }
    public static function login($cuenta,$pass){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM usuarios WHERE cuenta=? and clave=?');
        $inst->execute(array($cuenta,md5($pass)));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res)==1){
            $_SESSION['user']=$res[0];
            return true;
        }
        return false;
    }
}
