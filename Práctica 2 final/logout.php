<?php
include_once 'lib.php';
    User::logout();
    View::start("Cerrar sesión");

    header("Location: index.php");
    
    View::end();
?>