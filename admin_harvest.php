<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

// Start by grabbing the plantid from the viewplant page
$plant=$_POST['plantid'];

// If we've submitted the form we'll need the wet weight too
$ww=$_POST['ww'];

$willdry=$_POST['willdry'];

// Set the date here just to be helpful for later db queries
$date = date('Y-m-d');


// Now we check to see if we've been given a weight to save, submit it to db if-so:
if ($ww > '1'){
	$updatesql="UPDATE inventory SET harvest_ww='$ww',current_state='Harvested',date_of_harvest='$date',is_alive='0',harvest_dw=NULL where plant_uniqueid='$plant'";
	// However if we're setting a dry weight later we want to use this instead:
	if ($willdry == 'on') {
		$updatesql="UPDATE inventory SET harvest_ww='$ww',current_state='Harvested',date_of_harvest='$date',is_alive='0',harvest_dw='0' where plant_uniqueid='$plant'";
		}
	// Now we submit the db and mark it as harvested
	if ($result = mysqli_query($con, $updatesql)) {
		$savesuccess = 'true';
		}
	}

// Now we look up the *latest* data from the DB rather than the POST
// There was a reason why I wanted it this way but I can't remember...
$sql = "SELECT * from inventory where plant_uniqueid = '$plant'";
$result = mysqli_query($con,$sql);
$plantresults = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Update the cultivar
$cultivar = $plantresults[0]["cultivar"];


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: Harvest plant</title>

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

      <h1 class="title">Harvest a plant</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align='center'>Provide plant weight for harvest accounting</p>
      <p class="content-padded" align='center'><strong>NOTE: This will mark the plant as harvested / no longer alive</strong></p>
<?php if($savesuccess=='true'){ echo "<p class='content-padded' align='center'><font color='red'>Saved!</font></p>";} ?>
      <div class="card">
<?php if($_POST['submitweight']!='submitweight'){
	echo"<p class='content-padded' align='center'><strong>NOTE: This will mark the plant as harvested / no longer alive</strong></p>
	<form action='admin_harvest.php' method='post' class='input-group'>
         <div class='input-row'>
          <label>Cultivar: </label>
          <input type='text' placeholder='Cultivar' name='cultivar' readonly value='$cultivar'>
         </div>
         <div class='input-row'>
          <label>Plant UID: </label>
          <input type='text' placeholder='Plant Unique ID' name='plantid' id='plantid' readonly value='$plant'>
         </div>
	<div class='input-row'><label>Wet weight (g)</label><input type='number' name='ww' id='ww' label='wetwight' placeholder='2450'></div>
	<div class='input-row'><label>Dry weight later?</label><input type='checkbox' name='willdry' id='willdry' label='willdry' style='margin-top: 10px'></div>
	<button class='btn btn-positive btn-block' type='submit' name='submitweight' value='submitweight'>Submit weight</button>
	</form>";
	}
else {
	// Plant is harvested so ask what they want to do instead, optional warning
	if ($willdry == 'on') {
		// They've said they'll keep a dry weight so show the alert
		echo "<p class='content-padded' align='center'><strong>NOTE: You MUST keep the tag for the plant to add the dry weight afterwards.</strong></p>";
		}
	echo "	<table width='100%'><tbody width='100%'><tr width='100%'>
        <td width='50%' style='padding: 10px;'><a href='admin_scanplant.php'><button class='btn btn-primary btn-block'>Scan another</button></a></td>
        <td width='50%' style='padding: 10px;'><form action='admin_viewplant.php' method='post' class='input-group'>
                <input type='hidden' name='plantid' value='$plant'>
                <button class='btn btn-positive btn-block' type='submit' name='viewplant' value='viewplant'>Back to plant view</button></form></td>
        </tr></tbody></table>";
	}
?>
      </div>
    </div>

  </body>
</html>
