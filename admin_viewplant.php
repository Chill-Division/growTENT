<?php
include 'tpl/auth.php';
include 'tpl/sql.php';
include 'phpqrcode.php';

if (isset($_GET['p'])) {
        $plant = $_GET['p'];
        }
else if (isset($_POST['p'])){
        $plant = $_POST['p'];
        }
else if (isset($_POST['plant_uniqueid'])){
	// We've come from the plant scanner
	$plant = $_POST['plant_uniqueid'];
	}
else {
	//No plant set, show an empty screen. Check isset($plant) later
        }

// Check to see if we've got notes to save
if (strlen($_POST['savenotes'] > 1)) {
	// We've got something submitted, so check the length of newnotes
	$newnotes = filter_var($_POST['newnotes'], FILTER_SANITIZE_STRING);
	if (strlen($newnotes > 1 )) {
		$date = date('Y-m-d');
		$sql="INSERT INTO plant_notes (plant_uniqueid, note_date, notes) VALUES ('$plant', '$date', '$newnotes')";
		if ($result = mysqli_query($con, $sql)) {
			// echo "Returned rows are: " . mysqli_num_rows($result);
			// Free result set
			//mysqli_free_result($result);
			$savesuccess = 'true';
			}
		}
	else {
		$savesuccess = 'failed';
		}
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
        $sql = "SELECT * from inventory where plant_uniqueid = '$plant'";
//$sql = "SELECT facilities.facilityname, cultivars.cultivar_name, inventory.* FROM inventory INNER JOIN cultivars ON inventory.cultivar=cultivars.id INNER JOIN facilities ON inventory.facilityid=facilities.id WHERE inventory.plant_uniqueid = '$plant'";
$result = mysqli_query($con,$sql);
$plantresults = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Calculate days-old
$date_of_spawn = $plantresults[0]['date_of_spawn'];
$datetime1 = date_create($plantresults[0]['date_of_spawn']);
//$datetime2 = date('Y-m-d');
$datetime2 = date_create("now",timezone_open("Pacific/Auckland"));
$daysold = date_diff($datetime1, $datetime2);
//echo $interval->format('%R%a days') . "\n";


// Check if the QR code exists given we don't have all the seasons with them yet
	if (isset($plant)) {
                $fileName = $plant . ".png";
                $pngAbsoluteFilePath = 'qrcodes/' . $fileName;
                if (!file_exists($pngAbsoluteFilePath)) {
                        QRcode::png($plant, $pngAbsoluteFilePath);
                //echo 'File generated!';
                } else {
                //echo 'File already generated! We can use this cached file to speed up site on common codes!';
                }
	}

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: View plant details</title>

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

      <h1 class="title">View plant</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded">View plant details and update individual values</p>
      <?php if($savesuccess=='true'){ echo "<p class='content-padded'>Plant saved successfully</p>";} ?>
      <?php //if (isset ($plant)) { QRcode::png('some'); } ?>
      <div class="card">
	<form action='admin_viewplant.php' method='post' class='input-group'>
	 <div class="input-row">
	  <label>Cultivar: </label>
	  <input type="text" placeholder="Cultivar" name="cultivar" readonly <?php if (isset($plant)) { echo "value='" . $plantresults[0]['cultivar'] . "'"; } ?> >
	 </div>
         <div class="input-row">
          <label>Spawn date: </label>
          <input type="text" placeholder="Date of spawn" name="date_of_spawn" readonly value="<?php echo $plantresults[0]['date_of_spawn'] . " (" . $daysold->format('%a days old') . ")";   ?>">
	 </div>
         <div class="input-row">
          <label>Last moved: </label>
          <input type="text" placeholder="Never moved" name="date_of_lastmove" readonly value="<?php echo $plantresults[0]['date_of_lastmove'];?>">
         </div>
         <div class="input-row">
          <label>Location: </label>
          <input type="text" placeholder="Current location" name="where_is_it_now" readonly value="<?php echo $plantresults[0]['where_is_it_now'];?>">
	 </div>

         <div class="input-row">
          <label>Season: </label>
          <input type="text" placeholder="Season" name="season" readonly value="<?php echo $plantresults[0]['season_id'];?>">
         </div>
         <div class="input-row">
          <label>Plant #: </label>
          <input type="text" placeholder="Plant number" name="plant_num" readonly value="<?php echo $plantresults[0]['plant_num'];?>">
         </div>
         <div class="input-row">
          <label>Facility: </label>
          <input type="text" placeholder="Facility of cultivation" name="faceilityname" readonly value="<?php echo $plantresults[0]['facilityname'];?>">
         </div>
         <div class="input-row">
          <label>Plant UID: </label>
          <input type="text" placeholder="Plant Unique ID" name="plant_uniqueid" readonly value="<?php echo $plantresults[0]['plant_uniqueid'];?>">
         </div>
         <div class="input-row">
          <label>Plant alive? </label>
          <input type="text" placeholder="Is the plant still alive" name="is_alive" readonly <?php if (isset($plant)) { echo "value='"; if ($plantresults[0]['is_alive'] == '1') {echo "Yes";} else {echo "No";} echo "'"; } ?> >
         </div>
         <div class="input-row">
          <label>Current state: </label>
          <input type="text" placeholder="Current state of plant" name="current_state" value="<?php echo $plantresults[0]['current_state'];?>">
         </div>


	  <input type="hidden" name="plant_uniqueid" value="<?php echo $plant; ?>">
          <div class='content-padded'><label>Add more notes: </label>
	  <textarea name="newnotes" id="newnotes" maxlength="2048" rows="5"></textarea></div>
	  <button class="btn btn-positive btn-block" type="submit" name="savenotes" value="savenotes">Save notes</button>
	</form>
        <button class="btn btn-positive btn-block">Reprint label</button>
        <form action='admin_moveplant.php' method='post' class='input-group'>
          <input type="hidden" name="plantid" value="<?php echo $plantresults[0]['plant_uniqueid']; ?>">
          <button class="btn btn-positive btn-block" type="submit" name="moveplant" value="moveplant">Move plant</button>
        </form>
        <form action='admin_takecuttings.php' method='post' class='input-group'>
          <input type="hidden" name="mother_plantid" value="<?php echo $plantresults[0]['plant_uniqueid']; ?>">
	  <input type="hidden" name="cultivar" value="<?php echo $plantresults[0]['cultivar']; ?>">
          <button class="btn btn-positive btn-block" type="submit" name="takecuttings" value="takecuttings">Take cuttings</button>
        </form>
	<?php if (isset($plant)) {
	$sql="SELECT * from plant_notes where plant_uniqueid='$plant' order by id desc";
	$result = mysqli_query($con,$sql);
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach($row as $currentrow) {
		echo "<div class='content-padded'><p><strong>" . $currentrow['note_date'] . ":</strong> " . nl2br($currentrow['notes']) . "</p></div>";
		}
	}
?>
      </div>
    </div>
  </body>
</html>
