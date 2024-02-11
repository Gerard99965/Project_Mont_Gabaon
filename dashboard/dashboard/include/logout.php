<?php
session_start();
//include('dashboard/dashboard/function/function.php');
session_destroy();
$_SESSION=[];

header('location: /log.php');
?>
