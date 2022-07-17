<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

if ((strlen($_POST['submit']) > 1) && (strlen($_POST['cultivar']) > 1)) {
	$cultivar = filter_var($_POST['cultivar'], FILTER_SANITIZE_STRING);
	$thc = filter_var($_POST['thc'], FILTER_SANITIZE_STRING);
	$cbd = filter_var($_POST['cbd'], FILTER_SANITIZE_STRING);
	$flowertime = filter_var($_POST['flowertime'], FILTER_SANITIZE_STRING);

	$sql="INSERT INTO cultivars (cultivar_name, expected_thc, expected_cbd, expected_flowertime) VALUES('$cultivar','$thc','$cbd','$flowertime')";
	if ($result = mysqli_query($con, $sql)) {
	  // echo "Returned rows are: " . mysqli_num_rows($result);
	} else {
           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
        //$cultivarid = mysqli_insert_id();
	mysqli_close($con);
	$savesuccess = 'true';
        }
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: Add new cultivar</title>

    <!-- Sets initial viewport load and disables zooming  -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

    <!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Include the compiled Ratchet CSS -->
    <link rel="stylesheet" href="ratchet-theme-ios.min.css">
    <link rel="stylesheet" href="ratchet.min.css">
    <link rel="stylesheet" href="app.css">

    <!-- Include the compiled Ratchet JS -->
    <!-- <script src="ratchet.js"></script> -->
  </head>
  <body>

    <!-- Make sure all your bars are the first things in your <body> -->
    <header class="bar bar-nav">
     <a href="admin.php"><button class="btn btn-link btn-nav pull-left">
       <span class="icon icon-home"></span>
       Home
     </button></a>

      <h1 class="title">Add new cultivar</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align="center">Add a new cultivar to be utilized in the facility</p>
<?php if($savesuccess=='true'){ echo "<p class='content-padded'>New cultivar saved successfully: $cultivar, $thc / $cbd, $flowertime </p>";} ?>
      <div class="card">
	<form action='admin_addcultivar.php' method='post'>
	  <input type="text" placeholder="Cultivar name" name="cultivar" maxlength="128">
          <input type="text" placeholder="Expected THC" name="thc" maxlength="16">
          <input type="text" placeholder="Expected CBD" name="cbd" maxlength="16">
          <input type="text" placeholder="Expected flower time" name="flowertime" maxlength="32">
	  <button class="btn btn-positive btn-block" type="submit" name="submit" value="save">Save</button>
	</form>
      </div>
    </div>

  </body>
</html>
