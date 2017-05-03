<?php
include_once('lib.php');
    if(User::isClient()){
        $userID=$_GET['id'];
        View::start('Client');
        
        View::showOrderTable($userID);
        echo "<a href='clientIndex.php?id=".$userID."'>Volver</a>";
        View::end();
    }
?>