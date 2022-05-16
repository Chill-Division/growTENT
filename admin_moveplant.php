<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

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


/*
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
<?php if (isset($season)) {
	// Season is set so show them JUST a list of plants from that season
	// If it's not set, then show them the list of seasons to modify
	// We do the SQL first so that we can get a count
        $sql = "SELECT * from inventory where is_alive='1' AND season_id='$season' order by plant_num asc";
        $result = mysqli_query($con,$sql);
        $seasonresults = mysqli_fetch_all($result, MYSQLI_ASSOC);

	echo "Showing " . $season . ", found " . count($seasonresults) . " plants";
	echo "  <ul class='table-view'>\n";
        foreach($seasonresults as $currentrow) {
		echo "    <li class='table-view-cell'>Plant " . $currentrow['plant_num'] . ", currently in " . $currentrow['where_is_it_now'] . "</li>\n";
		//print_r($currentrow);
		}
	echo "</ul>\n";
	echo "Select new location:<br />
        <select name='new_location' id='new_location'>
        <option value='Nursery'>Nursery</option>
        <option value='MotherTent'>MotherTent</option>
        <option value='Vege1'>Vege1</option>
        <option value='Vege2'>Vege2</option>
        <option value='Flower1'>Flower1</option>
        <option value='Flower2'>Flower2</option>
        </select>";
	// We add a hidden input so we can get the season next time again without asking twice
	echo "<input type='hidden' id='confirmedseason' name='confirmedseason' value='" . $season . "'>";

	}
	else {
	// Guess it's not set so we're going to show you a list of seasons so you can choose one to modify
	echo "<select name='season' id='season'>\n";
	$sql = "SELECT * from inventory where is_alive='1' group by season_id order by season_id desc";
	$result = mysqli_query($con,$sql);
	$seasonresults = mysqli_fetch_all($result, MYSQLI_ASSOC);
	        foreach($seasonresults as $currentrow) {
		echo "<option value=" . $currentrow['season_id'] . ">" . $currentrow['season_id'] . "</option>\n";
		}
	echo "</select>";
	}
?>
	  <button class="btn btn-positive btn-block" type="submit" name="submit" value="save">Submit</button>
	</form>
      </div>
    </div>
  </body>
</html>
