<?php
include_once 'lib.php';
    if(User::isAdmin()){
        View::start("Admin Index");
    
        View::adminFunctions();
        echo '<a href="logout.php" class="button"> Cerrar sesión</a>';
    
        View::end();
        
    }
?>