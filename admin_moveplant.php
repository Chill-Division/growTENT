<?php
include 'tpl/auth.php';
include 'tpl/sql.php';
$plantid = $_GET['plantid'];
/*
if (isset($_GET['s'])) {
        $season = $_GET['s'];
        }
else if (isset($_POST['season'])){
        $season = $_POST['season'];
        }
else {
	//No season set, show an empty screen. Check isset($season) later
        }


if (isset($_POST['confirmedseason'])) {
	// Season has been confirmed, and destination, so update the db
	$confirmedseason = $_POST['confirmedseason'];
	$new_location = $_POST['new_location'];
	$sql = "UPDATE inventory SET where_is_it_now='$new_location' WHERE season_id='$confirmedseason'";
		if ($result = mysqli_query($con, $sql)) {
	          // echo "Returned rows are: " . mysqli_num_rows($result);
	          // Free result set
	          mysqli_free_result($result);
	        }
        mysqli_close($con);
        $savesuccess = 'true';
	}



if ((strlen($_POST['submit']) > 1) && (strlen($_POST['cultivar']) > 1)) {
	$cultivar = filter_var($_POST['cultivar'], FILTER_SANITIZE_STRING);
	$thc = filter_var($_POST['thc'], FILTER_SANITIZE_STRING);
	$cbd = filter_var($_POST['cbd'], FILTER_SANITIZE_STRING);
	$flowertime = filter_var($_POST['flowertime'], FILTER_SANITIZE_STRING);

	$sql="INSERT INTO cultivars (cultivar_name, expected_thc, expected_cbd, expected_flowertime) VALUES('$cultivar','$thc','$cbd','$flowertime')";
	if ($result = mysqli_query($con, $sql)) {
	  // echo "Returned rows are: " . mysqli_num_rows($result);
	  // Free result set
	  mysqli_free_result($result);
	}
        //$cultivarid = mysqli_insert_id();
	mysqli_close($con);
	$savesuccess = 'true';
        }
*/
//        $sql = "SELECT * from inventory where plant_uniqueid = '$plant'";
$sql = "SELECT facilities.facilityname, cultivars.cultivar_name, inventory.* FROM inventory INNER JOIN cultivars ON inventory.cultivar=cultivars.id INNER JOIN facilities ON inventory.facilityid=facilities.id WHERE inventory.plant_uniqueid = '$plant'";
$result = mysqli_query($con,$sql);
$plantresults = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Calculate days-old
$date_of_spawn = $plantresults[0]['date_of_spawn'];
$datetime1 = date_create($plantresults[0]['date_of_spawn']);
$datetime2 = date_create('2021-12-23');
$daysold = date_diff($datetime1, $datetime2);
//echo $interval->format('%R%a days') . "\n";

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: Move plant</title>

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

      <h1 class="title">Move plants between areas</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align="center">Move plants between areas within the Facility</p>
	<?php if($savesuccess=='true'){ echo "<p class='content-padded'>Plant saved successfully</p>";} ?>
      <div class="card">
	<form action='admin_moveplant.php' method='post' class='input-group'>
	Select new location:<br />
        <select name='new_location' id='new_location'>
<?php
        foreach($rooms as $currentroom) {
			echo "        <option value='" . $currentroom . "'>" . $currentroom . "</option>";
			}
?>
	</select>
<?php echo "<input type='hidden' id='plantid' name='plantid' value='" . $plantid . "'>"; ?>
	  <button class="btn btn-positive btn-block" type="submit" name="submit" value="save">Submit</button>
	</form>
      </div>
    </div>
  </body>
</html>
