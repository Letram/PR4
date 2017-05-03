<?php
include_once ('lib.php');
    if(User::isClient()){
        $orderID=$_GET['id'];
        View::start("client");
        View::showOrderDetails($orderID);
        View::end();
    }
?>