<?php
    include_once 'lib.php';
    if(User::isAdmin()){
        $userData=User::getLoggedUser();
        View::Start("Gestionar usuarios");
        
        View::adminUserTable();
        echo "<a href='adminIndex.php'>Volver</a>";
        View::end();
    }
?>