<?php
include 'tpl/auth.php';
include 'tpl/sql.php';
$plant = $_POST['plantid'];

// Set the date here just to be helpful for later db queries
$date = date('Y-m-d');

if($_POST['submitdisposal']=='submitdisposal'){
        // Grab the disposal reason
        $disposal_reason = filter_var($_POST['disposal_reason'], FILTER_SANITIZE_STRING);
	$newnotes = filter_var($_POST['newnotes'], FILTER_SANITIZE_STRING);
	// The first thing we want to do is add a note for the plant so it'll show up in the View Plant history
	// If we have custom notes we want to include those too
	if (strlen($_POST['newnotes'] > 2)) {
		$full_disposal_notes = "Plant has been disposed of - $disposal_reason. $newnotes";
		}
        else {
		$full_disposal_notes = "Plant has been disposed of - $disposal_reason";
		}
        // Now we submit the initial disposal note for the plant into the database
	$updatesql="INSERT INTO plant_notes (plant_uniqueid, note_date, notes) VALUES ('$plant', '$date', '$full_disposal_notes')";
        if ($result = mysqli_query($con, $updatesql)) {
                $savesuccess = 'true';
                }
	// Then we do it again, setting the Inventory status so it's marked as no longer being alive
        $updatesql="UPDATE inventory SET current_state='Disposed of - $disposal_reason',is_alive='0',date_of_disposal='$date' WHERE plant_uniqueid='$plant'";
	// Then pop it into the DB
        if ($result = mysqli_query($con, $updatesql)) {
                $savesuccess = 'true';
                }
        }


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
    <title>growTENT :: Disposal</title>

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
    <script src="html5-qrcode.min.js"></script>
  </head>
  <body>

    <!-- Make sure all your bars are the first things in your <body> -->
    <header class="bar bar-nav">
     <a href="admin.php"><button class="btn btn-link btn-nav pull-left">
       <span class="icon icon-home"></span>
       Home
     </button></a>

      <h1 class="title">Plant disposal</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align='center'>Disposal of complete plants and removing them from the registry</p>
<?php if($savesuccess=='true'){ echo "<p class='content-padded' align='center'><font color='red'>Saved!</font></p>";} ?>
      <div class="card">
<?php
if($_POST['submitdisposal']!='submitdisposal'){
echo "<form action='admin_dispose.php' method='post' class='input-group'>
         <div class='input-row'>
          <label>Cultivar: </label>
          <input type='text' placeholder='Cultivar' name='cultivar' readonly value='$cultivar'>
         </div>
         <div class='input-row'>
          <label>Plant UID: </label>
          <input type='text' placeholder='Plant Unique ID' name='plantid' id='plantid' readonly value='$plant'>
         </div>
	<p class='content-padded'>Select disposal reason: <br />
        <select name='disposal_reason' id='disposal_reason' style='margin-top: 3px; margin-bottom: 3px;'>";

        foreach($disposalreasons as $currentreason) {
                        echo "        <option value='" . $currentreason . "'>" . $currentreason . "</option>\n";
                        }
echo "        </select>
	 </p>
         <div class='content-padded'><label>Additional notes: </label>
          <textarea name='newnotes' id='newnotes' maxlength='2048' rows='3'></textarea></div>
        <button class='btn btn-positive btn-block' type='submit' name='submitdisposal' value='submitdisposal'>Submit disposal</button>
      </div>";
	}

else {
	print_r($newnotes);
        echo "  <table width='100%'><tbody width='100%'><tr width='100%'>
        <td width='50%' style='padding: 10px;'><a href='admin_scanplant.php'><button class='btn btn-primary btn-block'>Scan another</button></a></td>
        <td width='50%' style='padding: 10px;'><form action='admin_viewplant.php' method='post' class='input-group'>
                <input type='hidden' name='plantid' value='$plant'>
                <button class='btn btn-positive btn-block' type='submit' name='viewplant' value='viewplant'>Back to plant view</button></form></td>
        </tr></tbody></table>";
        }
?>

    </div>

  </body>
</html>
