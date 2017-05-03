<?php
include_once 'lib.php';
    if(User::isAdmin()){
        View::start("Admin Index");
    	$userID=$_SESSION['user']['id'];
    	echo "<h1 class=\"A\">Bienvenido, ".$_SESSION['user']['nombre']."</h1>";
        echo "<ul class='navBar'>";
            echo "<li class='navBar'><a href='userManagement.php?id=".$userID."'>Gestionar usuarios</a></li>";
            echo "<li class='navBar'><a href='orderManagement.php?id=".$userID."'>Gestionar pedidos</a></li>";
            echo "<li class='navBar' id='logout'><a href='logout.php'> Cerrar sesión</a></li>";
        echo "</ul>";    
        View::end();
        
    }
?>