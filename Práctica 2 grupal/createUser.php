<?php
    include_once('lib.php');
    if(User::isAdmin()){
        View::Start("Crear usuario");
        View::createUserForm();
        if (isset($_POST['submit'])){
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $name = $_POST['name'];
            $type = $_POST['type'];
            $pob = $_POST['pob'];
            $addr = $_POST['addr'];
            
            $res=DB::execute_sql('insert into usuarios (usuario, clave, nombre, tipo, poblacion, direccion) values (?, ?, ?, ?, ?, ?);', array($user, md5($pass), $name, $type, $pob, $addr));
            
            if($res)echo "<h1>GUARDADO</h1><br><a href='userManagement.php'>Volver a tabla</a>";
        }
        View::end();
    }
?>
