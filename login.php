<?php
include 'tpl/auth.php';
include 'tpl/sql.php';
?>


<html>
<head>
<title>Schedule Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="adminstyle.css" />
<meta name = "viewport" content = "width = device-width">
</head>

<body onorientationchange="updateOrientation();">


<form action="login.php" method='post'>
<h1>Please enter your password:</h1>
<ul>
 <li><input style="font-size: 20px;" name='pass' type='password'></li>
</ul>
<p align='center'><input type='submit' name='submit' value='Login'></p>
</form>
<br />
</body>
</html>
