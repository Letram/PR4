<?php
include_once('lib.php');

if(isset($_POST['sendDirectMessage'])){
    $user=User::getLoggedUser();
    $from=$user['id'];
    $to=DB::getIdbyAccount($_POST['recipient']);
    $message=$_POST['messageText'];
    
    $dbConn = DB::get();
    $query = $dbConn -> prepare("INSERT INTO mensajes(remitente, destinatario, hora, mensaje) VALUES (?,?,?,?);");
    $query -> execute(array($from, $to, time(), $message));
    if($query -> rowCount() == 1){
        header('Location:sentMessages.php');
        die;
    }else{
        echo 'Algo ha ido mal en el envío.';
    }

}
View::start("Usuarios");
echo '<div>';
    echo'<div>';
        View::showDirectMessageForm();
    echo '<div>';
    View::showUserList();
echo '</div>';
echo '<a href="index.php">Volver</a>';
View::end();
?>