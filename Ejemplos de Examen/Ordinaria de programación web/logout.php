<?php
include_once 'lib.php';
User::session_start();
session_destroy();
header('Location:index.php');
die;
