<?php
include 'tpl/auth.php';
include 'tpl/sql.php';
include 'phpqrcode.php';

if ((strlen($_POST['submit']) > 1) && (strlen($_POST['cultivar']) > 1)) {
	$cultivar = filter_var($_POST['cultivar'], FILTER_SANITIZE_STRING);
	$thc = filter_var($_POST['thc'], FILTER_SANITIZE_STRING);
	$cbd = filter_var($_POST['cbd'], FILTER_SANITIZE_STRING);
	$flowertime = filter_var($_POST['flowertime'], FILTER_SANITIZE_STRING);

	$sql="INSERT INTO cultivars (cultivar_name, expected_thc, expected_cbd, expected_flowertime) VALUES('$cultivar','$thc','$cbd','$flowertime')";
	if ($result = mysqli_query($con, $sql)) {
	  echo "Returned rows are: " . mysqli_num_rows($result);
	  // Free result set
	  mysqli_free_result($result);
	}
        //$cultivarid = mysqli_insert_id();
	mysqli_close($con);
	$savesuccess == 'true';
        }
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Scan QR code</title>

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

      <h1 class="title">Scan plant QR</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded">Scan (or manually enter) the plant details to look it up</p>
<?php if($savesuccess=='true'){ echo "<p class='content-padded'>New cultivar saved successfully</p>";} ?>
      <div class="card">
      <div id="reader"></div>
<script>
var html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 250 });
function onScanSuccess(decodedText, decodedResult) {
    // Handle on success condition with the decoded text or result.
    console.log(`Scan result: ${decodedText}`, decodedResult);
    document.getElementById("plant_uniqueid").value = decodedText;
    // ...
    html5QrcodeScanner.clear();
    // ^ this will stop the scanner (video feed) and clear the scan area.
}

html5QrcodeScanner.render(onScanSuccess);

</script>
	<form action='admin_relabel.php' method='post'>
	  <input type="text" placeholder="Scan barcode or type Plant UniqueID" name="plant_uniqueid" id='plant_uniqueid'>
	  <button class="btn btn-positive btn-block" type="submit" name="search" value="search">Search</button>
	</form>
      </div>
    </div>

  </body>
</html>
