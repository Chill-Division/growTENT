<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

// Pull the details of the cultivars etc coz we're going to need those:
// Eventually we'll put the Facilities in here too but I'm lazy so this is a note for future-me
$sql = "SELECT id,cultivar_name from cultivars";
$result = mysqli_query($con,$sql);

$cultivars = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: View inventory</title>

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

      <h1 class="title">Harvested inventory</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align="center">Current inventory (all alive plants)</p>
      <div class="card">
<?php
	// LazyJo says we'll need to also INNER JOIN on Facility in the future
	// But that's a problem for future-me
	// $sql = "SELECT cultivars.cultivar_name, inventory.id, inventory.plant_uniqueid, inventory.season_id, inventory.where_is_it_now, inventory.plant_num FROM inventory INNER JOIN cultivars ON inventory.cultivar=cultivars.id ORDER BY inventory.id DESC LIMIT 500";
	$sql = "SELECT * FROM inventory WHERE current_state='Harvested' ORDER BY date_of_harvest DESC LIMIT 500";
	$result = mysqli_query($con,$sql);
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo "  <ul class='table-view'>\n";
	foreach($row as $currentrow) {
		echo "  <li class='table-view-cell'>\n<a href='admin_viewplant.php?p=" . $currentrow['plant_uniqueid'] . "' class='navigate-right'>" . $currentrow['cultivar'] . ", WW " . $currentrow['harvest_ww'] . ", Harvested: " . $currentrow['date_of_harvest'] . ", Plant # " . $currentrow['plant_num'] . ", Unique ID: " . $currentrow['plant_uniqueid'] . "</a></li>";
//		echo "  <li class='table-view-cell'>" . $currentrow[cultivar_name] . " " . $currentrow[plant_uniqueid] . "<a href='admin_viewplant.php?p=" . $currentrow[plant_uniqueid] . "' class='navigate-right'>View</a></li>";
	}
	echo "</ul><br />\n";
?>

	</form>
      </div>
    </div>

  </body>
</html>
