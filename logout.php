<?php
include 'tpl/auth.php';

//session_start();
//$_SESSION['authenticated'] = 'false';
//unset($_SERVER['PHP_AUTH_USER']);
//unset($_SERVER['PHP_AUTH_PW']);
//session_unset();
//session_destroy();
header("Location: admin.php");
//echo "<a href='login.php?logout=true'>Try force log out</a>";
?>
