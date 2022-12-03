<?php
require_once('tpl/config.php');
require_once('tpl/sql.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$formsubmitted = 'true';
	$visitor_name = filter_var($_POST['visitor_name'], FILTER_SANITIZE_STRING);
	$visitor_phone = filter_var($_POST['visitor_phone'], FILTER_SANITIZE_STRING);
	$visitor_purpose = filter_var($_POST['visitor_purpose'], FILTER_SANITIZE_STRING);
	$visitor_escorted_by = filter_var($_POST['escorted_by'], FILTER_SANITIZE_STRING);
	// We'll set the vars for the checkboxes
	if (filter_var($_POST['haz_light'], FILTER_SANITIZE_STRING) == "on") { $haz_light = 1; } else { $haz_light = 0; };
	if (filter_var($_POST['haz_co2'], FILTER_SANITIZE_STRING) == "on") { $haz_co2 = 1; } else { $haz_co2 = 0; };
	if (filter_var($_POST['haz_gloves'], FILTER_SANITIZE_STRING) == "on") { $haz_gloves = 1; } else { $haz_gloves = 0; };
	if (filter_var($_POST['haz_flame'], FILTER_SANITIZE_STRING) == "on") { $haz_flame = 1; } else { $haz_flame = 0; };
	// Lets see if they agreed to it all or not
	$agreed_all = $haz_light + $haz_co2 + $haz_gloves + $haz_flame;
	// Set the variable so we can use it later without having to manually update it each time if we add more hazards to check
	$agreed_sum = 4;
	if ($agreed_all == $agreed_sum) {
		//Yep we have 4x confirms so we can proceed and submit to the database
	        $sql="INSERT INTO visitors (Name, Phone, Purpose, EscortedBy, haz_light, haz_co2, haz_gloves, haz_flame) VALUES ('$visitor_name', '$visitor_phone', '$visitor_purpose', '$visitor_escorted_by', '$haz_light', '$haz_co2', '$haz_gloves', '$haz_flame')";
	        if ($result = mysqli_query($con, $sql)) {
	                // echo "Returned rows are: " . mysqli_num_rows($result);
	                // Free result set
	                //mysqli_free_result($result);
	                $savesuccess = 'true';
			$submitmsg = "<font color='green'>Details saved successfully</font>";
	                }
	        else {
	                $savesuccess = 'failed';
	                }
		}
	else {
		// They didn't agree to something so tell them they have to
		$submitmsg = "<font color='red'>Please read and acknowledge all hazard warnings</font>";
		}

	// End of IF POST
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Facility sign-in</title>

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
    <h1 class="title">Sign in to the facility</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align="center">Please enter your details to sign in to the facility</p>
<?php if($formsubmitted=='true'){ echo "<p class='content-padded' align='center'>" . $submitmsg . "</p>";} ?>
      <div class="card">
	<form action='index.php' method='post' autocomplete='off' onsubmit="return checkAllChecked()">
         <div class="input-row">
	 <label>Name:</label>
         <input type="text" placeholder="John Smith" id="visitor_name" name="visitor_name" <?php if ($agreed_sum != $agreed_all) { echo "value='$visitor_name'"; } ?>>
	 </div>
         <div class="input-row">
	 <label>Contact Phone:</label>
         <input type="number" placeholder="021 123 456" id="visitor_phone" name="visitor_phone" <?php if ($agreed_sum != $agreed_all) { echo "value='$visitor_phone'"; } ?>>
	 </div>
         <div class="input-row">
         <label>Purpose for visit:</label>
         <input type="text" placeholder="Facility tour" id="visitor_purpose" name="visitor_purpose" <?php if ($agreed_sum != $agreed_all) { echo "value='$visitor_purpose'"; } ?>>
         </div>
         <div class="input-row">
         <label>Escorted by:</label>
	 <select name='escorted_by' id='escorted_by' style="margin-top: 3px; margin-bottom: 3px; float: left; width: 63%; margin-right: 10px;">
	<?php
        foreach($escortingstaff as $currentstaff) {
            echo "<option value='" . $currentstaff . "'>" . $currentstaff . "</option>\n";
        }
?>
	 </select>
	 </div>
	 <p><input type="checkbox" id="haz_light" name="haz_light" onclick="checkAllChecked()"> I acknowledge that immediate site hazards include but are not limited to loud noise and bright lights, and I can optionally request hearing / eye protection at any time.</p>
	 <p><input type="checkbox" id="haz_co2" name="haz_co2" onclick="checkAllChecked()"> I acknowledge that in the event the CO2 warning light is on, I will not enter the rooms, for risk of asphyxiation.</p>
	 <p><input type="checkbox" id="haz_gloves" name="haz_gloves" onclick="checkAllChecked()"> I acknowledge I may be asked to wear additional protective equipment (such as masks / gloves) to enter certain portions of the facility, for the protection of the plants from externally introduced pests/viruses.</p>
	 <p><input type="checkbox" id="haz_flame" name="haz_flame" onclick="checkAllChecked()"> I acknowledge that some materials may be flammable, and have been shown the way to safely exit the facility if required.</p>
	 <button class="btn btn-positive btn-block" type="submit" name="submit" value="submit" id="submit-button" disabled>Submit details</button>
         <p id="error-message" style="display:none; color:red;">Please read and acknowledge all hazard warnings</p>
	</form>
      </div>
    </div>
<script>
// JavaScript function to check whether all checkboxes are checked
function checkAllChecked() {
    // Check if all checkboxes are checked
    if (!document.getElementById('haz_light').checked ||
        !document.getElementById('haz_co2').checked ||
        !document.getElementById('haz_gloves').checked ||
        !document.getElementById('haz_flame').checked) {
        // If not, show the error message and disable the submit button
        document.getElementById('error-message').style.display = 'block';
        document.getElementById('submit-button').disabled = true;
//        return false;
    } else {
        // If they are all checked, hide the error message and enable the submit button
        document.getElementById('error-message').style.display = 'none';
        document.getElementById('submit-button').disabled = false;
//        return true;
    }
    return false;
}
</script>
  </body>
</html>
