<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

// Grab a few details from the View Plant page so we know what we're putting into the database
$mother_plantid = $_POST['mother_plantid'];
$cultivar = $_POST['cultivar'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: Take cuttings</title>

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

      <h1 class="title">Take cuttings</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align='center'>Take cuttings from a mother-plant or from one currently in vege.</p>
	<div class="card">
<?php if (isset($mother_plantid)) {
	// The content can go in here
	echo "<form action='admin_takecuttings_print.php' method='post' class='input-group'>";
	echo "Looks like you want to take some $cultivar cuttings from $mother_plantid.<br />How many would you like?";
	echo "<input type='text' placeholder='Number of cuttings' name='newplants' maxlength='2'>\n";
	// Add the hidden types so we know what to submit
	echo "<input type='hidden' name='mother_plantid' value='" . $mother_plantid . "'>\n";
	echo "<input type='hidden' name='cultivar' value='" . $cultivar . "'>\n";
        echo "<button class='btn btn-positive btn-block' type='submit' name='submit' value='save'>Take cuttings</button>\n";
	echo "</form>\n";
	}
	else {
	echo "<p>You haven't specified a plant and shouldn't be here.<br />Please contact your administrator and let them know how this happened, so that can be fixed.</p>";
	echo "<p>In the mean time, go back, scan the plant you want to take cuttings from, and choose 'Take cuttings'.</p>";
	}
?>
      </div>
    </div>

  </body>
</html>
