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
$date_of_spawn = $plantresults[0][date_of_spawn];
$datetime1 = date_create($plantresults[0][date_of_spawn]);
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
<style>
.input-row select {
  float: right;
  width: 65%;
  padding-left: 5;
  display: table-cell;
  vertical-align: middle;
  margin-bottom: 0;
  border-radius: 20px;
  margin: 3;
}
</style>

  </head>
  <body>

    <!-- Make sure all your bars are the first things in your <body> -->
    <header class="bar bar-nav">
     <a href="admin.php"><button class="btn btn-link btn-nav pull-left">
       <span class="icon icon-home"></span>
       Home
     </button></a>

      <h1 class="title">Record nutrient dosing</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align="center">Save doses of nutrients and EC-levels</p>
<?php if($savesuccess=='true'){ echo "<p class='content-padded'>Plant saved successfully</p>";} ?>
      <div class="card">
	<form action='admin_nutrients.php' method='post' class='input-group'>
        <div class="input-row">
                <label>Which Reservoir was dosed</label>
	        <select name='res_dosed' id='res_dosed'>
	        <option value='1'>Res 1</option>
	        <option value='1'>Res 2</option>
	        <option value='1'>Res 3</option>
	        <option value='1'>Res 4</option>
	        </select>
        </div>
        <div class="input-row">
                <label>How much was dosed</label>
                <input type="text" placeholder="Enter value in Litres">
        </div>
	<div class="input-row">
		<label>New liquid EC strength</label>
		<input type="text" placeholder="Enter EC strength of the new dose">
	</div>
        <div class="input-row">
                <label>Which season is this?</label>
<?php
	echo "<select name='season' id='season'>\n";
	$sql = "SELECT * from inventory where is_alive='1' group by season_id order by season_id desc limit 4";
	$result = mysqli_query($con,$sql);
	$seasonresults = mysqli_fetch_all($result, MYSQLI_ASSOC);
	        foreach($seasonresults as $currentrow) {
		echo "<option value=" . $currentrow[season_id] . ">" . $currentrow[season_id] . "</option>\n";
		}
	echo "</select>";
?>
	  <button class="btn btn-positive btn-block" type="submit" name="submit" value="save">Submit</button>
	</form>
      </div>
    </div>
  </body>
</html>
