<?php
$dbhost = 'mysql.domain.com';
$dbuser = 'growTENT';
$dbpass = 'P@ssw0rd';
$dbname = 'skymangrowTENT';

date_default_timezone_set('Pacific/Auckland');
$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
?>

