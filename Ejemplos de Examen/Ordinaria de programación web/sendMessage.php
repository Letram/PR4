<?php
include_once('lib.php');
if(isset($_POST['sendMessage'])){
    $from = $_GET['from'];
    $to = $_GET['to'];
    $message = $_POST['message'];
    
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
View::start("Mandar mensaje");
View::showMessageForm();
echo '<p class="error" id="errorMessageForm">Se ha superado el número máximo de caractéres permitidos (1000).</p>';
echo '<a href="usuarios.php">Volver</a>';
View::end();
?>