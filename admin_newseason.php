<?php
include 'tpl/auth.php';
include 'tpl/sql.php';
require_once 'phpqrcode.php';

/*
// We had this all in here coz we previously would do all the inserts here, but we do it in a new page now so we can print the sticker results
if ((strlen($_POST['submit']) > 1) && (strlen($_POST['newplants']) > 0)) {
	// We define newplants as a low number as a fallback in case of issues
	$newplants = 1;

	// Pull the details from the submitted form
	$cultivarid = filter_var($_POST['cultivar'], FILTER_SANITIZE_STRING);
	$facilityid = filter_var($_POST['facility'], FILTER_SANITIZE_STRING);
	$newplants = filter_var($_POST['newplants'], FILTER_SANITIZE_STRING);
	$seasonid = filter_var($_POST['seasonid'], FILTER_SANITIZE_STRING);

	if ($newplants >= 500) { $newplants = 10; }

	// variables needed for the inserts
	$date = date('Y-m-d');
	$current_row_for_insert = 0;

	while ($current_row_for_insert < $newplants) {
		// Make a UniqueID for the plant
		$plant_uniqueid = uniqid('p', true);

		// Now we make a QR Code for it
		$fileName = $plant_uniqueid . ".png";
		$pngAbsoluteFilePath = 'qrcodes/' . $fileName;
		if (!file_exists($pngAbsoluteFilePath)) {
		        QRcode::png($plant_uniqueid, $pngAbsoluteFilePath);
		//echo 'File generated!';
		} else {
		//echo 'File already generated! We can use this cached file to speed up site on common codes!';
		}


		// Increase plant #
		$current_row_for_insert++;

		$sql="INSERT INTO inventory (facilityid, date_of_spawn, plant_uniqueid, season_id, plant_num, where_is_it_now, current_state, cultivar) VALUES ('$facilityid','$date','$plant_uniqueid',$seasonid,'$current_row_for_insert','Nursery','In the early life stages','$cultivarid')";
		//if (mysqli_query($conn, $sql)) {
	        if ($result = mysqli_query($con, $sql)) {

		  echo "New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

	}
	$savesuccess = 'true';
}
*/

// Get the current Season ID so we can make a new one
$sql="SELECT * FROM `inventory` WHERE 1 order by season_id desc limit 1";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
$currentseason = $row[0]['season_id'];

// Now a little splitting out
$currentyear = date('Y');
$splitseasonarray = explode(".", $currentseason);
$currentseasonyear = $splitseasonarray[0];
$currentseasonnum = $splitseasonarray[1];

// And time for some math to see if we incriment the year or just the seasonID
if($currentyear>$currentseasonyear) {
	$newseason = $currentyear . ".1";
	}
	else {
	$currentseasonnum++;
	$newseason = $currentyear . "." . $currentseasonnum;
	}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: Start new season</title>

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

      <h1 class="title">Start new season</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align="center">Add a new cultivar to be utilized in the facility</p>
      <div class="card">
	<form action='admin_newseason_print.php' method='post'>
	<label>Facility for cultivation:</label>
<?php
	echo "  <select name='facility'>\n";
	foreach($facilities as $currentfacility) {
	    echo "<option value='" . $currentfacility . "'>" . $currentfacility . "</option>\n";
	}
	echo "</select><br />Cultivar: \n";
        $sql = "SELECT * FROM cultivars";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo "  <select name='cultivar'>\n";
        foreach($row as $cultivar) {
            echo "<option value='" . $cultivar['id'] . "'>" . $cultivar['cultivar_name'] . "</option>\n";
        }
        echo "</select>\n";
?>

          <input type="text" placeholder="Number of seeds or cuttings" name="newplants" maxlength="4">
	  <input type="text" placeholder="Season ID (year.season)" name="seasonid" maxlength="8" value="<?php echo $newseason;?>" readonly>
	  <button class="btn btn-positive btn-block" type="submit" name="submit" value="save">Save</button>
	</form>
      </div>
    </div>

  </body>
</html>
