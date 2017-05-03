<?php
include_once 'lib.php';
$error='';
if(isset($_POST['usuario']) && isset($_POST['clave'])){
    if(User::login($_POST['usuario'],$_POST['clave'])){
        header('Location:index.php');
        die;
    }
    $error='<h3>Error en el login inténtelo de nuevo</h3>';
}
View::start('login');
View::navigation();
echo '<form method="post">';
echo 'Usuario <input type="text" name="usuario">';
echo 'Clave <input type="password" name="clave">';
echo '<input type="submit" value="Entrar">';
echo '</form>';
View::end();
