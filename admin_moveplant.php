<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

if (isset($_GET['plantid'])) {
	$plantid = $_GET['plantid'];
	}

if (isset($_POST['plantid'])) {
	$plantid = $_POST['plantid'];
	}

// Process / flow is scan the plant, select the new location, go back to showing the plant

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
	<form action='admin_viewplant.php' method='post' class='input-group'>
	<p class='content-padded' Select new location:<br />
        <select name='new_location' id='new_location' style='margin-top: 3px; margin-bottom: 3px;'>
<?php
        foreach($rooms as $currentroom) {
			echo "        <option value='" . $currentroom . "'>" . $currentroom . "</option>\n";
			}
?>
	</select></p>
<?php echo "<input type='hidden' id='plantid' name='plantid' value='" . $plantid . "'>\n"; ?>
	  <button class="btn btn-positive btn-block" type="submit" name="submit" value="save">Submit</button>
	</form>
      </div>
    </div>
  </body>
</html>
