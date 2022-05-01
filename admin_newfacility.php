<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

//if (($_POST['submit']) == 'save') && (strlen($_POST['facilityname']) > 1)) {
if ((strlen($_POST['submit']) > 1) && (strlen($_POST['facilityname']) > 1)) {
//if ($_POST['submit'] == 'save') {
	$facilityname = filter_var($_POST['facilityname'], FILTER_SANITIZE_STRING);
	$approved_for_cultivation = filter_var($_POST['approved_for_cultivation'], FILTER_SANITIZE_STRING);
	$max_flowers = filter_var($_POST['max_flowers'], FILTER_SANITIZE_STRING);

	$sql="INSERT INTO facilities (facilityname, approved_for_cultivation, max_flowers) VALUES('$facilityname','$approved_for_cultivation','$max_flowers')";
        if ($result = mysqli_query($con, $sql)) {
          // echo "Returned rows are: " . mysqli_num_rows($result);
          // Free result set
          mysqli_free_result($result);
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
    <title>growTENT :: Add new facility</title>

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

      <h1 class="title">Add new cultivation facility</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align="center">Add a new facility for cultivation</p>
<?php if ($savesuccess == 'true'){ echo "	<p class='content-padded'>New facility saved successfully</p>";} ?>
      <div class="card">
	<form action='admin_newfacility.php' method='post'>
	  <input type="text" placeholder="Facility name" name="facilityname" maxlength="128">
          <input type="text" placeholder="Approved for Cultivation?" name="approved_for_cultivation" maxlength="16">
          <input type="text" placeholder="Max plants in flower" name="max_flowers" maxlength="16">
	  <button class="btn btn-positive btn-block" type="submit" name="submit" value="save">Save</button>
	</form>
      </div>
    </div>

  </body>
</html>
