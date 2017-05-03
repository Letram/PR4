<?php
    include_once('lib.php');
    if(User::isAdmin()){
        View::Start("Crear usuario");
        
        $id = $_GET['id'];
        
        $userData = DB::execute_sql("select * from usuarios where id=:id", array(':id' => $id));
        $userData -> setFetchMode(PDO::FETCH_NAMED);
        $data = $userData->fetchAll()[0];
        View::editUserForm($data['usuario'], $data['clave'], $data['nombre'], $data['tipo'], $data['poblacion'], $data['direccion']);
        
         if (isset($_POST['submit'])){
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $name = $_POST['name'];
            $type = $_POST['type'];
            $pob = $_POST['pob'];
            $addr = $_POST['addr'];
            
            $res=DB::execute_sql('update usuarios set usuario=?, clave=?, nombre=?, tipo=?, poblacion=?, direccion=? where id=?;', array($user, md5($pass), $name, $type, $pob, $addr, $id));
            if($res->rowCount() == 1){
                 echo "<div class=\"centre\"><h1 class=\"A\">GUARDADO</h1><br><div class=\"button\"><a class=\"a\" href='userManagement.php?id=".$id."'>Volver a tabla</a></div></div>";
            }
        }
        
        View::end();
    }
?>
