<?php
    include_once 'lib.php';
    if(User::isAdmin()){
        $user_Id = $_GET['id'];
        if($user_Id != User::getLoggedUser()['id']){
            DB::execute_sql("delete from pedidos where idcliente=?", array($user_Id));
            DB::execute_sql("delete from usuarios where id=?", array($user_Id));
        }
        View::start();
            header ("Location: userManagement.php");
        View::end();
    }
?>